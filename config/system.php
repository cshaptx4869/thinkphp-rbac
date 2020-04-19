<?php
/**
 * 系统相关配置
 */

return [
    'annotation' => [
        'cache' => false,
        'writelist' => []
    ],
    'api' => [
        'sign' => false, // 是否开启api签名校验
        'auth' => true, // 是否开启api权限校验
        'lifetime' => 180, // api时效性 秒
        'app_secret' => '@wtf@', // api签名密钥 保证接口参数完整性
    ],
    'redis' => [
        'host' => env('redis.host', 'redis'),
        'port' => env('redis.port', 6379),
        'password' => env('redis.password', ''),
    ],
    'sms' => [
        'engine' => 'file', // 缓存引擎
        'geteway' => 'http://smssh1.253.com/msg/', // 短信网关地址
        'account' => env('sms.account', ''),// 账号
        'password' => env('sms.password', ''),// 密码
        'lifetime' => 900, // 验证码有效期，秒
        'daily_limit' => 15, // 每个账号一天允许的最大发送数
        'templates' => [ // 短信模板
            "您好，您的验证码为 {code}，{lifetime}分钟内有效，请勿向任何人泄露，感谢您的使用！",
        ]
    ],
    'email' => [
        'Username' => env('email.username', ''),
        'Password' => env('email.password', ''),
        'Host' => env('email.host', 'smtp.163.com'),
        'Port' => env('email.port', 25),
        'SMTPDebug' => env('email.debug', 0),
        'From' => [                                 // The From email address for the message
            'address' => env('email.from_address', ''),
            'name' => env('email.from_name', '')
        ],
        'Reply' => [                                // The Reply email address for the email
            'address' => env('email.reply_address', ''),
            'name' => env('email.reply_name', '')
        ],
    ],
    'token' => [
        'access_token' => [
            'exp' => 1800 // 单位，秒
        ],
        'refresh_token' => [
            'exp' => 7 * 24 * 3600 // 单位，秒
        ]
    ],
    'upload' => [
        'image' => [
            'rule' => 'date', // date,md5,sha1
            'validate' => [// 验证规则
                'size' => 2 * 1024 * 1024,// 上传大小，字节
                'ext' => ['jpeg', 'jpg', 'png', 'gif'], // 文件后缀
                'type' => ['image/jpeg', 'image/png', 'image/gif'],// mime类型
            ],
            'dir' => 'upload' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR //保存目录 默认同入口文件目录
        ]
    ],
    'weixin' => [
        'mini' => [
            'appid' => env('weixin.mini_appid', ''),
            'app_sercret' => env('weixin.mini_app_sercret', ''),
            'authorization_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid={APPID}&secret={SECRET}&js_code={JSCODE}&grant_type=authorization_code'
        ]
    ]
];
