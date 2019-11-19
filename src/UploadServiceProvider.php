<?php

namespace Siaoynli\Upload;

use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('upload', function ($app) {
            return new Upload($app['config']);
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__ . '/config/upload.php' => config_path('upload.php'),
        ]);
    }

    public function provides()
    {
        return ['upload'];
    }


}
