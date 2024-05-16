<?php

namespace LuminTech\LaravelFeishuRobot;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use LuminTech\LaravelFeishuRobot\Exception\CouldNotSendMessage;
use Psr\Http\Message\ResponseInterface;

abstract class FeishuRobot
{
    protected $client;
    private $webhookUrl;

    protected $content;

    public function __construct(Client $client, string $webhookUrl)
    {
        $this->client = $client;
        $this->webhookUrl = $webhookUrl;
    }

    /**
     * @throws GuzzleException
     * @throws CouldNotSendMessage
     */
    protected function sendMessage($payload): ResponseInterface
    {
        try {
            if (!$this->webhookUrl) {
                throw CouldNotSendMessage::missingWebhookUrl();
            }
            return $this->client->request('POST', $this->webhookUrl, [
                'body' => json_encode($payload),
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);
        } catch (RequestException $requestException) {
            throw CouldNotSendMessage::serviceRespondedWithAnError($requestException);
        }
    }

    abstract public function send(): ResponseInterface;

    abstract public function addText(string $text);
}
