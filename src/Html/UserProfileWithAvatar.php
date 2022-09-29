<?php

declare(strict_types=1);

namespace Html;

use Entity\Exception\EntityNotFoundException;
use Entity\User;
use Entity\UserAvatar;
use Html\Helper\Dumper;

class UserProfileWithAvatar extends UserProfile
{
    public const AVATAR_INPUT_NAME = 'avatar';

    private string $formAction;

    /**
     * @param User $user
     * @param string $formAction
     */
    public function __construct(User $user, string $formAction)
    {
        parent::__construct($user);
        $this->formAction = $formAction;
    }

    public function toHtml(): string
    {
        $userId = parent::getUser()->getId();
        $html = parent::toHtml();
        $const = self::AVATAR_INPUT_NAME;
        $html .= <<<HTML
        <img src="avatar.php?userId={$userId}" alt="avatar" />
        <form action="{$this->formAction}" method="post" enctype="multipart/form-data">
            Changer: <input name="{$const}" type="file">
            <input type="submit" value="Mettre à jour">
        </form>
HTML;
        return $html;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function updateAvatar(): bool
    {
        if (isset($_FILES[self::AVATAR_INPUT_NAME])
            && $_FILES[self::AVATAR_INPUT_NAME]['error'] === UPLOAD_ERR_OK
            && $_FILES[self::AVATAR_INPUT_NAME]['size'] > 0
            && is_uploaded_file($_FILES[self::AVATAR_INPUT_NAME]['tmp_name'])
            && UserAvatar::isValidFile($_FILES[self::AVATAR_INPUT_NAME]['tmp_name'])) {

            $currAvatar = UserAvatar::findById($this->getUser()->getId());
            $currAvatar->setAvatar(file_get_contents($_FILES[self::AVATAR_INPUT_NAME]['tmp_name']));
            $currAvatar->save();
            return true;
        }
        return false;
    }
}
