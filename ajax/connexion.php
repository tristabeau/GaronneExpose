<?php
session_start();

//On inclut les modeles
require_once "../modele/requires.php";

//On inclut le fichier de config
require '../tools/config.php';

//On inclut le fichier de fonctions
require '../tools/functions.php';

// connexion avec la base de données
$mysql = openConnexion();

//Si le membre existe
if (isset($_POST["login"])) {
    $membre = Membre::selectByPseudo($mysql, $_POST["login"]);
    if (count($membre)) {
        $pass = md5(md5($membre[0]->getSalt()).md5($_POST["password"]));
        if ($pass == $membre[0]->getMdp()) {
            if ($membre[0]->getActive()) {
                $_SESSION["idMembre"] = $membre[0]->getIdMembre();
                setCookie('membre', $membre[0]->getIdMembre(), time()+60*60*24*30, "/"); //30j
                echo "2";
            } else {
                echo "1";
            }
        } else {
            echo "0";
        }            
    } else {
        echo "0";
    }
}
?>