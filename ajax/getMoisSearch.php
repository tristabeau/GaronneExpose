<?php
//On inclut les modeles
require_once "../modele/requires.php";

//On inclut le fichier de config
require '../tools/config.php';

//On inclut le fichier de fonctions
require '../tools/functions.php';

// connexion avec la base de donn�es
$mysql = openConnexion();

$mois = Article::selectDistinctMoisBySearch($mysql, $_POST["annee"], $_POST["search"]);
$res = "<option value='all'>Tous</option>";
     
foreach ($mois as $m) {
    $res .= "<option value='".$m["mois"]."' ".$selected.">".$m["mois"]."</option>";
}  

print $res;
?>