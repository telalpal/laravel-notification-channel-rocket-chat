<?php

namespace NotificationChannels\RocketChat;

use GuzzleHttp\Client as HttpClient;

class RocketChat
{
    /** @var string */
    protected $token;

    /** @var \GuzzleHttp\Client */
    protected $http;

    /** @var string */
    protected $url;

    /** @var string */
    protected $room;

    /**
     * @param  \GuzzleHttp\Client  $http
     * @param  string|null  $url
     * @param  string  $token
     * @param  string  $room
     * @return void
     */
    public function __construct(HttpClient $http, $url, $token, $room)
    {
        $this->http = $http;
        $this->url = rtrim($url ?: 'https://talk.cybercog.su', '/');
        $this->token = $token;
        $this->room = $room;
    }

    /**
     * Returns default room id or name.
     *
     * @return string
     */
    public function room()
    {
        return $this->room;
    }

    /**
     * Returns RocketChat base url.
     *
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * Returns RocketChat token.
     *
     * @return string
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * Send a message.
     *
     * @param  string|int  $to
     * @param  array  $message
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendMessage($to, $message)
    {
        $url = "{$this->url}/hooks/{$this->token}";

        return $this->post($url, [
            'json' => array_merge($message, [
                'roomId' => $to,
            ]),
        ]);
    }

    /**
     * Make a simple post request.
     *
     * @param  string  $url
     * @param  array  $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function post($url, $options)
    {
        return $this->http->post($url, $options);
    }
}
