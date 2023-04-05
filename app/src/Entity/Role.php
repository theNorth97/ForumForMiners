<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: RoleRepository::class)]
#[Table(name: "roles")]
class Role
{
    #[Id, Column(type: 'string', length: 255), GeneratedValue(strategy:  'AUTO')]
    private string $code;

    #[Column(type: 'string', length: 255, nullable: true)]
    private string $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}
