<?php

return [
    'client_id' => env('SAFE_CLIENT_ID'),
    'client_secret' => env('SAFE_CLIENT_SECRET'),
    'client_safe_id' => env('SAFE_CLIENT_SAFE_ID'),
    'uri_oauth2' => env('URI_OAUTH'),
    'uri_signin' => env('URI_API').'/signin',
    'uri_transaction' => env('URI_API').'/transaction',
    'uri_prompt' => env('URI_API').'/prompt',
    'uri_checkclientaid' =>env('URI_API').'/checkclientaid',
    'uri_consumer' => env('URI_API').'/consumer',
    'uri_application' => env('URI_API').'/application',
];
