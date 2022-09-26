<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\UserAvatar;

try {
    $userId = $_GET['id'];
    $avatar = UserAvatar::findById($userId);
} catch (EntityNotFoundException $e) {
}