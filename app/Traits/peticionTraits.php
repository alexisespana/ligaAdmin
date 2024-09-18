<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


trait peticionTraits
{
    public function peticicion($url, $method, $params)
    {
        $client = new \GuzzleHttp\Client();

        $response =  Http::$method(env('API_ENDPOINT') . '/' . $url, $params);

        // $response = Http::post('http://example.com/users', [
        //     'name' => 'Steve',
        //     'role' => 'Network Administrator',
        // ]);
        return (object) [
            'data'=>$response->object(),
            'status'=>$response->status()
    ];
    }
}
