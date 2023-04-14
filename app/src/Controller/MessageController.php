<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class MessageController
{
    private MessageRepository $messageRepository;
    
    private UserRepository $userRepository;

    public function __construct(MessageRepository $messageRepository, UserRepository $userRepository) {

        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
    }
    public function sendMessage(Request $request, Response $response, $args): Response
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if ($request->getMethod() == 'POST') {
            $arr = $request->getParsedBody();

            $errors = $this->validateMessage($arr);

            if (!empty($errors)) {
                $response->getBody()->write(json_encode($errors));
                return $response;
            }

            $userRepository = $this->userRepository;
            $fromUser = $userRepository->find($_SESSION['user_id'] ?? null);
            $fromUserName = $fromUser->getFullName(); // получаю полное имя пользователя

            $toUserId = $arr['recipient_id'];
            $text = $arr['text'];

            $toUser = $userRepository->find($toUserId); //получаю объект пользователя-получателя сообщения по его идентификатору

            $message = new Message($fromUser, $text,  $toUser, new \DateTime());

            $message->setDatetimePublication(new \DateTime());

            $this->messageRepository->save($message,true);

            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['successMessage'] = 'Сообщение отправлено успешно ✔ ';
            }

            /*Браузерный API history.replaceState(),
             чтобы изменить URL страницы без перезагрузки страницы. Это позволит сохранить текущее состояние страницы,
             включая заполненные пользователем данные формы, и избежать повторной отправки при обновлении страницы.*/

            // Изменяю URL без перезагрузки страницы
            $redirectUrl = $_SERVER['REQUEST_URI'];
            $redirectUrl = strtok($redirectUrl, '?');
            $redirectUrl = $redirectUrl . '?successMessage=' . urlencode($_SESSION['successMessage'] ?? 'TYT1');
            echo "<script>history.replaceState({}, '', '$redirectUrl');</script>";

            return $this->showSendMessageForm($request, $response, ['successMessage' => $_SESSION['successMessage'] ?? '', 'fromUserName' => $fromUserName, 'fromUser' => $fromUser]);
        } else {
            return $this->showSendMessageForm($request, $response, ['successMessage' => '', 'fromUserName' => '', 'fromUserId' => '']);
        }

    }
    public function showSendMessageForm(Request $request, Response $response, $args): Response
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        // получаю сообщение об успешной отправке из $_SESSION если есть
        $successMessage = $_SESSION['successMessage'] ?? '';

        $fromUser = $_SESSION['user_id'] ?? null;

        // получаю идентификатор текущего пользователя из сессии
        $loggedInUserId = $_SESSION['user_id'] ?? null;

        // гружу только те сообщения, которые были отправлены текущему пользователю
        $messages = $this->messageRepository->findByRecipient($loggedInUserId);
        $users = $this->userRepository->findAll();

        $loader = new FilesystemLoader(__DIR__ . '/../View/templates');
        $twig = new Environment($loader);

        $renderedTemplate = $twig->render('send-message.twig', [
            'successMessage' => $successMessage,
            'messages' => $messages,
            'users' => $users,
            'fromUserName' => $args['fromUserName'] ?? '',
            'fromUser' => $fromUser
        ]);

        $response->getBody()->write($renderedTemplate);
        return $response;
    }


    private function validateMessage(mixed $arr): array
    {
        $errors = [];

        if (empty($arr['recipient_id'])) {
            $errors['recipient_id'] = 'ID получателя является обязательным полем';
        }

        if (empty($arr['text'])) {
            $errors['text'] = 'Текст сообщения является обязательным полем';
        }

        return array_filter($errors);
    }
}