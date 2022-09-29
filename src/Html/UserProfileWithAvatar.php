<?php

declare(strict_types=1);

namespace Html;

use Entity\User;

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
            <input name="{$const}" type="file">Choose file
            <input type="submit" value="Mettre à jour">
        </form>
HTML;
        return $html;
    }
}
