<?php

namespace LuminTech\LaravelFeishuRobot;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use LuminTech\LaravelFeishuRobot\Exception\CouldNotSendMessage;
use Psr\Http\Message\ResponseInterface;

class FeishuRobotCardMessage extends FeishuRobot
{
    const TEMPLATE_SUCCESS = "green";
    const TEMPLATE_ERROR = "red";
    const TEMPLATE_NORMAL = "grey";
    const TEMPLATE_WARING = "orange";

    private $title;
    private $subTitle;
    private $headerTemplate;

    public function __construct(Client $client, string $webhookUrl, string $title = "Markdown Message")
    {
        parent::__construct($client, $webhookUrl);
        $this->title = $title;
        $this->content = [];
    }

    public function setTitle(string $title): FeishuRobotCardMessage
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $subTitle
     * @return FeishuRobotCardMessage
     */
    public function setSubTitle($subTitle): FeishuRobotCardMessage
    {
        $this->subTitle = $subTitle;
        return $this;
    }

    public function setHeaderTemplate(string $template): FeishuRobotCardMessage
    {
        if (!in_array($template, [self::TEMPLATE_SUCCESS, self::TEMPLATE_ERROR, self::TEMPLATE_NORMAL, self::TEMPLATE_WARING])) {
            throw new InvalidArgumentException("Invalid template.");
        }
        $this->headerTemplate = $template;
        return $this;
    }

    public function addParagraph(array $elements): FeishuRobotCardMessage
    {
        $this->content[] = $elements;
        return $this;
    }

    public function addText(string $text): FeishuRobotCardMessage
    {
        return $this->addParagraph(['tag' => 'markdown', 'content' => $text]);
    }

    public function addAtAllText(string $text): FeishuRobotCardMessage
    {
        return $this->addParagraph(['tag' => 'markdown', 'content' => $text . ' <at id=all></at>']);
    }

    public function getPayload(): array
    {
        return [
            'msg_type' => 'interactive',
            'card' => [
                'config' => [
                    'wide_screen_mode' => true,
                    'enable_forward' => true,
                ],
                'header' => [
                    'title' => [
                        'tag' => 'plain_text',
                        'content' => $this->title,
                    ],
                    "subtitle" => [
                        "content" => $this->subTitle,
                        "tag" => "plain_text"
                    ],
                    'template' => $this->headerTemplate,
                ],
                'elements' => $this->content
            ]
        ];
    }

    /**
     * @throws GuzzleException
     * @throws CouldNotSendMessage
     */
    public function send(): ResponseInterface
    {
        if (empty($this->content)) {
            throw new InvalidArgumentException("Markdown content cannot be empty.");
        }

        $payload = $this->getPayload();

        return $this->sendMessage($payload);
    }

}
