<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Requests\Auth\LoginSafeRequest;
use App\Models\User;
use App\Helpers\ClientSafeApi;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(ClientSafeApi $safe_api)
    {
        $this->safe_api = $safe_api;
    }

    public function loginSafe(LoginSafeRequest $request)
    {
        $safe_id = CommonHelper::cleanUsername($request->input('safe_id'));
        $anchor_id = CommonHelper::normalizeUsername($safe_id);

        // check if they're an existing user
        $user = User::where('safe_id', $safe_id)->first();
        if (!$user) {
            return redirect()->back()->with('error', $safe_id.' not found within this site users.');
        }

        $access_token = $this->safe_api->getAccessToken($anchor_id);
        if (!$access_token) {
            return redirect()->back()->with('error', 'Unable to get access token.');
        }
        session()->put('anchorid', $anchor_id);
        session()->put('aid_access_token', $access_token);

        //Sign In Initiation:
        $init_signin = $this->safe_api->call('init_signin', ['aid' => $anchor_id, 'access_token' => $access_token]);
        $r = json_decode($init_signin['json_body']);

        if (isset($r->description->transaction)) {
            session()->put('aid_transaction', $r->description->transaction);
            return redirect()->route('show_pin');
        } else {
            switch ($r->status) {
                case 1335:
                    $e = "Transaction is in process. Please give it upto 1 minute and then try to login again";
                    break;
                default:
                    $e = $r->description;
            }
            return redirect()->back()->with('error', $e);
        }
    }
    
    public function SignInStatusCheck(Request $request)
    {
        $res = array(
            'error' => false,
            'error_message' => null,
            'status' => null,
            'redirect' => null,
            'logged_in' => false,
        );
        $anchor_id = $request->aid;
        if(!$request->filled('aid')){
            $res['error'] = true;
            $res['error_message'] = 'Missing safe id';
            return response()->json($res);
        }
        
        if ($request->session()->has('aid_transaction')) {
            $tx = $request->session()->get('aid_transaction', null);
            $transactionId = $tx->transactionId;
            $access_token = $request->session()->get('aid_access_token');
        }
        
        if(empty($transactionId) || empty($access_token)){
            $res['error'] = true;
            $res['error_message'] = 'Missing transaction Id!';
            return response()->json($res);
        }

        $signin = $this->safe_api->call('signin_status_check', ['transactionId' => $transactionId, 'access_token' => $access_token]);
        $r = json_decode($signin['json_body']);

        if ($signin['error'] === false) {
            $status = $r->description->transaction->status;
            switch ($status) {
                case 'PROCESS':
                $res['status'] = 'PROCESS';
                break;
    
                case 'TIMED_OUT':
                break;
    
                case 'DECLINED':
                break;
    
                case 'ABORTED':
                break;
    
                case 'AUTHORIZED':
                $res['status'] = 'AUTHORIZED';
                // $res['redirect'] = $r->description->client_app->redirectUrl; //optional from app settings
                $res['redirect'] = route('contacts.index'); //or explicit
    
                // check if they're an existing user and log user in if exist
                $safe_id = CommonHelper::cleanUsername($anchor_id);
                $user = User::where('safe_id', $safe_id)->first();
                if ($user) {
                    $logged_in = auth()->login($user, true);
                    $res['logged_in'] = $logged_in;
                }
                break;
            }
        } else {
            $res['error'] = true;
            $res['error_message'] = $r->description;
        }

        return response()->json($res);
    }

    public function killSession()
    {
        session()->flush();
    }
}