<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\UserAvatar;

try {
    if (isset($_GET['userId']) && ctype_digit($_GET['userId'])) {
        $userId = $_GET['userId'];
        echo UserAvatar::findById((int) $userId)->getAvatar();
    }
} catch (EntityNotFoundException $e) {
    echo file_get_contents('default_avatar.png');
}
