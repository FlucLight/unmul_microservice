<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'api_key' => env('API_KEY', 'your-secret-api-key-change-me'),

    /*
    |--------------------------------------------------------------------------
    | Microservices FastAPI (untuk Swagger UI admin & integrasi internal)
    |--------------------------------------------------------------------------
    */

    'api_tugas' => [
        'url' => env('API_TUGAS_URL', 'http://127.0.0.1:8000'),
    ],

    'api_penilaian' => [
        'url' => env('API_PENILAIAN_URL', 'http://127.0.0.1:8001'),
    ],

    'api_modul' => [
        'url' => env('API_MODUL_URL', 'http://127.0.0.1:8002'),
    ],

    /*
    |--------------------------------------------------------------------------
    | API Cek NIM (FastAPI Service 4 - Port 8003)
    |--------------------------------------------------------------------------
    |
    | Layanan pemeriksa NIM untuk validasi registrasi mandiri Mahasiswa.
    | Hanya NIM yang terdaftar pada database mahasiswa yang boleh mendaftar.
    |
    */

    'cek_nim' => [
        'url' => env('API_CEK_NIM_URL', 'http://127.0.0.1:8003'),
        'key' => env('API_KEY', 'your-secret-api-key-change-me'),
    ],

];
