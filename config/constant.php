<?php

$enviorment = env('APP_ENV');

if ($enviorment == 'local') {
    return[
        'mail_status' => 'ON',
        'email' => [
            'MAIL_ADMIN_USERNAME' => 'mukesh.mali@radixweb.com',
        ],
    ];
}
