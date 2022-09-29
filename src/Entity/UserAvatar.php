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

    protected function __construct()
    {
    }

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

    /**
     * @param string|null $avatar
     * @return UserAvatar
     */
    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function save(): self
    {
        $request = MyPdo::getInstance()->prepare(
            <<<'SQL'
        UPDATE user
        SET avatar = :avatar
        WHERE id = :id
SQL
        );
        $request->execute(['id' => $this->id, 'avatar' => $this->avatar]);

        return $this;
    }

    public static function maxFileSize(): int
    {
        return 65535;
    }

    public static function isValidFile(string $filename): bool
    {
        return mime_content_type($filename) == "image/png" && getimagesize($filename);
    }
}
