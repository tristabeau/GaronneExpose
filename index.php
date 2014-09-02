<?php
session_start();

//On inclut les modeles
require_once "modele/requires.php";

//On inclut le fichier de config
require 'tools/config.php';

//On inclut le fichier de fonctions
require 'tools/functions.php';

//On inclut le controlleur
require_once "controlleur/controlleur.php";
require_once "controlleur/controlleurAdmin.php";

$mysql = openConnexion();

$admin = false;
$artiste = false;

if (isset($_COOKIE["membre"])) {
    $_SESSION["idMembre"] = $_COOKIE["membre"];
}

if (isset($_SESSION["idMembre"])) {
    $membreCo = Membre::load($mysql, $_SESSION["idMembre"]);
    if ($membreCo->getGroupeId() == 3) {
        $admin = true;
    }
    if (($membreCo->getGroupeId() == 2) || ($membreCo->getGroupeId() == 4)) {
        $artiste = true;
    }
}

//var_dump($_GET);

//Dispatcheur
if (isset($_GET["v"])) {
    switch ($_GET["v"]) {
        case "home":
            showHome();
            break;

        case "presentation":
            showPresentation();
            break;

        case "bureau":
            showBureau();
            break;

        case "documents":
            showDocuments();
            break;

        case "projet":
            showProjet();
            break;

        case "contact":
            showContact();
            break;
            
		case "charte":
			showCharte();
			break;
            
        case "staff":
            showStaff();
            break;
            
        case "404":
            show404();
            break;

        case "admin":
            if ($admin || $artiste) {
                switch ($_GET["a"]) {
                    case "article":
                        showAdminArticle();
                        break;

                    case "newArticle":
                        showAdminNewArticle();
                        break;

                    case "modArticle":
                        showAdminModArticle();
                        break;

                    case "supArticle":
                        showAdminSupArticle();
                        break;

                    case "categorie":
                        showAdminCategorie();
                        break;

                    case "modCat":
                        showAdminModCat();
                        break;

                    case "supCat":
                        showAdminSupCat();
                        break;

                    case "newCat":
                        showAdminNewCat();
                        break;

                    case "groupe":
                        if ($admin) {
                            showAdminGroupe();
                        } else {
                            show404();
                        }
                        break;

                    case "membre":
                        if ($admin) {
                            showAdminMembre();
                        } else {
                            show404();
                        }
                        break;

                    case "supGroupe":
                        if ($admin) {
                            showAdminSupGroupe();
                        } else {
                            show404();
                        }
                        break;

                    case "supMembre":
                        if ($admin) {
                            showAdminSupMembre();
                        } else {
                            show404();
                        }
                        break;

                    case "modMembre":
                        if ($admin) {
                            showAdminModMembre();
                        } else {
                            show404();
                        }
                        break;

                    case "newMembre":
                        if ($admin) {
                            showAdminNewMembre();
                        } else {
                            show404();
                        }
                        break;

                    default :
                        show404();
                        break;
                }
            } else {
                show404();
                break;
            }
            break;

        case "membre":
            switch ($_GET["a"]) {
                case "inscription":
                    showInscriptionMembre();
                    break;

                case "validation":
                    showValidationMembre();
                    break;

                case "deconnexion":
                    if (isset($_SESSION["idMembre"])) {
                        showDeconnexionMembre();
                    } else {
                        show404();
                    }
                    break;

                case "profil":
                    showProfilMembre();
                    break;

                case "modMembre":
                    if (isset($_SESSION["idMembre"])) {
                        showModMembre();
                    } else {
                        show404();
                    }
                    break;

                case "password":
                    showPassword();
                    break;

                default :
                    show404();
                    break;
            }
            break;

        case "article":
            switch ($_GET["a"]) {
                case "detail":
                    showDetailArticle();
                    break;

                case "liste":
                    showListeArticle();
                    break;

                case "search":
                    showSearchArticle();
                    break;

                case "proposer":
                    showProposerArticle();
                    break;

                default :
                    show404();
                    break;
            }
            break;

        default :
            show404();
            break;
    }
} else {
    showHome();
}

?>