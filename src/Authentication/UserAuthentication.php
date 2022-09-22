<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\AuthenticationException;
use Entity\Exception\EntityNotFoundException;
use Entity\User;
use Service\Exception\SessionException;
use Service\Session;
use Symfony\Component\Console\Helper\Helper;

class UserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';

    private const SESSION_KEY = '__UserAuthentification__';
    private const SESSION_USER_KEY = 'user';

    private const LOGOUT_INPUT_NAME = 'logout';



    private ?User $user = null;

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $const1 = self::LOGIN_INPUT_NAME;
        $const2 = self::PASSWORD_INPUT_NAME;
        return <<<HTML
                <form action="$action" method="post">
                    <input type="text" name="{$const1}" placeholder="{$const1}">
                    <input type="text" name="{$const2}" placeholder="{$const2}">
                    <input type="submit" value="{$submitText}">
                </form>
HTML;
    }

    /**
     * @throws SessionException
     */
    protected function setUser(?User $user): void
    {
        $this->user = $user;
        Session::start();
        $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] = $user;
    }

    /**
     * @throws AuthenticationException|SessionException
     */
    public function getUserFromAuth(): User
    {
        if (!isset($_POST[self::LOGIN_INPUT_NAME]) || !isset($_POST[self::PASSWORD_INPUT_NAME])) {
            throw new AuthenticationException("login ou mdp incorrect");
        }

        try {
            $user = User::findByCredentials($_POST[self::LOGIN_INPUT_NAME], $_POST[self::PASSWORD_INPUT_NAME]);
        } catch (EntityNotFoundException $e) {
            throw new AuthenticationException("login ou mdp incorrect");
        }
        $this->setUser($user);
        return $user;
    }

    /**
     * @throws SessionException
     */
    public function isUserConnected(): bool
    {
        Session::start();

        return isset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY])
            && $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] instanceof User;
    }

    public function logoutForm(string $action, string $text): string
    {
        $nameInput = self::LOGOUT_INPUT_NAME;
        $html = "<form action={$action} method='post'>
                    <input type='submit' name='{$nameInput}' value='{$text}'>
                 </form>";
        return $html;
    }

    /**
     * @throws SessionException
     */
    public function logoutIfRequested(): void
    {
        Session::start();
        if (isset($_POST[self::LOGOUT_INPUT_NAME])) {
            unset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]);
        }
    }
}
