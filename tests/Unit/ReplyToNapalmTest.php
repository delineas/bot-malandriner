<?php

namespace Tests\Unit;

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

        $answer = (new ReplyToNapalm($messengerMessage->reveal()))();

        $this->assertEquals(null, $answer);
    }

    public function test_cuando_el_mensaje_dice_napalm_el_bot_responde()
    {
        $request = $this->getRequestMessageText('napalm');
        $messengerMessage = $this->prophesize(TelegramMessage::class);
        $messengerMessage->getText()->willReturn($request['message']['text']);
        $messengerMessage->getChatId()->willReturn($request['message']['chat']['id']);

        $answer = (new ReplyToNapalm($messengerMessage->reveal()))();

        $this->assertEquals('napalm responde', $answer['text']);
    }
}
