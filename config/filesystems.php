<?php

return [
    'default' => env('FILESYSTEM_DISK', 'local'),
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'timezone' => 'Asia/Taipei',
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],
        'network' => [
            'driver' => 'ftp',
            'host' => '192.168.0.3',
            'username' => 'E545',
            'password' => 'SCSC',
            'port'     => 57, // 這裡設定 FTP 連線的埠號
            'root' => '/', // 根目錄路徑
            // 其他 FTP 相關配置
        ],

    ],
    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
