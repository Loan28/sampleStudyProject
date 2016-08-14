<?php

// Prépare une variable $connexion

$PARAM_hote = 'localhost'; // le chemin vers le serveur
$PARAM_port = '3306';
$PARAM_nom_bd = 'clubnautiquelanderon'; // le nom de votre base de données
$PARAM_utilisateur = 'root'; // nom d'utilisateur pour se connecter
$PARAM_mot_passe = 'pass'; // mot de passe de l'utilisateur pour se connecter
$PARAM_UTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); //On travaillera avec le client MySql en UTF8
//Interception de l'erreur
try {
    $connexion = new PDO('mysql:host=' . $PARAM_hote . ';dbname=' . $PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe, $PARAM_UTF8);
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage() . '<br />N° : ' . $e->getCode();
    die();
}
?>
