<?php
namespace Xerpia\Modules\User\Adapter\Web\Dto;

class RegisterUserDto
{
    public string $username;
    public string $password;
    public array $roles;

    public function __construct(array $data)
    {
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->roles = $data['roles'] ?? [];
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
        if (empty($this->roles) || !is_array($this->roles)) {
            $errors[] = 'Debe asignar al menos un rol.';
        }
        return $errors;
    }
}
