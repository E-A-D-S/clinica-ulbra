<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Sessoes no banco em producao: sobrevivem a reinicios do container
        // (no plano free do Render, dormir/deploy apagaria a sessao em arquivo e deslogaria).
        if ($this->app->environment('production')) {
            config(['session.driver' => 'database']);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Render (e outros proxies) terminam o HTTPS antes do app.
        // Sem isso o Laravel gera URLs http e o login quebra.
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
