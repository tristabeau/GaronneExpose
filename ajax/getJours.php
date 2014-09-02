<?php
//On inclut les modeles
require_once "../modele/requires.php";

//On inclut le fichier de config
require '../tools/config.php';

//On inclut le fichier de fonctions
require '../tools/functions.php';

// connexion avec la base de données
$mysql = openConnexion();

$jours = Article::selectDistinctJours($mysql, $_POST["annee"], $_POST["mois"], intval( $_POST["cat"]));
$res = "<option value='all'>Tous</option>";
     
foreach ($jours as $jour) {
    $res .= "<option value='".$jour["jour"]."'>".$jour["jour"]."</option>";
}  

print $res;
?>