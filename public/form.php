<?php

declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Html\AppWebPage;
use Html\UserProfile;

// Création de l'authentification
$authentication = new UserAuthentication();

$authentication->logoutIfRequested();

$p = new AppWebPage('Authentification');

// Production du formulaire de connexion
$p->appendCSS(
    <<<CSS
    form input {
        width : 7em ;
    }
CSS
);

try {
    $user = $authentication->getUser();
    $form = $authentication->logoutForm('form.php', 'déconnexion');
    $userProfile = new UserProfile($user);
    $p->appendContent(
        <<<HTML
    {$form}
    {$userProfile->toHtml()}
    <br>
HTML
    );
} catch(NotLoggedInException) {
    $form = $authentication->loginForm('auth.php');
    $p->appendContent(
        <<<HTML
    {$form}
    <p>Pour faire un test : essai/toto
HTML
    );
}

echo $p->toHTML();
