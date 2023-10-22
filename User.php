<?php

class User
{
    private \DateTimeImmutable $createdAt;

    public function __construct(
        private readonly string $login,
        private readonly string $password,
        private readonly string $passwordConfirmation,
    )

    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getLogin(): string
    {
        return $this->login;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isPasswordsEquals(): bool
    {
        return sha1($this->password) === sha1($this->passwordConfirmation);
    }    


}