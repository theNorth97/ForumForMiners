<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\PhpRenderer;

class UserController
{
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;
    private PhpRenderer $renderer;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository, PhpRenderer $renderer)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->renderer = $renderer;

    }

    public function signUp(Request $request, Response $response, $args): Response
    {

        $arr = $request->getParsedBody(); // метод который принимает данные формы вместо JSON

        $errors = $this->validateSignUp($arr);

        if (!empty($errors)) {
            $response->getBody()->write(json_encode($errors));
            return $response;
        }

        $password = $arr['password'];
        $first_name = $arr['first_name'];
        $last_name = $arr['last_name'];
        $email = $arr['email'];
        $info = $arr['info'];
        $phone = $arr['phone'];

        $role = $this->roleRepository->findOneBy(['code' => 'user']);

        $password = password_hash($password, PASSWORD_DEFAULT);
        $user = new User(
            $role,
            $password,
            $first_name,
            $last_name,
            $email,
            $info,
            $phone
        );

        if (empty($errors)) {

            $this->userRepository->save($user, true);

            return $response->withHeader('Location', '/successReg')->withStatus(302);

        }

        $response->getBody()->write(json_encode($errors));
        return $response;

    }

    private function validateSignUp(array $arr): array
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $errors = [];

        if (empty($arr['first_name'])) {
            $errors["first_name"] = "Имя не должно быть пустым";
        } elseif (mb_strlen($arr['first_name']) > 30) {
            $errors["first_name"] = "Имя не должно быть больше 30 символов";
        }

        if (empty($arr['last_name'])) {
            $errors["last_name"] = "Фамилия не должно быть пустым";
        } elseif (mb_strlen($arr['last_name']) > 30) {
            $errors["last_name"] = "Фамилия не должно быть больше 30 символов";
        }

        $errorsEmail = $this->validateEmailSignUp($arr);
        if (!empty($errorsEmail)) {
            $errors["email"] = $errorsEmail;
        }

        $errorsPass = $this->validatePassSignUp($arr);
        if (!empty($errorsPass)) {
            $errors["password"] = $errorsPass;
        }

        if (empty($arr['phone'])) {
            $errors["phone"] = "Телефон не должен быть пустым";
        } elseif (mb_strlen($arr['phone']) > 12) {
            $errors["phone"] = "Телефон не должен быть больше 12 символов";
        }

        if (empty($arr['info'])) {
            $errors["info"] = "Информация о пользователе не должна быть пустой";
        } elseif (mb_strlen($arr['info']) > 100) {
            $errors["info"] = "информация о пользователе не должна быть больше 100 символов";
        }

        return $errors;
    }

    private function validateEmailSignUp(array $arr): ?string
    {
        if (empty($arr['email'])) {
            $_SESSION['error-mail'] = "Пустое значение в строке 'Почта'";
        } elseif (mb_strlen($arr['email']) < 15) {
            $_SESSION['error-mail'] = "Почта слишком короткая";
        } elseif (mb_strlen($arr['email']) > 30) {
            $_SESSION['error-mail'] = "Слишком длинное значение в строке 'Почта' (рекомендуется не более 30 символов)";
        }

        if (isset($_SESSION['error-mail'])) {
            $errorMessage = $_SESSION['error-mail'];
            unset($_SESSION['error-mail']);
            $_SESSION['error-mail'] = $errorMessage;
            header('Location: http://localhost/registration');
            exit();
        }

        return null;
    }

    private function validatePassSignUp(array $arr): ?string
    {
        if (empty($arr['password'])) {
            $_SESSION['error-pass'] = 'Введите пароль';
        } elseif (strlen($arr['password']) < 5) {
            $_SESSION['error-pass'] = 'Пароль должен содержать не менее 5 символов';
        } elseif (strlen($arr['password']) > 30) {
            $_SESSION['error-pass'] = 'Пароль должен содержать более 30 символов';
        } elseif (!preg_match('/[A-Za-z]/', $arr['password']) || !preg_match('/[0-9]/', $arr['password'])) {
            $_SESSION['error-pass'] = 'Пароль должен содержать буквы и цифры';
        } else {
            return null;
        }
        header('Location: http://localhost/registration');
        exit();
    }

    public function openRegistration(RequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        return $this->renderer->render($response, "sign-up.php", $args);
    }

    public function successBoard(RequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        return $this->renderer->render($response, "successReg.php", );
    }




    public function signIn(Request $request, Response $response, $args): Response
    {
        $arr = $request->getParsedBody();

        $errors = $this->validateSignIn($arr);

        if (!empty($errors)) {
            $response->getBody()->write(json_encode($errors));
            return $response;
        }

        $email = $arr['email'];
//        $password = $arr['password'];
        $user = $this->userRepository->findOneBy(['email' => $email]);


        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['user_id'] = $user->getId();

        $user = $this->userRepository->find($user->getId());
        $token = hash('sha256', $user->getId());
        $user->setToken($token);
        $this->userRepository->save($user, true);

        $url = "/dashboard/{$user->getId()}";
        return $response->withHeader('Location', $url)->withStatus(302);

    }

    private function validateSignIn(array $arr): array
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $errors = [];

        $errorsEmail = $this->validateEmailSignIn($arr);
        if (!empty($errorsEmail)) {
            $errors["email"] = $errorsEmail;
        }

        $errorsPass = $this->validatePassSignIn($arr);
        if (!empty($errorsPass)) {
            $errors["password"] = $errorsPass;
        }
        return $errors;
    }

    private function validateEmailSignIn(array $arr): ?string
    {
        $email = $arr['email'];
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (empty($arr['email'])) {
            $_SESSION['error-mail'] = "Пустое значение в строке 'Почта'";
        } elseif (mb_strlen($arr['email']) < 15) {
            $_SESSION['error-mail'] = "Почта слишком короткая";
        } elseif (mb_strlen($arr['email']) > 30) {
            $_SESSION['error-mail'] = "Слишком длинное значение в строке 'Почта' (рекомендуется не более 30 символов)";
        } elseif (!$user instanceof User) {
            $_SESSION['error-mail'] = "Пользователь с такой почтой не зарегистрирован";
        }

        if (isset($_SESSION['error-mail'])) {
            $errorMessage = $_SESSION['error-mail'];
            unset($_SESSION['error-mail']);
            $_SESSION['error-mail'] = $errorMessage;
            header('Location: http://localhost/login');
            exit();
        }

        return null;
    }

    private function validatePassSignIn(array $arr): ?string
    {
        $email = $arr['email'];
        $password = $arr['password'];
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (empty($arr['password'])) {
            $_SESSION['error-pass'] = 'Введите пароль';
        } elseif (strlen($arr['password']) < 5) {
            $_SESSION['error-pass'] = 'Пароль должен содержать не менее 5 символов';
        } elseif (strlen($arr['password']) > 30) {
            $_SESSION['error-pass'] = 'Пароль должен содержать более 30 символов';
        } elseif (!preg_match('/[A-Za-z]/', $arr['password']) || !preg_match('/[0-9]/', $arr['password'])) {
            $_SESSION['error-pass'] = 'Пароль должен содержать буквы и цифры';
        } elseif (!password_verify($password, $user->getPassword())) {
            $_SESSION['error-pass'] = 'Пароль введен не верно';
        } else {
        return null;
    }
        header('Location: http://localhost/login');
        exit();
    }

    public function displayLoginForm(RequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        return $this->renderer->render($response, "sign-in.php", $args);
    }




