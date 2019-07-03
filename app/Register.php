<?php declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

final class Register
{
    public function registerEnvPackage(): self
    {
        $dot_env = Dotenv::create(APP_DIR);
        $dot_env->load();

        return $this;
    }
}