<?php

use App\Controller\DashboardController;
use App\Controller\FriendController;
use App\Controller\MessageController;
use App\Controller\UserController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';
/** @var \UMA\DIC\Container $container */
$container = require __DIR__ . '/../config/bootstrap.php'; //Получаю объект контейнера зависимостей, используя файл bootstrap.php

$app = AppFactory::create(null, $container);// Создаем экземпляр приложения Slim ??зачем передаю


$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello world!!!!");
    return $response;
});
$app->post('/signup', [UserController::class, 'signUp']);
$app->get('/signIn', [UserController::class, 'signIn']); // роут который достает пользователя из БД ++
$app->post('/sendMessage', [MessageController::class, 'sendMessage']); // роут который отправляет сообщения ++
$app->delete('/deleteMess/{id}', [UserController::class, 'deleteMess']); // роут удаляет сообщения

$app->post('/friends', [FriendController::class, 'addFriend']);
$app->get('/friends',[FriendController::class, "friends"]);


//$app->put('/editUser/{id}', [UserController::class, "editUser"]); // роут который редактирует пользователя
//$app->delete('/users/{user_id}/friends/{friend_id}', [UserController::class, "removeFriend"]); // роут который удаляет пользователя из друзей
//$app->get('/users', [UserController::class, "index"]); // роут который выводит список Почт всех пользователей

$app->get('/registration',[UserController::class, "openRegistration"]); // роут формы Регистрации ++
$app->post('/registration', [UserController::class, 'signUp']); // роут для обработки формы успешной регистрации ++
$app->get('/successReg', [UserController::class, 'successBoard']); // роут формы успешной Регистрации ++
$app->get('/login', [UserController::class, "displayLoginForm"]); // роут для формы входа ++
$app->post('/login', [UserController::class, "signIn"]); // роут для обработки отправленной формы входа ++
$app->get('/dashboard/{id}', [DashboardController::class, 'dashboard']); // роут входа в ЛК ++

$app->get('/send-message', [MessageController::class, 'showSendMessageForm']); // форма сообщений
$app->post('/send-message', [MessageController::class, 'sendMessage']); //  отправка сообщений

$app->run();


