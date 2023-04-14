<?php

namespace App\Controller\StatAsicController;


use Slim\Psr7\Request;
use Slim\Psr7\Response;

class StatAsicController
{
    public function statAsic(Request $request, Response $response, $args)
    {

    }
//
//$client = new \GuzzleHttp\Client();
//$response = $client->request('POST', 'https://api.bixbit.io/api/auth/check', ['headers' => ['Content-Type' => 'application/json',],
//'body' => json_encode(['login' => 'ваш_логин',
//'password' => 'ваш_пароль',]),]);
//
//if ($response->getStatusCode() == 200)
//{
//$body = json_decode($response->getBody(), true);
//$token = $body['access_token'];
//}
//
//
//$client = new \GuzzleHttp\Client();
//$response = $client->request('GET', 'https://api.bixbit.io/api/v1/miner_states/584/charts', [
//    'headers' => [
//        'Authorization' => 'Bearer ' . $token,
//        'Content-Type' => 'application/json',
//    ],
//]);
//
//if ($response->getStatusCode() == 200) {
//    $body = json_decode($response->getBody(), true);
//    $minerData = $body['data'];
//}
//
//
//$renderedTemplate = $twig->render('dashboard.twig', ['user' => $user, 'minerData' => $minerData]);

}