<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: UserRepository::class), Table(name: 'users')]
class User
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    protected int $id;
    #[ManyToOne(targetEntity: Role::class)]
    #[JoinColumn(name: "role_code", referencedColumnName: "code")]
    private Role $role;
    #[Column(name: "password", type: "string", length: 100)]
    private string $password;
    #[Column(name: "first_name", type: "string", length: 50)]
    private string $first_name;
    #[Column(name: "last_name", type: "string", length: 50)]
    private string $last_name;
    #[Column(name: "email", type: "string", length: 50)]
    private string $email;
    #[Column(name: "info", type: "string", length: 100)]
    private string $info;
    #[Column(name: "phone", type: "string", length: 20)]
    private string $phone;
    #[Column(name: 'token',type: 'string')]
    private ?string $token;

    #[Column(name: 'avatar',type: 'string')]
    private string $avatar;

    public function __construct(
        Role $role,
        string $password,
        string $first_name,
        string $last_name,
        string $email,
        string $info,
        string $phone,
        string $token = null)
    {
        $this->role = $role;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->info = $info;
        $this->phone = $phone;
        $this->token = $token;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): void
    {
        $this->info = $info;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getToken(): string
    {
        return $this->token;
    }
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): void
    {
       $this->avatar = $avatar;

    }

    public function toArray(): array
    {
        return [
            'role' => $this->role,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'id' => $this->id,
            'info' => $this->info,
            'phone' => $this->phone,
            'token' => $this->token
        ];
    }
}

