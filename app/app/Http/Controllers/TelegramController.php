<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    //curl "https://api.telegram.org/bot<token>/setWebhook?url=https://my-laravel-site.com/telegram/webhook"
    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        if (isset($data['message']['text']) && $data['message']['text'] === '/start') {
            $chatId = $data['message']['chat']['id'];
            $this->sendMessage($chatId, "Ваш chat_id: `$chatId`");
        }

        return response()->json(['status' => 'success']);
    }

    private function sendMessage($chatId, $text)
    {
        $client = new Client();
        $token = env('TELEGRAM_BOT_TOKEN');

        $client->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'json' => [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown'
            ]
        ]);
    }
}
