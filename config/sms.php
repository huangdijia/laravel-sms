<?php

return [
    'default' => 'local',

    'drivers' => [
        'local'     => [
            'driver' => \Huangdijia\Sms\Drivers\Local::class,
        ],
        'accessyou' => [
            'send_url'       => 'http://basic.accessyou-api.com/sms/sendsms-utf8-senderid.php', // ?accountno=11032727&pwd=85918591&from=K8591&phone=85298882844&msg=hello
            'check_url'      => 'https://q.accessyou-api.com/sms/check_accinfo.php', // ?accountno=%s&user=%s&pwd=%s
            'driver'         => \Huangdijia\Sms\Drivers\Accessyou::class,
            'account'        => env('ACCESSYOU_ACCOUNT', ''),
            'password'       => env('ACCESSYOU_PASSWORD', ''),
            'from'           => env('ACCESSYOU_FROM', ''),
            'size'           => env('ACCESSYOU_SIZE', 'l'),
            'check_user'     => env('ACCESSYOU_CHECK_USER', ''),
            'check_password' => env('ACCESSYOU_CHECK_PASSWORD', ''),
            'tries'          => 1,
        ],
        'mitake'    => [
            'send_url' => 'http://smexpress.mitake.com.tw:9600/SmSendGet.asp',
            'driver'   => \Huangdijia\Sms\Drivers\Mitake::class,
            'username' => env('MITAKE_USERNAME', ''),
            'password' => env('MITAKE_PASSWORD', ''),
            'encoding' => env('MITAKE_ENCODING', 'big5'),
            'tries'    => 1,
        ],
        'mxtong'    => [
            'send_url'        => 'http://www.mxtong.cn:8080/GateWay/Services.asmx/DirectSend',
            'driver'          => \Huangdijia\Sms\Drivers\Mxtong::class,
            'user_id'         => env('MXTONG_USER_ID', ''),
            'account'         => env('MXTONG_ACCOUNT', ''),
            'password'        => env('MXTONG_PASSWORD', ''),
            'send_type'       => 1,
            'post_fix_number' => 1,
            'tries'           => 1,
        ],
        'smspro'    => [
            'send_url'  => 'https://api3.hksmspro.com/service/smsapi.asmx/SendSMS',
            'check_url' => 'https://api3.hksmspro.com/service/smsapi.asmx/GetBalance',
            'driver'    => \Huangdijia\Sms\Drivers\Smspro::class,
            "username"  => env('SMSPRO_USERNAME', ''),
            "password"  => env('SMSPRO_PASSWORD', ''),
            "sender"    => env('SMSPRO_SENDER', ''),
            'tries'     => 1,
        ],
        'twsms'     => [
            'send_url' => 'http://api.twsms.com/send.php',
            'driver'   => \Huangdijia\Sms\Drivers\Twsms::class,
            'account'  => env('TWSMS_ACCOUNT', ''),
            'password' => env('TWSMS_PASSWORD', ''),
            'type'     => env('TWSMS_TYPE', 'now'),
            'encoding' => env('TWSMS_ENCODING', 'big5'),
            'vldtime'  => env('TWSMS_VLDTIME', ''),
            'dlvtime'  => env('TWSMS_DLVTIME', ''),
            'tries'    => 1,
        ],
        'aliyun'    => [
            'driver'        => \Huangdijia\Sms\Drivers\Aliyun::class,
            'access_key'    => env('ALIYUN_ACCESS_KEY', ''),
            'access_secret' => env('ALIYUN_ACCESS_SECRET', ''),
            'template_code' => env('ALIYUN_TEMPLATE_CODE'),
            'tries'         => 1,
        ],
    ],
];
