<?php

namespace App\Http\Services;

<<<<<<< HEAD
use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use App\Http\Controllers\Library\SusiController;
use App\Http\Controllers\Library\YandexController;
=======
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use App\Http\Controllers\Library\SusiController;
>>>>>>> 7276e2111611f21514468ba3396a514f29aff65f

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
<<<<<<< HEAD
    /**
     * @var yandex
     */
    private $yandex;

    public function __construct(SusiController $susi, YandexController $yandex)
    {
        $this->susi = $susi;
        $this->yandex = $yandex;
    }
    
    public function replySend(Request $r, $formData)
=======

    public function __construct(SusiController $susi)
    {
        $this->susi = $susi;
    }
    
    public function replySend($formData)
>>>>>>> 7276e2111611f21514468ba3396a514f29aff65f
    {
        $replyToken = $formData['events']['0']['replyToken'];
        $chatText = $formData['events']['0']['message']['text'];        
        
        $this->client = new CurlHTTPClient(env('LINE_BOT_ACCESS_TOKEN'));
        $this->bot = new LINEBot($this->client, ['channelSecret' => env('LINE_BOT_SECRET')]);
        
<<<<<<< HEAD
        if($chatText == '/terjemah') {
            $response = $this->bot->replyText($replyToken, 'Masukan kata kata untuk diterjemahkan, dan apabila selesai ketik: /selesai');
            $r->session()->put('query', 'terjemah');
        } else if($chatText == '/selesai') {
            $r->session()->forget('query');
        }

        if($r->session()->get('query') == 'terjemah') {
            $response = $this->bot->replyText($replyToken, $this->yandex->getFunction($chatText));
        } else {
            $response = $this->bot->replyText($replyToken, $this->susi->getFunction($chatText));
        }
=======
        $response = $this->bot->replyText($replyToken, $this->susi->getFunction($chatText));
>>>>>>> 7276e2111611f21514468ba3396a514f29aff65f
        
        if ($response->isSucceeded()) {
            logger("reply success!!");
            return;
        }
    }
}