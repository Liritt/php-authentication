<?php

declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Html\AppWebPage;
use Html\UserProfileWithAvatar;

$authentication = new UserAuthentication();

$p = new AppWebPage('Authentification');

try {
    // Tentative de connexion
    $user = $authentication->getUser();
    $userProfile = new UserProfileWithAvatar($user, $_SERVER['PHP_SELF']);
    $userProfile->updateAvatar();
    $p->appendContent(
        <<<HTML
    <div>
        {$authentication->logoutForm('form.php', 'Se déconnecter')} 
        {$userProfile->toHtml()}
    </div>
HTML
    );
} catch (NotLoggedInException $e) {
    // Récupération de l'exception si connexion échouée
    header("Location: form.php");
    exit(0);
} catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}");
}

// Envoi du code HTML au navigateur du client
echo $p->toHTML();
