<?php
declare(strict_types=1);

namespace Html;

use Authentication\UserAuthentication;
use Service\Exception\SessionException;
use Service\Session;

class UserProfileWithAvatar extends UserProfile
{
    /**
     * @throws SessionException
     */
    public function toHtml(): string
    {
        Session::start();
        $userId = parent::getUser()->getId();
        $html = parent::toHtml();
        $html .= <<<HTML
<img src="avatar.php?userId={$userId}" alt="avatar" />
HTML;
        return $html;
    }
}