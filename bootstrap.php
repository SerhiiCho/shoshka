<?php declare(strict_types=1);

use App\AppHandler;

require_once 'vendor/autoload.php';
require_once 'constants.php';

(new AppHandler)
    ->registerEnvPackage()
    ->sendMessageIfNewReports();
