<?php

namespace Tests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends BaseTestCase
{

    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        Hash::driver('bcrypt')->setRounds(4);

        $this->clearCache($app);

        return $app;
    }

    protected function clearCache(Application $app)
    {
        if (!$app->configurationIsCached()) {
            return;
        }

        $commands = ['clear-compiled', 'cache:clear', 'view:clear', 'config:clear', 'route:clear'];
        foreach ($commands as $command) {
            \Illuminate\Support\Facades\Artisan::call($command);
        }
        throw new \Exception('Your configuration values were cached and have now been cleared. Please rerun the test suite.');
    }
}
