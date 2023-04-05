<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: "App\Repository\FriendRequestRepository")]
class FriendRequest
{
      #[Id, Column(name: 'id', type: 'integer') ,GeneratedValue(strategy: 'AUTO')]
    protected int $id;

     #[ManyToOne(targetEntity: "App\Entity\User", inversedBy: "sentFriendRequests")]
     #[JoinColumn(nullable: false)]
    private  User $sender;

     #[ManyToOne(targetEntity: "App\Entity\User", inversedBy: "receivedFriendRequests")]
     #[JoinColumn(nullable: false)]
    private  User $receiver;

     #[Column(type: "datetime")]
    private DateTime $createdAt;

     #[Column(type: "datetime", nullable: true)]
    private DateTime $acceptedAt;

    public function __construct(User $sender, User $receiver)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->createdAt = new DateTime();
    }

    // геттеры и сеттеры для всех полей

    public function setId($id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSender(): User
    {
        return $this->sender;
    }

    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    public function getReceiver(): User
    {
        return $this->receiver;
    }

    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAcceptedAt(): DateTime
    {
        return $this->acceptedAt;
    }

    public function setAcceptedAt($acceptedAt): void
    {
        $this->acceptedAt = $acceptedAt;
    }
}

