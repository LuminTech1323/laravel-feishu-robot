<?php

namespace LuminTech\LaravelFeishuRobot;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class FeishuRobotServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/broadcasting.php' => config_path('broadcasting.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/broadcasting.php', 'broadcasting'
        );
    }

    public function register()
    {
        // 校验配置broadcasting.connections.feishu-robot.url是否存在
        $this->mergeConfigFrom(
            __DIR__ . '/../config/broadcasting.php', 'broadcasting'
        );
        $this->app->bind(FeishuRobotCardMessage::class, function ($app) {
            return new FeishuRobotCardMessage($app->make(Client::class), config('broadcasting.connections.feishu-robot.url'));
        });
        $this->app->bind(FeishuRobotTextMessage::class, function ($app) {
            return new FeishuRobotTextMessage($app->make(Client::class), config('broadcasting.connections.feishu-robot.url'));
        });

    }
}
