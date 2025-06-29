<?php

namespace FullEncryption;

use Illuminate\Support\ServiceProvider;

class FullEncryptionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        // Publier le fichier de configuration
        $this->publishes([
            __DIR__.'/../config/full-encryption.php' => config_path('full-encryption.php'),
        ], 'full-encryption-config');

        // Publier la migration
        if (! class_exists('AddEnckeyToUsersTable')) {
            $timestamp = date('Y_m_d_His');
            $this->publishes([
                __DIR__.'/../database/migrations/add_enckey_to_users_table.php' =>
                    database_path("migrations/{$timestamp}_add_enckey_to_users_table.php"),
            ], 'full-encryption-migrations');
        }
		
		if ($this->app->runningInConsole()) {
			$this->commands([
				\FullEncryption\Commands\GenerateKeysCommand::class,
			]);
		}

    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/full-encryption.php',
            'full-encryption'
        );

        $this->app->singleton(FullEncryptionService::class, function ($app) {
            return new FullEncryptionService();
        });
    }
}
