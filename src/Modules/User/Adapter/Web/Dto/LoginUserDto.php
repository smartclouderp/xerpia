<?php
namespace Xerpia\Modules\User\Adapter\Web\Dto;

class LoginUserDto
{
    public string $username;
    public string $password;

    public function __construct(array $data)
    {
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
    }

    public function isValid(): array
    {
        $errors = [];
        if (empty($this->username)) {
            $errors[] = 'El nombre de usuario es requerido.';
        }
        if (empty($this->password)) {
            $errors[] = 'La contraseña es requerida.';
        }
        return $errors;
    }
}
