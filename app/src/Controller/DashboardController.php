<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class DashboardController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function dashboard(Request $request, Response $response, $args)
    {

        // Получаю данные пользователя из базы данных
        $userId = $args['id'];
        $user = $this->entityManager->getRepository(User::class)->find($userId);

        // Загружаю изображение
        $imageData = file_get_contents(__DIR__ . '/../View/images/avatar1.png');
        // Кодирую данные изображения в формат Base64
        $base64 = base64_encode($imageData);
        // Устанавливаю аватар пользователя
        $user->setAvatar('data:image/png;base64,' . $base64);
       /* $user->setAvatar('https://cdn.iz.ru/sites/default/files/styles/900x506/public/news-2023-03/hyj_0.jpg?itok=5fKCsFRX');*/


        $loader = new FilesystemLoader(__DIR__ . '/../View/templates');
        $twig = new Environment($loader);

        $renderedTemplate = $twig->render('dashboard.twig', ['user' => $user]);

        // Отображаю шаблон с передачей данных о пользователе
        $response->getBody()->write($renderedTemplate);

        return $response;
    }

}
