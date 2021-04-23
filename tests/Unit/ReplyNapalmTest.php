<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Conversations\ReplyNapalm;

class ReplyNapalmTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->answerMessage = 'Aqui Paquito';
    }

    
    public function test_cuando_dice_otra_cosa_diferente_a_napalm_no_respondo() {
        // Arrage
        $conversation = new ReplyNapalm($this->answerMessage);

        // Act
        $answer = $conversation->answer('otra cosa');

        // Assert 
        $this->assertEquals('', $answer);
    }

    public function test_cuando_dice_napalm_respondo_gif_animado() {
        $conversation = new ReplyNapalm($this->answerMessage);

        $answer = $conversation->answer('napalm');

        $this->assertEquals($this->answerMessage, $answer);
    }

    public function test_cuando_dice_algo_que_tiene_napalm_respondo_gif_animado() {
        $conversation = new ReplyNapalm($this->answerMessage);

        $answer = $conversation->answer('como me gusta el napalm');

        $this->assertEquals($this->answerMessage, $answer);
    }

}
