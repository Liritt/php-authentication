<?php

declare(strict_types=1);

namespace Html;

use Entity\User;

class UserProfile
{
    use StringEscaper;

    private User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toHtml(): string
    {
        return <<<HTML
                <p>Nom: {$this->escapeString($this->user->getLastName())}
                <p>Pnom: {$this->escapeString($this->user->getFirstName())}
                <p>Login: {$this->escapeString($this->user->getLogin())}
                <p>Login: {$this->escapeString($this->user->getPhone())}
HTML;
    }
}
