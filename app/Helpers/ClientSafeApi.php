<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class ClientSafeApi
{
    public $settings;

    public function __construct(Client $guzzle)
    {
        $this->settings = (object) config('safe');
        $this->guzzle = $guzzle;
    }

    public function call($action, $data)
    {
        $settings = $this->settings;
        $client_secret = $settings->client_secret ?? null;

        switch ($action) {
            case 'prompt':
                $method = 'POST';
                $url = $settings->uri_prompt;
                $auth = array($settings->client_id, $settings->client_secret);
                $body = array(
                    'client_application_id' => $settings->client_id,
                    'client_application_user_id' => $data['client_application_user_id'] ?? null,
                    'client_application_user_aid' => $data['client_application_user_aid'] ?? null,
                    'client_application_user_phone' => $data['client_application_user_phone'] ?? null,
                    'client_application_user_name' => $data['client_application_user_name'] ?? null,
                    'client_application_user_email' => $data['client_application_user_email'] ?? null,
                    'send_sms' => $data['send_sms'] ?? null,
                );
                $params = array(
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'auth' => $auth,
                    'json' => $body,
                );
            break;

            case 'checkclientaid':
                $method = 'POST';
                $url = $settings->uri_checkclientaid;
                $body = array(
                    'client_application_id' => $settings->client_id,
                    'client_application_user_id' => $data['client_application_user_id'] ?? null,
                    'client_application_user_aid' => $data['client_application_user_aid'] ?? null,
                );
                $params = array(
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => "Bearer {$data['access_token']}",
                    ],
                    'json' => $body,
                );
                break;   

            case 'consumer':
                $method = 'GET';
                $url = $settings->uri_consumer;
                $query = "id={$data['aid']}";
                $params = array(
                    'headers' => [
                        'Authorization' => "Bearer {$data['access_token']}"
                    ],
                    'query' => $query,
                );
                break;

            case 'get_auth_code':
                $method = 'POST';
                $url = $settings->uri_oauth2;
                $body = array(
                    'client_id' => $settings->client_id,
                    'response_type' => 'code',
                    'anchorid' => $data['aid'],
                );
                $params = array(
                    'json' => $body,
                );
                break;

            case "get_access_token":
                $method = 'POST';
                $url = $settings->uri_oauth2;
                $auth = array($settings->client_id, $settings->client_secret);
                $body = array(
                    'client_id' => $settings->client_id,
                    'anchorid' => $data['aid'],
                    'grant_type' => 'authorization_code',
                    'code' => $data['code'],
                );
                $params = array(
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'auth' => $auth,
                    'json' => $body,
                );
                break;

            case "init_signin":
                $method = 'POST';
                $url = $settings->uri_signin;
                
                $body = array(
                    'client_id' => $settings->client_id,
                    'anchorid' => $data['aid'],
                    'grant_type' => 'authorization_code',
                );
                $params = array(
                    'headers' => [
                        'Authorization' => "Bearer {$data['access_token']}"
                    ],
                    'json' => $body,
                );
                break;

            case "signin_status_check":
                $method = 'GET';
                $url = $settings->uri_transaction;
                $query = "id={$data['transactionId']}";
                $params = array(
                    'headers' => [
                        'Authorization' => "Bearer {$data['access_token']}"
                    ],
                    'query' => $query,
                );
                break;

            case "deactivate_user":
                $method = 'PUT';
                $url = $settings->uri_application;

                $body = array(
                    'app_id' => $settings->client_id,
                    'id' => $data['aid'],
                    'client_user_id' => $data['client_user_id'],
                    'active' => $data['active'],
                );
                $params = array(
                    'headers' => [
                        'Authorization' => "Bearer {$data['access_token']}"
                    ],
                    'json' => $body,
                );
                break;
        }

        try {
            $response = $this->guzzle->request($method, $url, $params);
            } catch (RequestException $e) {
                $error = true;
                if ($e->hasResponse()) {
                    $error_response =  $e->getResponse();
                    $json_body = (string) $error_response->getBody();

                }
                return [
                    'error' => $error,
                    'msg' => $error_response ?? null,
                    'json_body' => $json_body ?? null,
                ];
            }

            $response_status = $response->getStatusCode(); 
            $response_contents = $response->getBody()->getContents();

            return [
                'error' => false,
                'response_status' => $response_status,
                'json_body' => $response_contents,
            ];
    }

    public function getAccessToken($safe_id){
        $data = array('aid' => $safe_id);
        $code = $this->call('get_auth_code', $data);
        $r = json_decode($code['json_body']);
        $code = $r->description->code ?? null;
        $data['code'] = $code;
        $access_token = $this->call('get_access_token', $data);
        $r = json_decode($access_token['json_body']);  
        $token = $r->access_token ?? null;

        return $token;
    }
}