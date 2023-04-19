<?php
//session_destroy();
//redir("./");

//logout.php

include('config.php');

if(isset($_SESSION['id_cliente'])){
    //Restableciendo el token de acceso de OAuth
    $client->revokeToken();
}

//Destruyendo todos los datos de la sesión.
session_destroy();

//Redirigiendo a la página principal
redir("./");
?>