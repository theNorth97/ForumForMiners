<?php

namespace App\Repository;

use App\Entity\Friend;
use Doctrine\ORM\EntityRepository;

class FriendRepository extends EntityRepository
{
    public function save(Friend $friendship, bool $flush = false): void
    {
        $this->getEntityManager()->persist($friendship);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
