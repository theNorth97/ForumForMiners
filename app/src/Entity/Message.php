<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: MessageRepository::class), Table(name: 'messages')]
class Message{

    #[Id, Column(name: 'id', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[Column(name: 'text', type: 'string')]
    protected string $text;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'sender_id', referencedColumnName: 'id')]
    private User $sender;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'recipient_id', referencedColumnName: 'id')]
    private User $recipient;

    #[Column(name: 'datetime_publication', type: 'datetime', nullable: false)]
    private DateTime $datetime_publication;

    public function __construct(
        User $sender,
        string $text,
        User $recipient,
        DateTime $datetime_publication
    )
    {
        $this->sender = $sender;
        $this->text = $text;
        $this->recipient = $recipient;
        $this->datetime_publication = $datetime_publication;
    }


    // геттеры и сеттеры
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(int $text): void
    {
        $this->text = $text;
    }

    public function getSender(): User
    {
        return $this->sender;
    }

    public function setSender(User $sender): void
    {
        $this->sender = $sender;
    }

    public function getRecipient(): User
    {
        return $this->recipient;
    }

    public function setRecipient(User $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getDateTimePublication() :DateTime
    {
        return $this->datetime_publication;
    }

    public function setDateTimePublication(DateTime $datetime_publication): void
    {
        $this->datetime_publication = $datetime_publication;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'text' => $this->getText(),
            'sender_id' => $this->getSender(),
            'recipient_id' => $this->getRecipient(),
            'datetime_publication' => $this->getDatetimePublication()
        ];
    }
}
