<?php

declare(strict_types=1);

namespace Authentication;

class UserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $const1 = self::LOGIN_INPUT_NAME;
        $const2 = self::PASSWORD_INPUT_NAME;
        return <<<HTML
                <form action="$action">
                    <input type="text" placeholder="{$const1}">
                    <input type="text" placeholder="{$const2}">
                    <input type="submit" value="{$submitText}">
                </form>
HTML;
    }
}
