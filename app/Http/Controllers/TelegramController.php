<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Domain\TelegramMessageModel;
use App\Domain\UseCases\ReplyToNapalm;

class TelegramController extends Controller
{
    public function webhook(Request $request) {

        $requestData = $request->all();
        if(!isset($requestData['message'])) {
            return response('None', 200);
        }

        $telegramMessage = new TelegramMessageModel($requestData);

        if($telegramMessage->getChatId() != config('botmalandriner.chat_id')) {
            return response('None', 200);
        }

        (new ReplyToNapalm($telegramMessage))();
        
        //Log::info($telegramMessage->getChatId());
    }
}
