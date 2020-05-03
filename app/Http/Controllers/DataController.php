<?php

namespace App\Http\Controllers;

class DataController extends Controller
{
    /**
     *
     */
    public function postRequest()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'laravellumen.local/api/auth/register', [
            'form_params' => [
                'name' => 'kajal Raychura',
                'email'=>'test34324ewrwer@gmail.com',
                'password'=>'12345678'
            ]
        ]);
        $response = $response->getBody()->getContents();
        print_r($response);
    }

}
