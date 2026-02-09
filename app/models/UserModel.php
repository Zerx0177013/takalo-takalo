<?php
declare(strict_types=1);

namespace app\models;

class UserModel
{
    private ?int $idUser;
    private string $username;
    private string $email;
    private string $password;

    public function __construct(?int $idUser, string $username, string $email, string $password)
    {
        $this->idUser = $idUser;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['idUser'] ?? null,
            $data['username'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? ''
        );
    }

    public function getId(): ?int
    {
        return $this->idUser;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->password;
    }
}

?>
