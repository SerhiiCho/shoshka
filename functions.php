<?php declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

function logger(): Logger
{
    $log = new Logger('log');
    return $log->pushHandler(new StreamHandler('storage/logs.log'));
}
