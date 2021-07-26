<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CepController extends Controller
{
    public function cepSearch(Client $client, $cep)
    {
        $response = $client->get('https://viacep.com.br/ws/'.$cep.'/json');

        return response(json_decode($response->getBody(), true));
    }
}
