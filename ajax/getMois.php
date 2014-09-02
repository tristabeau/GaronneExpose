<?php
//On inclut les modeles
require_once "../modele/requires.php";

//On inclut le fichier de config
require '../tools/config.php';

//On inclut le fichier de fonctions
require '../tools/functions.php';

// connexion avec la base de donn�es
$mysql = openConnexion();

$mois = Article::selectDistinctMois($mysql, $_POST["annee"], intval( $_POST["cat"]));
$res = "<option value='all'>Tous</option>";
     
foreach ($mois as $m) {
    $res .= "<option value='".$m["mois"]."'>".$m["mois"]."</option>";
}  

print $res;
?>