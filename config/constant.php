<?php

$enviorment = env('APP_ENV');

if ($enviorment == 'local') {
    return[
        'mail_status' => 'ON',
        'email' => [
            'MAIL_ADMIN_USERNAME' => 'mukesh.mali@radixweb.com',
        ],

        'paypal' => [
            'PAYPAL_SANDBOX' => true,
            'PAYPAL_CURRENCY' => "USD",
            'PAYPAL_CLIENT_ID' => "AeOcdZeCgH0YUvPERc9y4ujeT4Fu1jifxrNnNl8vAI5q59OYZBozKfsPIwuBb3mxAc-21t7JhGPhV6IY",
            'PAYPAL_CLIENT_SECRET' => "EOqlUNvmGYAZ7Vxpo0WWPm2b8qAtQjOVmmYeiIl27lD4br7q3aM6PK54O1y59VlnrIwMolf__YE9NzdS",
            // 'PAYPAL_SIGNATURE' => "AgRak4ODOk2p3XD5MQf46daOlpuJAj9uwqduvsCDe9Z6Rh78DacmiGEt",
            // 'PAYPAL_APP_ID' => "APP-80W284485P519543T",
            'PAYPAL_OAUTH_API' => "https://api.sandbox.paypal.com/v1/oauth2/token/",
            'PAYPAL_ORDER_API' => "https://api.sandbox.paypal.com/v2/checkout/orders/",
            'PAYPAL_TEST_MODE' => true,
            'PAYPAL_PAYOUTS' => 'https://api.sandbox.paypal.com/v1/payments/payouts'
        ],


    ];
}
