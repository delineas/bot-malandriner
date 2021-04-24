<?php

namespace Tests\Unit;

use Prophecy\Argument;
use App\Adapters\ConfigAdapter;
use App\Adapters\TelegramReply;
use PHPUnit\Framework\TestCase;
use App\Adapters\TelegramMessage;
use App\Domain\UseCases\ReplyToNapalm;

class ReplyToNapalmTest extends TestCase
{

    public function getRequestMessageText($text)
    {
        return json_decode('{
        "update_id": 74430134,
        "message": {
            "message_id": 826,
            "from": {
                "id": 14977870,
                "is_bot": false,
                "first_name": "Daniel",
                "last_name": "Primo",
                "username": "danielprimo",
                "language_code": "es"
            },
            "chat": {
                "id": -666,
                "title": "Web Reactiva Grupo Test",
                "type": "group",
                "all_members_are_administrators": false
            },
            "date": 1614973230,
            "edit_date": 1614973347,
            "text": "' . $text . '"
            }
        }', true);
    }

    public function test_cuando_el_mensaje_no_dice_napalm_el_bot_no_respondo()
    {
        $request = $this->getRequestMessageText('otra cosa');
        $messengerMessage = $this->prophesize(TelegramMessage::class);
        $messengerMessage->getText()->willReturn($request['message']['text']);
        $messengerMessage->getChatId()->shouldBeCalledTimes(0);
        $messengerReply = $this->prophesize(TelegramReply::class);

        $answer = (new ReplyToNapalm($messengerMessage->reveal(), $messengerReply->reveal()))();

        $this->assertEquals(null, $answer);
    }

    public function test_cuando_el_mensaje_dice_napalm_el_bot_responde()
    {
        // Arrange request
        $request = $this->getRequestMessageText('napalm');
        $messengerMessage = $this->prophesize(TelegramMessage::class);
        $messengerMessage->getText()->willReturn($request['message']['text']);
        $messengerMessage->getChatId()->willReturn($request['message']['chat']['id']);

        // Arrange Config
        $config = $this->prophesize(ConfigAdapter::class);
        $config->get(Argument::exact('botmalandriner.reply_napalm'))->willReturn('string');
        //$config->reveal()->get('botmalandriner.reply_napalm')

        // Arrange reply
        $messengerReply = $this->prophesize(TelegramReply::class);
        $messengerReply->setText(Argument::exact($config->reveal()->get('botmalandriner.reply_napalm')))->shouldBeCalledTimes(1);
        $messengerReply->setChatId(Argument::exact($request['message']['chat']['id']))->shouldBeCalledTimes(1);
        $expectedReply = [
            'chat_id' => $request['message']['chat']['id'],
            'text' => $config->reveal()->get('botmalandriner.reply_napalm'),
            'parse_mode' => 'MarkdownV2'
        ];
        $messengerReply->getReply()->willReturn($expectedReply);

        // Act
        $answer = (new ReplyToNapalm($messengerMessage->reveal(), $messengerReply->reveal(), $config->reveal()))();

        // Assert
        $this->assertEquals($expectedReply, $answer);
    }
}
