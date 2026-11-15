<?php
declare(strict_types=1);

define('APP_ROOT', dirname(__DIR__));
define('APP_PATH', __DIR__);

$GLOBALS['__config'] = require APP_PATH . '/config/config.php';

$isProduction = ($GLOBALS['__config']['app']['env'] === 'production');
error_reporting(E_ALL);
ini_set('display_errors', $isProduction ? '0' : '1');
ini_set('log_errors', '1');

mb_internal_encoding('UTF-8');
date_default_timezone_set('Asia/Kolkata');

spl_autoload_register(static function (string $class): void {
    $class = basename(str_replace('\\', '/', $class));
    foreach (['core', 'repositories', 'services'] as $dir) {
        $file = APP_PATH . '/' . $dir . '/' . $class . '.php';
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

require APP_PATH . '/core/helpers.php';

Security::sendHeaders();
Security::startSession();
