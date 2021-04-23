<?php

namespace Tests\Unit;

use App\Domain\UseCases\ReplyToNapalm;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Telegram\Bot\Objects\Update;

class ReplyToNapalmTest extends TestCase
{

    public function test_cuando_el_mensaje_no_dice_napalm_el_bot_no_respondo()
    {

        $request = json_decode('{
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
                "id": -511961606,
                "title": "Web Reactiva Grupo Test",
                "type": "group",
                "all_members_are_administrators": false
            },
            "date": 1614973230,
            "edit_date": 1614973347,
            "text": "otra cosa"
            }
        }', true);

        $message = collect($request['message']);

        $update = $this->prophesize(Update::class);
        $update->getMessage()->willReturn($message);
        $update->getChat()->shouldBeCalledTimes(0);

        $answer = (new ReplyToNapalm($update->reveal()))();

        $this->assertEquals(null, $answer);
    }

    public function test_cuando_el_mensaje_dice_napalm_el_bot_responde() {

        $request = json_decode('{
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
                "id": -511961606,
                "title": "Web Reactiva Grupo Test",
                "type": "group",
                "all_members_are_administrators": false
            },
            "date": 1614973230,
            "edit_date": 1614973347,
            "text": "napalm"
            }
        }', true);

        $message = collect($request['message']);
        $chat = collect($request['message']['chat']);

        $update = $this->prophesize(Update::class);
        $update->getMessage()->willReturn($message);
        $update->getChat()->willReturn($chat);

        $answer = (new ReplyToNapalm($update->reveal()))();

        $this->assertEquals('napalm responde', $answer['text']);
    }
}
