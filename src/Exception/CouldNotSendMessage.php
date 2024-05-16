<?php

namespace LuminTech\LaravelFeishuRobot\Exception;

use Exception;

class CouldNotSendMessage extends Exception
{
    public static function missingWebhookUrl(): CouldNotSendMessage
    {
        return new static('Webhook URL is missing');
    }

    public static function serviceRespondedWithAnError(Exception $requestException): CouldNotSendMessage
    {
        return new static('Service responded with an error: ' . $requestException->getMessage());
    }


}
