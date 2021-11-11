<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ClientSafeApi;
use App\Helpers\CommonHelper;
use App\Models\User;

class PublicController extends Controller
{
    public function __construct(ClientSafeApi $safe_api)
    {
        $this->safe_api = $safe_api;
    }

    public function preregistered(Request $request)
    {
        $request->validate([
            'safe_id' => 'required',
            'phone' => 'required',
        ]);
        $safe_id = CommonHelper::cleanUsername($request->query('safe_id'));
        $anchor_id = CommonHelper::normalizeUsername($safe_id);
        $phone = CommonHelper::normalizePhone($request->query('phone'));

        // check if they're an existing user
        $user = User::where('safe_id', $safe_id)->first();
        if ($user) {
            return response()->json(['status' => false, 'message' => 'User already exists'], 422);
        }

        // now let's check if given SAFE_ID exists and is linked to this app
        $check = $this->safe_api->call('prompt', [
            'client_application_user_aid' => $anchor_id,
            'client_application_user_phone' => $phone,
        ]);

        $r = json_decode($check['json_body']);
        if (isset($check['error']) && $check['error'] == true) {
            return response()->json([
                'status' => false,
                'message' => $r->description ?? null,
            ], 422);
        }

        $access_token = $this->safe_api->getAccessToken($anchor_id);
        if (!$access_token) {
            return response()->json([
                'status' => false,
                'message' => 'no access token',
            ], 422);
        }
        
        //Get user profile details
        $details = $this->safe_api->call('consumer', ['aid' => $anchor_id, 'access_token' => $access_token]);
        $r = json_decode($details['json_body']);

        if (isset($details['error']) && $details['error'] == true) {
            return response()->json([
                'status' => false,
                'message' => $r->description ?? null,
            ], 422);
        }

        if (isset($r->description->consumer)) {
            $profile = $r->description->consumer;
        }

        // at this point we know that this is a new client for our app
        // no user has been associated between this safe_id and our app
        // now we need to tell SAFE to add our user to their system

        //create new user internally
        try {
            $user = new User;
            $user->safe_id = $safe_id;
            $user->name = $profile->name ?? null;
            $user->email = $profile->email ?? str_random(10).'@thesafebutton.com';
            $user->mobile = $profile->phone ?? null;
            $user->password = bcrypt('testing');
            $user->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?? null,
            ], 422);
        }

        //DO PROMPT linking now, assign newly created internal user_id with Safe ($newUser->id  => $aid)
        $prompt = $this->safe_api->call('prompt', [
            'client_application_user_id' => $user->id,
            'client_application_user_aid' => $anchor_id,
            'client_application_user_phone' => $user->mobile,
        ]);
        $r = json_decode($details['json_body']);

        if (isset($prompt['error']) && $prompt['error'] == true) {
            return response()->json([
                'status' => false,
                'message' => $r->description ?? null,
            ], 422);
        }

        return response()->json(['status' => true], 201);
    }

    public function showPin(Request $request)
    {
        if ($request->session()->has('aid_transaction')) {
            $aid_transaction = $request->session()->get('aid_transaction');
            $status = $aid_transaction->status ?? null;
            $anchor_id = session()->get('anchorid');
            $safe_id = CommonHelper::cleanUsername($anchor_id);
        }

        if (isset($status) && $status == 'PROCESS') {
            $title = 'Login to your account';
            return view('auth.show-pin', compact('title', 'anchor_id', 'safe_id'));
        } else {
            return redirect()->route('contacts.index')->with('error', 'Unable to init signin.');
        }
    }

    public function unregister(Request $request)
    {
        //validator
        $request->validate([
            'safe_id' => 'required',
            'token' => 'required',
        ]);
        $safe_id = CommonHelper::cleanUsername($request->safe_id);
        $anchor_id = CommonHelper::normalizeUsername($safe_id);
        $token = $request->token;
        $client_id = config('safe.client_id');
        $client_secret = config('safe.client_secret');

        if (base64_decode($token) != $client_id.':'.$client_secret) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $user = User::where('safe_id', $safe_id)->firstOrFail();
        $user->delete();

        return response()->json([
            'safe_id' => $anchor_id,
            'client_id' => $client_id,
        ]);
    }
}
