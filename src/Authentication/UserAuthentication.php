<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\AuthenticationException;
use Entity\Exception\EntityNotFoundException;
use Entity\User;

class UserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';

    public const SESSION_KEY = '__UserAuthentification';
    public const SESSION_USER_KEY = 'user';

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
     * @throws AuthenticationException
     * @throws EntityNotFoundException
     */
    public function getUserFromAuth(): User
    {
        if (!User::findByCredentials($_POST[self::LOGIN_INPUT_NAME], $_POST[self::PASSWORD_INPUT_NAME])) {
            throw new AuthenticationException("Cet utilisateur n'existe pas");
        }
        return User::findByCredentials($_POST[self::LOGIN_INPUT_NAME], $_POST[self::PASSWORD_INPUT_NAME]);
    }
}