//    public function editUser(Request $request, Response $response, $args): Response
//    {
//        $arr = json_decode($request->getBody()->getContents(), true);
//
//        $userRepository = $this->entityManager->getRepository(User::class);
//        $user = $userRepository->findOneBy(['id'=> $args['id']]);
//
//        $errors = $this->validateEditUser($arr);
//        if (!empty($errors))
//        {
//            $errors = json_encode($errors);
//            $response->getBody()->write($errors);
//            return $response;
//        }
//
//        if (!$user instanceof User) {
//            $errors = "Не удалось авторизоваться";
//            $response->getBody()->write($errors);
//            return $response->withStatus(401);
//        }
//
//        if (empty($arr))
//        {
//            $user = $user->toArray();
//            $response->getBody()->write(json_encode($user));
//            return $response;
//        }
//
//        if (!empty($arr['first_name']))
//        {
//            if ($arr['first_name'] !== $user->getFirstName())
//            {
//                $firstName = $arr['first_name'];
//                $user->setFirstName($firstName);
//            }
//        }
//
//        if (!empty($arr['last_name']))
//        {
//            if ($arr['last_name'] !== $user->getLastName())
//            {
//                $lastname = $arr['last_name'];
//                $user->setLastName($lastname);
//            }
//        }
//
//        if (!empty($arr['password']))
//        {
//            $password = password_hash($arr['password'], PASSWORD_DEFAULT); //шифрую пасс
//
//            if (!password_verify($arr['password'], $user->getPassword())) //сравниваю с зашифрованным пасс-ом пользователя
//            {
//                $user->setPassword($password);
//            }
//        }
//
//        if (!empty($arr['email']))
//        {
//            if ($arr['email'] !== $user->getEmail())
//            {
//                $email = $arr['email'];
//                $user->setEmail($email);
//            }
//        }
//
//        if (!empty($arr['phone']))
//        {
//            if ($arr['phone'] !== $user->getPhone())
//            {
//                $phone = $arr['phone'];
//                $user->setPhone($phone);
//            }
//        }
//
//        if (!empty($arr['info']))
//        {
//            if ($arr['info'] !== $user->getInfo())
//            {
//                $info = $arr['info'];
//                $user->setInfo($info);
//            }
//        }
//
//        $this->entityManager->persist($user);
//        $this->entityManager->flush();
//
//        $response->getBody()->write(json_encode(["message" => "Данные пользователя {$user->getFullName()} успешно изменены!"]));
//
//        return $response;
//
//    }
//
//    private function validateEditUser(array $arr): array
//    {
//        $errors = [];
//
//        if (!empty($arr['password']) && (mb_strlen($arr['password']) > 50)) {
//            $errors["password"] = "Пароль пользователя не должен быть больше 50 символов";
//        }
//
//        if (!empty($arr['first_name']) && (mb_strlen($arr['first_name']) > 30)) {
//            $errors["first_name"] = "Имя не должно быть больше 30 символов";
//        }
//
//        if (!empty($arr['last_name']) && (mb_strlen($arr['last_name']) > 30)) {
//            $errors["second_name"] = "Фамилия не должно быть больше 30 символов";
//        }
//
//        if (!empty($arr['email']) && (mb_strlen($arr['email']) > 30)) {
//            $errors["email"] = "Почта пользователя не должна быть больше 30 символов";
//        }
//
//        if (!empty($arr['info']) && (mb_strlen($arr['info']) > 100)) {
//            $errors["info"] = "Информация о пользователе не должна быть больше 100 символов";
//        }
//
//        if (!empty($arr['phone']) && (mb_strlen($arr['phone']) > 12)) {
//            $errors["phone"] = "Телефон не должен быть больше 12 символов";
//        }
//
//        return $errors;
//    }
//

//
//    public function deleteMess(Request $request, Response $response, $args): Response
//    {
//        $id = $args['id'];
//
//        $messageRepository = $this->entityManager->getRepository(Message::class);
//        $message = $messageRepository->find($id);
//
//        if ($message === null) {
//            $response->getBody()->write(json_encode(['error' => 'Сообщение не найдено']));
//            return $response->withStatus(404);
//        }
//
//        $this->entityManager->remove($message);
//        $this->entityManager->flush();
//        $response->getBody()->write(json_encode(['Успешно' => 'Сообщение удалено !']));
//        return $response;
//    }
//
//
//    public function index(Request $request, Response $response) :Response
//    {
//        $userRepository = $this->entityManager->getRepository(User::class);
//        $users = $userRepository->findAll();
//
//        $emails = array_map(function ($user) {
//            return $user->getEmail();
//        }, $users);
//
//        $response->getBody()->write(json_encode(['emails' => $emails]));
//
//        return $response->withHeader('Content-Type', 'application/json');
//    }

}
