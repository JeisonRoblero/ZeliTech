<?php
    // CONFIGURACION DE GOOGLE
    $clientID = '554321084918-2004jfvuci50l1cvt8v7h7m34ivesbbv.apps.googleusercontent.com';
    $clientSecret = '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';
    $redirectUri = 'https://www.amazingstore.cf//?p=registrarse';

    //config.php

    //Incluyendo la libreria cliente de Google para el archivo de carga automática PHP
    require_once 'vendor/autoload.php';

    //Creando un objeto de Google API Client para llamar a la API de Google
    $google_client = new Google_Client();

    //Estableciendo el ID de cliente de OAuth 2.0
    $google_client->setClientId($clientID);

    //Estableciendo la clave secreta de cliente de OAuth 2.0
    $google_client->setClientSecret($clientSecret);

    //Estableciendo el URI de redireccionamiento de OAuth 2.0
    $google_client->setRedirectUri($redirectUri);

    //Para obtener el correo electrónico y el perfil
    $google_client->addScope('email');
    $google_client->addScope('profile');


?>