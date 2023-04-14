<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class StatAsicController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }


    public function statAsic(Request $request, Response $response, $args)
    {

        $client = new \GuzzleHttp\Client();
        $responseAuth = $client->request('POST', 'https://api.bixbit.io/api/auth/check', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'email' => "on1ytrue@icloud.com",
                'password' => "on1ytrue57.",
            ]),
        ]);

        if ($responseAuth->getStatusCode() == 200) {
            $body = json_decode($responseAuth->getBody(), true);
            $token = $body['token'];
        }

        $client = new \GuzzleHttp\Client();
        $responseChart = $client->request('POST', 'https://api.bixbit.io/api/v1/miner_states/1964/charts', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
        ]);

        if ($responseChart->getStatusCode() == 200) {
            $body = json_decode($responseChart->getBody(), true);
            $minerDataArray = $body['tBoard'];
            $count = 0;
            $sum = 0;
            foreach($minerDataArray as $value){
                if($value != 0){
                    $sum += $value;
                    $count++;
                }
            }
            $minerData = $sum / $count;
        }

        $user = $this->entityManager->getRepository(User::class)->find($args['id']);

        if ($user === null) {
            return $response->withStatus(404);
        }

        $imageData = file_get_contents(__DIR__ . '/../View/images/avatar1.png');
        $base64 = base64_encode($imageData);
        $user->setAvatar('data:image/png;base64,' . $base64);

        $loader = new FilesystemLoader(__DIR__ . '/../View/templates');
        $twig = new Environment($loader);

        $renderedTemplate = $twig->render('dashboard.twig', ['user' => $user, 'minerData' => $minerData]);
        $response->getBody()->write($renderedTemplate);

        return $response;
    }
}