<?php

declare(strict_types=1);

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

if (class_exists(Dotenv::class) && file_exists(__DIR__ . '/../.env')) {
    new Dotenv()->bootEnv(__DIR__ . '/../.env');
}

$env = $_SERVER['APP_ENV'] ?? 'dev';
$debug = (bool) ($_SERVER['APP_DEBUG'] ?? true);

$kernel = new Kernel($env, $debug);
$kernel->boot();

return $kernel->getContainer()->get('doctrine')->getManager();
