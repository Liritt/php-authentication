<?php

declare(strict_types=1);

namespace Service;

use Service\Exception\SessionException;

class Session
{
    /**
     * @throws SessionException
     */
    public static function start(): void
    {
        if (session_status() == PHP_SESSION_DISABLED) {
            throw new SessionException("Session fermée");
        } elseif (session_status() == PHP_SESSION_NONE) {
            if (!headers_sent()) {
                session_start();
            } else {
                throw new SessionException("T'as mis un echo");
            }
        } elseif (!session_status() == PHP_SESSION_ACTIVE) {
            throw new SessionException("Situation inconnue");
        }
    }
}
