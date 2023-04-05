<?php

namespace App\Entity;

use App\Repository\FriendRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: FriendRepository::class)]
#[Table(name: "friends")]
class Friend
{
    const STATUS_ACCEPTED = 'accepted';
    #[Id, Column(type: 'integer', length: 255), GeneratedValue(strategy:  'AUTO')]
    private ?int $id;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'friend_id', referencedColumnName: 'id')]
    private ?User $friend;

    public function __construct(
        User $user,
        User $friend
    )

    {
        $this->user = $user;
        $this->friend = $friend;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    public function getFriend(): User
    {
        return $this->friend;
    }
    public function setFriend(User $friend): void
    {
        $this->friend = $friend;
    }


}