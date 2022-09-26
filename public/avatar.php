<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\UserAvatar;

$avatar = null;

try {
    if (isset($_GET['userId'])) {
        $userId = $_GET['userId'];
        $avatar = UserAvatar::findById((int) $userId)->getAvatar();
    }
} catch (EntityNotFoundException $e) {
}

if ($avatar === null) {
    $avatar = file_get_contents('default_avatar.png');
}

