<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SusiController extends Controller
{
    public function __construct(){
    	$this->myClient = new Client();
        $this->apiURL = 'https://api.susi.ai/susi/chat.json?timezoneOffset=-420&q=';
    }

    /**
     * Susi Get function
     * @param url $url
     * @param token_api @token
     */
    public function getFunction()
    {
        // $request = $this->myClient->get($this->apiURL.$query);
        // $response = $request->getBody();
        // $data = json_decode($response, true);
        // return $data['answers'][0]['actions'][0]['expression'];
        $data = 'hai';
        return $data;
    }
}
