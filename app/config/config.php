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
        'notice_version' => '1.0',
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
        'email'     => '[contact@oncouday.in]',
        'whatsapp'  => '[+91 XXXXX XXXXX]',
        'address'   => '[Office address]',
        'hours'     => '[Working hours]',
        'grievance' => [
            'name'  => '[Grievance Officer name]',
            'email' => '[grievance@oncouday.in]',
            'phone' => '[Phone number]',
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
