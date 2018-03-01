<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use App\Http\Controllers\Library\SusiController;
use App\Http\Controllers\Library\YandexController;
use Storage;

class GetMessageService
{
    /**
     * @var LINEBot
     */
    private $bot;
    /**
     * @var HTTPClient
     */
    private $client;
    /**
     * @var susi
     */
    private $susi;
    /**
     * @var yandex
     */
    private $yandex;

    public function __construct(SusiController $susi, YandexController $yandex, Request $request)
    {
        $this->susi = $susi;
        $this->yandex = $yandex;
        $this->request = $request;
    }
    
    public function forgetCache($keys = []){
        // forget
        $defaultKey = [
            'terjemah'
        ];
        if(empty($keys)){
            $keys = $defaultKey;
        }
        foreach($keys as $key){
            Cache::forget($key);
        }
        
        return true;
    }

    public function replySend($formData)
    {
        $expiresAt = Carbon::now()->addMinutes(2);
        $replyToken = $formData['events']['0']['replyToken'];
        $chatText = $formData['events']['0']['message']['text'];        
        
        $this->client = new CurlHTTPClient(env('LINE_BOT_ACCESS_TOKEN'));
        $this->bot = new LINEBot($this->client, ['channelSecret' => env('LINE_BOT_SECRET')]);
        
        if($chatText == '/terjemah') {
            $response = $this->bot->replyText($replyToken, 'Masukan kata kata untuk diterjemahkan, dan apabila selesai ketik: /selesai');
            Cache::add('terjemah', true, $expiresAt);
        } else if($chatText == '/selesai') {
            $this->forgetCache();
        }

        if(Cache::get('terjemah')) {
            $response = $this->bot->replyText($replyToken, $this->yandex->getFunction($chatText));
        } else {
            $response = $this->bot->replyText($replyToken, $this->susi->getFunction($chatText));
        }
        
        if ($response->isSucceeded()) {
            logger("reply success!!");
            return;
        }
    }
}