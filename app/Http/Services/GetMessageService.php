<?php

namespace App\Http\Services;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use App\Http\Controllers\Library\SusiController;

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

    public function __construct(SusiController $susi)
    {
        $this->susi = $susi;
    }
    
    public function replySend($formData)
    {
        $replyToken = $formData['events']['0']['replyToken'];
        
        $this->client = new CurlHTTPClient(env('LINE_BOT_ACCESS_TOKEN'));
        $this->bot = new LINEBot($this->client, ['channelSecret' => env('LINE_BOT_SECRET')]);
        
        $response = $this->bot->replyText($replyToken, $susi->getFunction($replyToken));
        
        if ($response->isSucceeded()) {
            logger("reply success!!");
            return;
        } else {
            logger($response->getRawBody());
            logger($response->getJSONDecodedBody());
        }
    }
}