# 飞书机器人扩展

这是一个用于 Laravel 的飞书机器人扩展包，提供了发送卡片消息和文本消息的功能。

## 安装

使用 Composer 安装:

```bash
composer require lumintech/laravel-feishu-robot
```

## 使用

首先，你需要在.env文件中配置飞书机器人的 Webhook 地址：

```env
FEISHU_ROBOT_WEBHOOK=https://open.feishu.cn/robot/send
```

然后，你可以使用 FeishuRobotCardMessage 和 FeishuRobotTextMessage 类来发送消息。例如：

```php
use LuminTech\LaravelFeishuRobot\FeishuRobotCardMessage;

$cardMessage = app()->make(FeishuRobotCardMessage::class);
$cardMessage->setHeaderTemplate(FeishuRobotCardMessage::TEMPLATE_WARING);
$cardMessage->setSubTitle('页面缓存监控');
$cardMessage->addText('-> 告警类型：http监控告警');
$cardMessage->addText('-> 告警时间：2023-01-01 00:00:00');
$cardMessage->addText('-> 告警内容：http://www.baidu.com');
$cardMessage->addAtAllText('蚂蚁足球-监控告警提醒，请尽快处理 ');
$response = $cardMessage->send();
```

## API

```php
FeishuRobotCardMessage::setHeaderTemplate(string $template): FeishuRobotCardMessage
FeishuRobotCardMessage::setTitle(string $title): FeishuRobotCardMessage 
FeishuRobotCardMessage::setSubTitle(string $subTitle): FeishuRobotCardMessage
FeishuRobotCardMessage::addText(string $text): FeishuRobotCardMessage   
FeishuRobotCardMessage::addAtText(string $text): FeishuRobotCardMessage 
FeishuRobotCardMessage::addAtAllText(string $text): FeishuRobotCardMessage
FeishuRobotCardMessage::send()
```
## 贡献

欢迎提交 Pull Request 或者提出 Issue。

## 许可证

这个项目使用 MIT 许可证，详情请见 LICENSE 文件。
