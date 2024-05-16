<?php

namespace LuminTech\LaravelFeishuRobot\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use LuminTech\LaravelFeishuRobot\Exception\CouldNotSendMessage;
use LuminTech\LaravelFeishuRobot\FeishuRobotCardMessage;
use PHPUnit\Framework\TestCase;

class FeishuRobotMarkdownMessageTest extends TestCase
{
    /**
     * @throws GuzzleException
     * @throws CouldNotSendMessage
     */
    public function testSend()
    {
        $cardMessage = app()->make(FeishuRobotCardMessage::class);
        /** @var FeishuRobotCardMessage $cardMessage */
//        $markdownMessage = new FeishuRobotCardMessage(
//            new Client(),
//            'https://open.feishu.cn/open-apis/bot/v2/hook/a9df1bae-84ef-45d5-9e4b-813ef51a5af7',
//            "蚂蚁足球-监控告警提醒"
//        );
        $cardMessage->setHeaderTemplate(FeishuRobotCardMessage::TEMPLATE_WARING);
        $cardMessage->setSubTitle('页面缓存监控');

        $cardMessage->addText('-> 告警类型：http监控告警');
        $cardMessage->addText('-> 告警时间：2023-01-01 00:00:00');
        $cardMessage->addText('-> 告警内容：http://www.baidu.com');

        $cardMessage->addText('');
        $cardMessage->addAtAllText('蚂蚁足球-监控告警提醒，请尽快处理 ');
        $response = $cardMessage->send();
        echo $response->getBody();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
