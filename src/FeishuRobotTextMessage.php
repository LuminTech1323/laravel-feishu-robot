<?php

namespace LuminTech\LaravelFeishuRobot;

use GuzzleHttp\Exception\GuzzleException;
use LuminTech\LaravelFeishuRobot\Exception\CouldNotSendMessage;
use Psr\Http\Message\ResponseInterface;

class FeishuRobotTextMessage extends FeishuRobot
{
    /**
     * @throws GuzzleException
     * @throws CouldNotSendMessage
     */
    public function send(): ResponseInterface
    {
        $payload = [
            'msg_type' => 'text',
            'content' => $this->content
        ];
        return $this->sendMessage($payload);
    }

    public function addText(string $text)
    {
        $this->content = [
            'text' => $text
        ];
    }
}
