<?php
namespace Xerpia\Modules\User\Domain\Entity;

class User
{
    private string $id;
    private string $username;
    private string $passwordHash;

    public function __construct(string $id, string $username, string $passwordHash)
    {
        $this->id = $id;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}
