<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

session_start();

// Tus credenciales
$clientId = '85552810135-5jjiooo902r0p3qc679fedgkjvsdo853.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/get_oauth_token.php'; // debe coincidir con lo configurado en Google Console

$provider = new Google([
    'clientId'     => $clientId,
    'clientSecret' => $clientSecret,
    'redirectUri'  => $redirectUri,
]);

if (!isset($_GET['code'])) {
    // Paso 1: redirigir al usuario a Google
    $authUrl = $provider->getAuthorizationUrl([
        'scope' => ['https://mail.google.com/']
    ]);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
    // Paso 2: obtener el token
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    echo "Access Token: " . $token->getToken() . "<br>";
    echo "Refresh Token: " . $token->getRefreshToken() . "<br>";
    echo "Expires: " . $token->getExpires() . "<br>";
}
