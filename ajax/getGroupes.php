<?php
//On inclut les modeles
require_once "../modele/requires.php";

//On inclut le fichier de config
require '../tools/config.php';

//On inclut le fichier de fonctions
require '../tools/functions.php';

// connexion avec la base de données
$mysql = openConnexion();

$groupes = Groupe::loadAll($mysql);
$res = array();

foreach ($groupes as $groupe) {
    $tab["value"] = $groupe->getIdGroupe();
    $tab["text"] = $groupe->getNom();
    $res[] = $tab;
}

print json_encode($res);
?>