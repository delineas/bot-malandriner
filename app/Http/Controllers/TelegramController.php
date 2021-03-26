<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Domain\UseCases\ReplyToNapalm;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook(Request $request) {

        /** @var Update $update */
        $update = Telegram::getWebhookUpdates();

        Log::info($update->getChat()['id']);

        (new ReplyToNapalm($update))();
        
        response()->json(['ok' => true])->send();
    }
}
