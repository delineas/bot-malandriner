<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Objects\Update;
use Illuminate\Support\Facades\Log;
use App\Domain\UseCases\CaptureLink;
use App\Domain\UseCases\ReplyToNapalm;
use App\Domain\UseCases\WelcomeNewUser;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook(Request $request) {

        /** @var Update $update */
        $update = Telegram::getWebhookUpdates();

        Log::info($update->getMessage()->get('from'));

        (new ReplyToNapalm($update))();
        (new WelcomeNewUser($update))();
        (new CaptureLink($update))();
        
        response()->json(['ok' => true])->send();
    }
}
