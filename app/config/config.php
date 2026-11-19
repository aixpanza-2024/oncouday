<?php
declare(strict_types=1);

return [
    'app' => [
        'name'         => 'OncoUday',
        'tagline'      => "India's gateway to cancer clinical trials and patient support",
        'env'          => getenv('APP_ENV') ?: 'development',
        'data_source'  => getenv('APP_DATA_SOURCE') ?: 'sample',
        'default_lang' => 'en',
        'languages'    => ['en' => 'English', 'hi' => 'हिन्दी', 'ml' => 'മലയാളം'],
        'notice_version' => '1.1',
    ],

    'legal' => [
        'effective'      => '2026-11-18',
    ],

    'db' => [
        'host'     => getenv('DB_HOST') ?: '127.0.0.1',
        'port'     => (int) (getenv('DB_PORT') ?: 3306),
        'name'     => getenv('DB_NAME') ?: 'oncouday',
        'user'     => getenv('DB_USER') ?: 'root',
        'pass'     => getenv('DB_PASS') ?: '',
        'charset'  => 'utf8mb4',
    ],

    'contact' => [
        'email'     => 'info@oncouday.com',
        'whatsapp'  => '+91 80505 19549',
        'whatsapp_chat' => getenv('WHATSAPP_CHAT_NUMBER') ?: '918050519549',
        'hours'     => 'Working hours: 9 am to 5 pm, Monday to Saturday',
        'grievance' => [
            'name'  => 'Dr Uddiptya Goswami',
            'email' => 'grievance@oncouday.com',
            'phone' => '+91 87777 34849',
        ],
    ],

    'social' => [
        ['icon' => 'facebook',  'label' => 'Facebook',  'url' => '#'],
        ['icon' => 'instagram', 'label' => 'Instagram', 'url' => '#'],
        ['icon' => 'youtube',   'label' => 'YouTube',   'url' => '#'],
        ['icon' => 'linkedin',  'label' => 'LinkedIn',  'url' => '#'],
        ['icon' => 'twitter-x', 'label' => 'X',         'url' => '#'],
    ],
];
