<?php
namespace App\config;

use App\Controller\DashboardController;
use App\Controller\FriendController;
use App\Controller\MessageController;
use App\Controller\StatAsicController;
use App\Controller\UserController;
use App\Entity\Friend;
use App\Entity\FriendRequest;
use App\Entity\Message;
use App\Entity\Role;
use App\Entity\User;
use App\Repository\FriendRepository;
use App\Repository\FriendRequestRepository;
use App\Repository\MessageRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Slim\Views\PhpRenderer;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use UMA\DIC\Container;

return [
    UserController::class => function (Container $container) {

        $entityManager = $container->get(EntityManager::class);  // Получаю объект EntityManager из контейнера зависимостей

        $userRepository = $entityManager->getRepository(User::class);

        /** @var RoleRepository $roleRepository */
        $roleRepository = $entityManager->getRepository(Role::class);

        $renderer = $container->get(PhpRenderer::class);

    return new UserController($userRepository, $roleRepository, $renderer);
},

    MessageController::class => function (Container $container) {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(User::class);

        /** @var MessageRepository $messageRepository */
        $messageRepository = $entityManager->getRepository(Message::class);

    return new MessageController($messageRepository, $userRepository );

    },

    FriendRequestRepository::class => function (Container $container) {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        return $entityManager->getRepository(FriendRequest::class);
    },

    FriendController::class => function (Container $container) {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(User::class);

        /** @var FriendRepository $friendRepository */
        $friendRepository = $entityManager->getRepository(Friend::class);

        /** @var FriendRequestRepository $friendRequestRepository */
        $friendRequestRepository = $container->get(FriendRequestRepository::class);

        return new FriendController($userRepository, $friendRepository, $friendRequestRepository);

    },

    StatAsicController::class => function (Container $container) {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        return new StatAsicController($entityManager);
    },

EntityManager::class => static function (Container $c): EntityManager {

    /** @var array $settings */
    $settings = $c->get('settings');

    $cache = $settings['doctrine']['dev_mode'] ?
        DoctrineProvider::wrap(new ArrayAdapter()) :
        DoctrineProvider::wrap(new FilesystemAdapter(directory: $settings['doctrine']['cache_dir']));
    $config = Setup::createAttributeMetadataConfiguration(
        $settings['doctrine']['metadata_dirs'],
        $settings['doctrine']['dev_mode'],
        null,
        $cache
    );
    return EntityManager::create($settings['doctrine']['connection'], $config);
    },

    PhpRenderer::class => function () {
        return new PhpRenderer("../src/View/templates");
    },

    DashboardController::class => function (Container $container) {
        $renderer = $container->get(PhpRenderer::class);
        return new DashboardController($container->get(EntityManager::class));
    },
//
//    SuccessView::class => function (Container $container) {
//        $renderer = $container->get(PhpRenderer::class);
//        return new SuccessView($renderer);
//    }

];