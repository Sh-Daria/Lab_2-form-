<?php

class User
{
    private ?\DateTimeImmutable $createdAt;

    public function __construct(
        private readonly string $login,
        private readonly string $password,
        private readonly string $passwordConfirmation,
        $createdAt = null,
    )
    {
        $this->createdAt = $createdAt;

        if (null === $this->createdAt) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    public function getLogin(): string
    {
        return strtolower($this->login);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isPasswordsEquals(): bool
    {
        return sha1($this->password) === sha1($this->passwordConfirmation);
    }



//    private string $login;
//    private string $password;
//    private string $passwordConfirmation;
//
//    public function __construct(string $login, string $password, string $passwordConfirmation)
//    {
//        $this->login = $login;
//        $this->password = $password;
//        $this->passwordConfirmation = $passwordConfirmation;
//    }
}