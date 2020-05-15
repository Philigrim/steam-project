<?php
return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host'   => env('MAIL_HOST', 'smtp.gmail.com'),
    'port'   => env('MAIL_PORT', 465),
    'from'   => [
       'address' => env('MAIL_FROM_ADDRESS', 'steamcentras@gmail.com'),
       'name' => env('MAIL_FROM_NAME', 'Example')
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => env('MAIL_USERNAME', 'steamcentras@gmail.com'),
    'password' => env('MAIL_PASSWORD', 'uifjhxyayhhgmfjd'),
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => FALSE,
];
