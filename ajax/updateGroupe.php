<?php
//On inclut les modeles
require_once "../modele/requires.php";

//On inclut le fichier de config
require '../tools/config.php';

//On inclut le fichier de fonctions
require '../tools/functions.php';

// connexion avec la base de données
$mysql = openConnexion();

$membre = Membre::load($mysql, $_POST["pk"]);
$membre->setGroupeById($_POST["value"]);

?>