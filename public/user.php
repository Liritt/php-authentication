<?php

declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Authentication\Exception\AuthenticationException;
use Html\UserProfile;
use Html\WebPage;

$authentication = new UserAuthentication();

$p = new WebPage('Authentification');

try {
    // Tentative de connexion
    $user = $authentication->getUser();
    $userProfile = new UserProfile($user);
    $p->appendContent(
        <<<HTML
<div>{$authentication->logoutForm('form.php', 'Se déconnecter')} Bonjour {$userProfile->toHtml()}</div>
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
