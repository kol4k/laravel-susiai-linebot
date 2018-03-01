<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class YandexController extends Controller
{
    public function __construct(){
        $this->myClient = new Client();
        $this->apiURL = 'https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20171216T092715Z.18943ca79fdb501d.84c04771f13b9fc5fad54f2d9084479cb942eb7a&lang=id-en&text=';
    }

    /**
     * Susi Get function
     * @param string $chatText
     */
    public function getFunction($chatText)
    {
        $request = $this->myClient->get($this->apiURL.$chatText);
        $response = $request->getBody();
        $data = json_decode($response, true);
        return $data['text'][0];
    }
}
