<?php declare(strict_types=1);

use App\Register;

require_once 'vendor/autoload.php';
require_once 'constants.php';

(new Register)
    ->registerEnvPackage()
    ->sendMessageIfNewReports();

