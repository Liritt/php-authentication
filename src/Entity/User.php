<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class User
{
    private int $id;
    private string $lastName;
    private string $firstName;
    private string $login;
    private string $phone;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @throws EntityNotFoundException
     */
    public static function findByCredentials(string $login, string $password): self
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT id, lastName, firstName, login, phone
            FROM user 
            WHERE login = :login AND sha512pass = SHA2(:password, 512)
SQL
        );

        $stmt->execute([':login' => $login, ':password' => $password]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);

        $user = $stmt->fetch();

        if ($user == null) {
            throw new EntityNotFoundException("Login ou mot de passe faux");
        }
        return $user;
    }
}
