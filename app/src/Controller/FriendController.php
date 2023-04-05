<?php

namespace App\Controller;

use App\Entity\Friend;
use App\Entity\FriendRequest;
use App\Repository\FriendRepository;
use App\Repository\FriendRequestRepository;
use App\Repository\UserRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class FriendController
{
    private UserRepository $userRepository;
    private FriendRepository $friendRepository;
    private FriendRequestRepository $friendRequestRepository;

    public function __construct(UserRepository $userRepository,FriendRepository $friendRepository,FriendRequestRepository $friendRequestRepository)
    {
        $this->userRepository = $userRepository;
        $this->friendRepository = $friendRepository;
        $this->friendRequestRepository = $friendRequestRepository;
    }

//    public function addFriend(Request $request, Response $response, $args) :Response
//    {
//        if (!isset($_SESSION)) {
//            session_start();
//        }
//
//        $arr = $request->getParsedBody();
//        $userRepository = $this->userRepository;
//
//        $friendId = $arr['friend_id'];
//        $user = $userRepository->find($_SESSION['user_id'] ?? null);
//        $friend = $userRepository->find($friendId);
//
//        if (!$user || !$friend)
//        {
//            $response->getBody()->write(json_encode(['error'=>'Пользователь или друг не найден']));
//            return $response;
//        }
//
//        $existingFriendship1 = $this->friendRepository->findOneBy(['user' => $user, 'friend' => $friend]);
//        $existingFriendship2 = $this->friendRepository->findOneBy(['user' => $friend, 'friend' => $user]);
//
//        if ($existingFriendship1 || $existingFriendship2) {
//            $response->getBody()->write(json_encode(['error' => 'Пользователь уже является другом']));
//            return $response;
//        }
//
//        // создаю новую дружбу
//        $friendship = new Friend($user,$friend);
//
//        $this->friendRepository->save($friendship,true);
//
//        // создаю новый запрос на дружбу
//        $friendRequest = new FriendRequest($user, $friend);
//
//        $this->friendRequestRepository->save($friendRequest, true);
//
//        // показать сообщение об успешном добавлении друга
//        $_SESSION['success_message'] = 'Запрос на дружбу успешно отправлен';
//        return $response->withHeader('Location', '/friends');
//
//    }

//    public function friends(Request $request, Response $response, $args): Response
//    {
//        if (!isset($_SESSION)) {
//            session_start();
//        }
//
//        $user = $_SESSION['user_id'] ?? null;
//
//        // получаю идентификатор текущего пользователя из сессии
//        $loggedInUserId = $_SESSION['user_id'] ?? null;
//
//        // id дружбы
//        $friendshipId = $args['friendship_id'] ?? null;
//
//        $friendship = $this->friendRepository->find($friendshipId);
//
//        // проверяю что найдена дружба
//        if (!$friendship) {
//            $response->getBody()->write(json_encode(['error' => 'Дружба не найдена']));
//            return $response;
//        }
//
//
//
//

//
//        // показываем сообщение об успешном создании дружбы
//        $_SESSION['success_message'] = 'Запрос на дружбу принят';
//        return $response->withHeader('Location', '/friends');
//
//    }

//    public function removeFriend(Request $request, Response $response, $args) :Response
//    {
//        $userId = $args['user_id'];
//        $friendId = $args['friend_id'];
//
//        $userRepository = $this->entityManager->getRepository(User::class);
//
//        $user = $userRepository->find($userId);
//        $friend = $userRepository->find($friendId);
//
//        if (!$user || !$friend)
//        {
//            $response->getBody()->write(json_encode(['error'=>'Пользователь или друг не найден']));
//            return $response;
//        }
//
//        // проверяю, является ли другом
//        $friendRepository = $this->entityManager->getRepository(Friend::class);
//        $existingFriendship = $friendRepository->findOneBy(['user' => $user, 'friend' => $friend]);
//
//        if (!$existingFriendship) {
//            $response->getBody()->write(json_encode(['error' => 'Пользователь не является другом']));
//            return $response;
//        }
//
//        // удаляю дружбу
//        $this->entityManager->remove($existingFriendship);
//        $this->entityManager->flush();
//
//        $response->getBody()->write(json_encode(['success' => 'Пользователь успешно удален из друзей']));
//        return $response;
//    }
}
