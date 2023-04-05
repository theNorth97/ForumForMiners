<?php

namespace App\Repository;

use App\Entity\Friend;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;


class FriendRequestRepository extends EntityRepository
{
    public function getFriendRequests(User $user): array
    {
        return $this->findBy(['friend' => $user]);
    }

    public function save(Friend $friendship, bool $flush = false): void
    {
        $this->getEntityManager()->persist($friendship);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}