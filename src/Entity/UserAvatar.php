<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class UserAvatar
{
    private int $id;
    private ?string $avatar;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @throws EntityNotFoundException
     */
    public static function findById(int $userid): self
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT id, avatar
            FROM user
            WHERE id = ?
SQL
        );
        $stmt->execute([$userid]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, UserAvatar::class);

        $user = $stmt->fetch();
        if (empty($user)) {
            throw new EntityNotFoundException("Cet utilisateur n'existe pas");
        }

        return $user;
    }
}
