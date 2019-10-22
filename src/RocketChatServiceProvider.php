<?php

namespace NotificationChannels\RocketChat;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class RocketChatServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notification::resolved(function ($service) {
            $service->extend('rocket', function ($app) {
                $rocketChat = new RocketChat(
                    new HttpClient,
                    config('services.rocketchat.url'),
                    config('services.rocketchat.token'),
                    config('services.rocketchat.room')
                );

                return new RocketChatWebhookChannel($rocketChat);
            });
        });
    }
}
