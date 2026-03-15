<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Kyslik\ColumnSortable\ColumnSortableServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tests\Models\User;
use VueFileManager\Subscription\SubscriptionServiceProvider;

class TestCase extends Orchestra
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        Carbon::setTestNow('1. January 2022');

        $this->withoutExceptionHandling();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'VueFileManager\\Subscription\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ColumnSortableServiceProvider::class,
            SubscriptionServiceProvider::class,
            SanctumServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->loadDefaultEnv($app);

        config()->set('auth.providers.users.model', User::class);
        config()->set('subscription.metered_billing.settlement_period', 30);
    }

    protected function loadDefaultEnv(Application $app): void
    {
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        parent::getEnvironmentSetUp($app);
    }
}
