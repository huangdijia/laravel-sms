<?php

return [
    'default' => 'local',

    'drivers' => [
        'local'     => [
            'driver' => \Huangdijia\Sms\Drivers\Local::class,
        ],
        'accessyou' => [
            'driver'         => \Huangdijia\Sms\Drivers\Accessyou::class,
            'account'        => env('ACCESSYOU_ACCOUNT', ''),
            'password'       => env('ACCESSYOU_PASSWORD', ''),
            'check_user'     => env('ACCESSYOU_CHECK_USER', ''),
            'check_password' => env('ACCESSYOU_CHECK_PASSWORD', ''),
        ],
        'mitake'    => [
            'driver'   => \Huangdijia\Sms\Drivers\Mitake::class,
            'username' => env('MITAKE_USERNAME', ''),
            'password' => env('MITAKE_PASSWORD', ''),
            'encoding' => env('MITAKE_ENCODING', 'big5'),
        ],
        'mxtong'    => [
            'driver'          => \Huangdijia\Sms\Drivers\Mxtong::class,
            'user_id'         => env('MXTONG_USER_ID', ''),
            'account'         => env('MXTONG_ACCOUNT', ''),
            'password'        => env('MXTONG_PASSWORD', ''),
            'send_type'       => 1,
            'post_fix_number' => 1,
        ],
        'smspro'    => [
            'driver'   => \Huangdijia\Sms\Drivers\Smspro::class,
            "username" => env('SMSPRO_USERNAME', ''),
            "password" => env('SMSPRO_PASSWORD', ''),
            "sender"   => env('SMSPRO_SENDER', ''),
        ],
        'twsms'     => [
            'driver'   => \Huangdijia\Sms\Drivers\Twsms::class,
            'account'  => env('TWSMS_ACCOUNT', ''),
            'password' => env('TWSMS_PASSWORD', ''),
            'type'     => env('TWSMS_TYPE', 'now'),
            'encoding' => env('TWSMS_ENCODING', 'big5'),
            'vldtime'  => env('TWSMS_VLDTIME', ''),
            'dlvtime'  => env('TWSMS_DLVTIME', ''),
        ],
    ],
];
