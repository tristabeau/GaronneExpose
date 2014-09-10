<?php
function showAdminCategorie()
{
    $mysql = openConnexion();

    $pageTitle = " - Gestion des catégories";

    $menu = getMenu();
    $top = getTop(); 

    $categories = Categorie::loadAll($mysql);
    $table = "<table class='footable'>";
    $table .= "<thead>";
    $table .= "<tr>";
    $table .= "<th data-sort-initial='true'>Nom</th>";
    $table .= "<th data-sort-ignore='true'>Actions</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($categories as $categorie) {
        $table .= "<tr>";
        $table .= "<td>".utf8_encode($categorie->getNom())."</td>";
        $table .= "<td>";
        $table .= "<button class='btn btn-primary btn-xs' onclick='modCat(\"".$categorie->getIdCategorie()."\")'>Modifier</button>";
        $table .= " ";
        if ($categorie->getIdCategorie() > 3 ) {
            $table .= "<button class='btn btn-primary btn-xs' onclick='supCat(\"".$categorie->getIdCategorie()."\")'>Supprimer</button>";
        }
        $table .= "</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "<tfoot class='hide-if-no-paging'>";
    $table .= "<tr>";
    $table .= "<td colspan='3'>";
    $table .= "<div class='pagination pagination-centered'></div>";
    $table .= "</td>";
    $table .= "</tr>";
    $table .= "</tfoot>";
    $table .= "</table>";

    ob_start();
    include 'view/categories_liste.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminModCat()
{
    $mysql = openConnexion();

    $pageTitle = " - Modification de la catégorie";

    if (isset($_POST["nom"])) {
        $categorie = Categorie::load($mysql, $_POST["idCategorie"]);
        $categorie->setNom($_POST["nom"],false);
        $categorie->setTag(strtoupper(substr($_POST["nom"],0,5)),false);
        $categorie->setPereById("",false);
        $categorie->update();

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/index.php?v=admin&a=categories");
    } else {
        $menu = getMenu();
        $top = getTop(); 

        $categorie = Categorie::load($mysql, $_POST['idCategorie']);
        $nom = utf8_encode($categorie->getNom());
        $idCategorie = $_POST['idCategorie'];
        $action = "Modifier";

        $categories = Categorie::loadAll($mysql);
        $parent = "<option value=''>Aucune</option>";
        foreach ($categories as $cat) {
            $selected = (($cat->getIdCategorie() == $categorie->getPereId()) ? "selected" : "");
            $parent .= "<option value='".$cat->getIdCategorie()."' ".$selected.">".utf8_encode($cat->getNom())."</option>";
        }

        ob_start();
        include 'view/categorie_form.php';
        $content = ob_get_clean();

        include 'layout.php';
    }
}

function showAdminNewCat()
{
    $mysql = openConnexion();

    $pageTitle = " - Création d'une catégorie";
    
    if (isset($_POST["nom"])) {
        Categorie::create($mysql, $_POST["nom"], strtoupper(substr($_POST["nom"],0,5)), "");

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/index.php?v=admin&a=categories");
    } else {
        $menu = getMenu();
        $top = getTop(); 

        $categorie = "";
        $nom = "";
        $idCategorie = "";
        $tag = "";
        $action = "Créer";

        $categories = Categorie::getCategoriePere($mysql);
        $parent = "<option value=''>Aucune</option>";
        foreach ($categories as $cat) {
            $parent .= "<option value='".$cat->getIdCategorie()."'>".utf8_encode($cat->getNom())."</option>";
        }

        ob_start();
        include 'view/categorie_form.php';
        $content = ob_get_clean();

        include 'layout.php';
    }
}

function showAdminSupCat()
{
    $mysql = openConnexion();
    $categorie = Categorie::load($mysql, $_POST["idCategorie"]);
    $categorie->delete();

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php?v=admin&a=categories");
}

function showAdminGroupe()
{
    $pageTitle = " - Gestion des groupes";

    $mysql = openConnexion();

    if (isset($_POST['nom'])) {
        if (isset($_POST['idGroupe']) && $_POST['idGroupe'] != "") {
            $groupe = Groupe::load($mysql, $_POST['idGroupe']);
            $groupe->setNom($_POST['nom']);
        } else {
            Groupe::create($mysql, $_POST['nom']);
        }
    }

    $menu = getMenu();
    $top = getTop(); 

    $nom = "";
    $groupes = Groupe::loadAll($mysql);
    $table = "<table class='footable'>";
    $table .= "<thead>";
    $table .= "<tr>";
    $table .= "<th data-sort-initial='true'>Nom</th>";
    $table .= "<th data-sort-ignore='true'>Actions</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($groupes as $groupe) {
        $table .= "<tr>";
        $table .= "<td>".utf8_encode($groupe->getNom())."</td>";
        $table .= "<td>";
        $table .= "<button class='btn btn-primary btn-xs' onclick='modGroupe(\"".$groupe->getIdGroupe()."\", \"".utf8_encode($groupe->getNom())."\")'>Modifier</button>";
        $table .= " ";
        if ($groupe->getIdGroupe() > 4 ) {
            $table .= "<button class='btn btn-primary btn-xs' onclick='supGroupe(\"".$groupe->getIdGroupe()."\")'>Supprimer</button>";
        }
        $table .= "</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "<tfoot class='hide-if-no-paging'>";
    $table .= "<tr>";
    $table .= "<td colspan='2'>";
    $table .= "<div class='pagination pagination-centered'></div>";
    $table .= "</td>";
    $table .= "</tr>";
    $table .= "</tfoot>";
    $table .= "</table>";
    
    ob_start();
    include 'view/groupes_liste.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminSupGroupe()
{
    $mysql = openConnexion();
    $groupe = Groupe::load($mysql, $_POST["idGroupe"]);
    $groupe->delete();

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php?v=admin&a=groupes");
}

function showAdminMembre()
{
    $pageTitle = " - Gestion des artistes";

    $mysql = openConnexion();
    
    $menu = getMenu();
    $top = getTop(); 

    $membres = Membre::loadAll($mysql);
    $table = "<table class='footable' data-filter='#filter' data-page-size='30'>";
    $table .= "<thead>";
    $table .= "<tr>";
    $table .= "<th data-sort-initial='true'>Pseudo</th>";
    $table .= "<th data-hide='phone'>Mail</th>";
    $table .= "<th data-hide='phone'>Groupe</th>";
    $table .= "<th data-sort-ignore='true'>Actions</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($membres as $membre) {
        $groupe = $membre->getGroupe();
        $table .= "<tr>";
        $table .= "<td>".utf8_encode($membre->getPseudo())."</td>";
        $table .= "<td>".$membre->getMail()."</td>";
        $table .= "<td><a href='#' class='editGroupe editable-click' data-value=".$groupe->getIdGroupe()." data-pk='".$membre->getIdMembre()."' >".utf8_encode($groupe->getNom())."</a></td>";
        $table .= "<td>";
        $table .= "<button class='btn btn-primary btn-xs' onclick='modMembre(\"".$membre->getIdmembre()."\")'>Modifier</button>";
        $table .= " ";
        $table .= "<button class='btn btn-primary btn-xs' onclick='supMembre(\"".$membre->getIdmembre()."\")'>Supprimer</button>";
        $table .= "</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "<tfoot class='hide-if-no-paging'>";
    $table .= "<tr>";
    $table .= "<td colspan='4'>";
    $table .= "<div class='pagination pagination-centered'></div>";
    $table .= "</td>";
    $table .= "</tr>";
    $table .= "</tfoot>";
    $table .= "</table>";
    
    ob_start();
    include 'view/membre_liste.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminSupMembre()
{
    $mysql = openConnexion();
    $membre = Membre::load($mysql, $_POST["idMembre"]);
    $membre->delete();

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php?v=admin&a=artistes");
}

function showAdminModMembre()
{
    $mysql = openConnexion();

    $pageTitle = " - Modification d'un artiste";
    
    global $admin, $auteur;
    
    $erreur = "";

    if (isset($_POST["idMembre"]) && isset($_POST["mail"]) && isset($_POST["mdp"]) && isset($_POST["mdp2"]) && isset($_POST["desc"]) && isset($_POST["facebook"]) && isset($_POST["twitter"]) && isset($_POST["google"]) && isset($_POST["site"])) {
        if ($_POST["mdp"] == $_POST["mdp2"])  {
            $membre = Membre::load($mysql, $_POST["idMembre"]);
            $membre->setMail($_POST["mail"],false);
            if ($_POST["mdp"] != "") {
                $membre->setMdp(md5(md5($membre->getSalt()).md5($_POST["mdp"])),false);
            }
            $membre->setImage($_POST['avatar'],false);
            $membre->setDescr($_POST["desc"],false);
            $membre->setFacebook($_POST["facebook"],false);
            $membre->setTwitter($_POST["twitter"],false);
            $membre->setGoogle($_POST["google"],false);
            $membre->setSite($_POST["site"],false);
            $membre->update();

            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header ("Location:http://$host$uri/index.php?v=admin&a=artistes");
        } else {
            $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Les deux mots de passe ne correspondent pas!</div>";
        }
    }

    $menu = getMenu();
    $top = getTop(); 

    $membre = membre::load($mysql, $_POST["idMembre"]);
    $idMembre = $membre->getIdMembre();
    $pseudo = $membre->getPseudo();
    $optionPseudo = "disabled";
    $mail = $membre->getMail();
    $desc = $membre->getDescr();
    $facebook = $membre->getFacebook();
    $urlRetour = "index.php?v=admin&a=artistes";
    $twitter = $membre->getTwitter();
    $google = $membre->getGoogle();
    $mdpReq = "";
    $site = $membre->getSite();
    $action = "Modifier";

    ob_start();
    include 'view/membre_form.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminNewMembre()
{
    $mysql = openConnexion();

    $pageTitle = " - Création d'un artiste";
    
    $erreur = "";

    if (isset($_POST["pseudo"]) && isset($_POST["mail"]) && isset($_POST["mdp"]) && isset($_POST["mdp2"]) && isset($_POST["desc"]) && isset($_POST["facebook"]) && isset($_POST["twitter"]) && isset($_POST["google"]) && isset($_POST["site"])) {
        if ($_POST["mdp"] == $_POST["mdp2"])  {
            $salt = random(5);
            $mdp = md5(md5($salt).md5($_POST["mdp"]));
            $groupe = Groupe::load($mysql, 4);
            Membre::create($mysql,$_POST["pseudo"],$mdp,0,$_POST["desc"],$_POST["facebook"],$_POST["twitter"],$_POST["google"],$_POST["site"],"",$salt,$_POST["mail"],"","",$groupe,1);

            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header ("Location:http://$host$uri/index.php?v=admin&a=artistes");
        } else {
            $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Les deux mots de passe ne correspondent pas!</div>";
        }
    }

    $menu = getMenu();
    $top = getTop(); 

    $idMembre = "";
    $pseudo = "";
    $optionPseudo = "";
    $mail = "";
    $desc = "";
    $facebook = "";
    $twitter = "";
    $google = "";
    $urlRetour = "index.php?v=admin&a=artistes";
    $mdpReq = "required";
    $site = "";
    $action = "Créer";

    ob_start();
    include 'view/membre_form.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminArticle()
{
    $mysql = openConnexion();

    $pageTitle = " - Gestion des contenus";

    $menu = getMenu();
    $top = getTop();

    $articles = Article::loadAll($mysql);
    $table = "<table class='footable' data-filter='#filter' data-page-size='20'>";
    $table .= "<thead>";
    $table .= "<tr>";
    $table .= "<th data-type='numeric'>Date</th>";
    $table .= "<th>Titre</th>";
    $table .= "<th>Catégorie</th>";
    $table .= "<th data-hide='phone'>Auteur</th>";
    $table .= "<th data-hide='phone'>Publié</th>";
    $table .= "<th data-sort-ignore='true'>Actions</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($articles as $article) {
        $categorie = $article->getCategorie();
        $membre = $article->getMembre();
        $table .= "<tr>";
        $table .= "<td data-value='".$article->getDate()."' >".date("d/m/Y H:i", $article->getDate())."</td>";
        $table .= "<td>".$article->getTitre()."</td>";
        $table .= "<td>".utf8_encode($categorie->getNom())."</td>";
        $table .= "<td>".utf8_encode($membre->getPseudo())."</td>";
        $table .= "<td>".(($article->getPublie()) ? "<span class='label label-success'>Oui</span>" : "<span class='label label-danger'>Non</span>")."</td>";
        $table .= "<td>";
        $table .= "<button class='btn btn-primary btn-xs' onclick='modArticle(\"".$article->getIdArticle()."\")'>Modifier</button>";
        $table .= " ";
        $table .= "<button class='btn btn-primary btn-xs' onclick='supArticle(\"".$article->getIdArticle()."\")'>Supprimer</button>";
        $table .= "</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "<tfoot class='hide-if-no-paging'>";
    $table .= "<tr>";
    $table .= "<td colspan='9'>";
    $table .= "<div class='pagination pagination-centered'></div>";
    $table .= "</td>";
    $table .= "</tr>";
    $table .= "</tfoot>";
    $table .= "</table>";

    ob_start();
    include 'view/articles_liste.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminNewArticle()
{
    $mysql = openConnexion();

    $pageTitle = " - Nouveau contenu";

    $erreur = "";

    if (isset($_POST["titre"])) {

        $ok = false;
        $name = "";

        if (isset($_FILES["image"]) && $_FILES["image"]['tmp_name'] != "") {
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
            $image_sizes = getimagesize($_FILES['image']['tmp_name']);

            if ($image_sizes[0] < 700 || $image_sizes[1] < 400) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'image est trop petite! 700x400 minimum!</div>";
            } else if ( ! in_array($extension_upload,$extensions_valides) ) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'extension de votre image n'est pas bonne!</div>";
            } else {
                $taille_maxi = 2000000;
                $taille = filesize($_FILES['image']['tmp_name']);
                if ($taille > $taille_maxi) {
                    $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> La taille de votre fichier est supérieur à 2Mo!</div>";
                } else {
                    $name = to_permalink($_POST["titre"])."-".random(10).strrchr($_FILES['image']['name'], '.');
                    $nom = "img/articles/$name";
                    $resultat = move_uploaded_file($_FILES['image']['tmp_name'],$nom);
                    if ($resultat) {
                        $ok = true;
                    } else {
                        $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Erreur lors de l'envoie du fichier!</div>";
                    }
                }
            }
        } else {
            $ok = true;
        }

        if (isset($_FILES["image"]) && ($_FILES["image"]['tmp_name'] != "") && $ok) {
            $image = $name;
        } else {
            $image = "";
        }

        if ($ok) {
            $membre = Membre::load($mysql, $_POST["auteur"]);
            $categorie = Categorie::load($mysql, $_POST["categorie"]);
            $annee = intval(substr($_POST["date_submit"],6,4));
            $mois = intval(substr($_POST["date_submit"],3,2));
            $jour = intval(substr($_POST["date_submit"],0,2));
            $heure = intval(substr($_POST["heure_submit"],0,2));
            $minute = intval(substr($_POST["heure_submit"],3,2));
            $date = strtotime(date("Y-m-d H:i", mktime($heure, $minute, 0, $mois, $jour, $annee)));
            $permalien = to_permalink($_POST["titre"]);

            global $membreCo;

            $article = Article::create($mysql, $_POST["titre"], $date, str_pad($annee,4,'0',STR_PAD_LEFT), str_pad($mois,2,'0',STR_PAD_LEFT), str_pad($jour,2,'0',STR_PAD_LEFT), date("H:i",$date), $_POST["contenu"], $image, 0, $permalien, "", $membreCo->getPseudo(), $membre, $categorie, "", $_POST["publie"], "");

            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php?v=admin&a=contenus");
        }
    } else {
        $menu = getMenu();
        $top = getTop();

        $titre = (isset($_POST["titre"]) ? $_POST["titre"] : "");
        $idArticle = "";
        $date = (isset($_POST["date"]) ? $_POST["date"] : "");
        $heure = (isset($_POST["heure"]) ? $_POST["heure"] : "");
        $publie = (isset($_POST["vedette"]) ? $_POST["vedette"] : "0");

        if ($publie) {
            $butPubNon = "";
            $butPubOui = "btn-success";
        } else {
            $butPubNon = "btn-danger";
            $butPubOui = "";
        }

        $contenu = "Contenu de votre article";
        $action = "Créer";

        $admins = Groupe::load($mysql, 1);
        $bureau = Groupe::load($mysql, 3);
        $auteurs = Groupe::load($mysql, 4);
        $membres = array_merge(Membre::selectByGroupe($mysql, $admins), Membre::selectByGroupe($mysql, $auteurs), Membre::selectByGroupe($mysql, $bureau));
        $auteur = "";

        foreach ($membres as $membre) {
            $selected = (($membre->getIdMembre() == $_SESSION["idArtiste"]) ? "selected" : "");
            $auteur .= "<option value='".$membre->getIdMembre()."' ".$selected.">".utf8_encode($membre->getPseudo())."</option>";
        }

        $categories = Categorie::loadAll($mysql);
        $categorie = "<option value=''>Aucune</option>";
        foreach ($categories as $cat) {
            $selected = ((isset($_POST["categorie"]) && ($cat->getIdCategorie() == $_POST["categorie"])) ? "selected" : "");
            $categorie .= "<option value='".$cat->getIdCategorie()."' ".$selected.">".utf8_encode($cat->getNom())."</option>";
        }

        $img = "";

        ob_start();
        include 'view/article_form.php';
        $content = ob_get_clean();

        include 'layout.php';
    }
}

function showAdminModArticle()
{
    $mysql = openConnexion();
    $erreur = "";
    $article = Article::load($mysql, $_POST["idArticle"]);
    $name = "";

    $pageTitle = " - Modification d'un contenu";

    if (isset($_POST["titre"])) {
        $ok = false;

        if (isset($_FILES["image"]) && $_FILES["image"]['tmp_name'] != "") {
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
            $image_sizes = getimagesize($_FILES['image']['tmp_name']);

            if ($image_sizes[0] < 700 || $image_sizes[1] < 400) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'image est trop petite! 700x400 minimum!</div>";
            } else if ( ! in_array($extension_upload,$extensions_valides) ) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'extension de votre image n'est pas bonne!</div>";
            } else {
                $taille_maxi = 2000000;
                $taille = filesize($_FILES['image']['tmp_name']);
                if ($taille > $taille_maxi) {
                    $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> La taille de votre fichier est supérieur à 2Mo!</div>";
                } else {
                    $name = to_permalink($_POST["titre"])."-".random(10).strrchr($_FILES['image']['name'], '.');
                    $nom = "img/articles/$name";
                    $resultat = move_uploaded_file($_FILES['image']['tmp_name'],$nom);
                    if ($resultat) {
                        $ok = true;
                    } else {
                        $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Erreur lors de l'envoie du fichier!</div>";
                    }
                }
            }
        } else {
            $ok = true;
        }

        $membre = Membre::load($mysql, $_POST["auteur"]);
        $categorie = Categorie::load($mysql, $_POST["categorie"]);
        $annee = intval(substr($_POST["date_submit"],6,4));
        $mois = intval(substr($_POST["date_submit"],3,2));
        $jour = intval(substr($_POST["date_submit"],0,2));
        $heure = intval(substr($_POST["heure_submit"],0,2));
        $minute = intval(substr($_POST["heure_submit"],3,2));
        $date = strtotime(date("Y-m-d H:i", mktime($heure, $minute, 0, $mois, $jour, $annee)));
        $permalien = to_permalink($_POST["titre"]);

        if (isset($_FILES["image"]) && ($_FILES["image"]['tmp_name'] != "") && $ok) {
            unlink($article->getImage());
            $article->setImage($name, false);
        }

        $article->setTitre($_POST["titre"], false);
        $article->setDate($date, false);
        $article->setAnnee(str_pad($annee,4,'0',STR_PAD_LEFT), false);
        $article->setMois(str_pad($mois,2,'0',STR_PAD_LEFT), false);
        $article->setJour(str_pad($jour,2,'0',STR_PAD_LEFT), false);
        $article->setHeure(date("H:i", $date), false);
        $article->setMembre($membre, false);
        $article->setCategorie($categorie, false);
        $article->setContenu($_POST["contenu"], false);
        $article->setPublie($_POST["publie"], false);
        $article->setPermalien($permalien, false);
        $article->update();

        if ($ok) {
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php?v=admin&a=contenus");
        }
    }

    $menu = getMenu();
    $top = getTop();

    $titre = $article->getTitre();
    $idArticle = $article->getIdArticle();
    $date = date("d/m/Y", $article->getDate());
    $heure = date("H:i", $article->getDate());
    $contenu = $article->getContenu();
    $publie = $article->getPublie();

    if ($publie) {
        $butPubNon = "";
        $butPubOui = "btn-success";
    } else {
        $butPubNon = "btn-danger";
        $butPubOui = "";
    }

    $img = "<tr>";
    $img .= "<td colspan='2'>";
    $img .= "<img src='img/articles/".$article->getImage()."' style='width:100%;' border='0' alt='Null' />";
    $img .= "</td>";
    $img .= "</tr>";

    $action = "Modifier";

    $categories = Categorie::loadAll($mysql);
    $categorie = "<option value=''>Aucune</option>";
    foreach ($categories as $cat) {
        $selected = (($cat->getIdCategorie() == $article->getCategorieId()) ? "selected" : "");
        $categorie .= "<option value='".$cat->getIdCategorie()."' ".$selected.">".utf8_encode($cat->getNom())."</option>";
    }

    $admins = Groupe::load($mysql, 1);
    $bureau = Groupe::load($mysql, 3);
    $auteurs = Groupe::load($mysql, 4);
    $membres = array_merge(Membre::selectByGroupe($mysql, $admins), Membre::selectByGroupe($mysql, $auteurs), Membre::selectByGroupe($mysql, $bureau));
    $auteur = "";

    foreach ($membres as $membre) {
        $selected = (($membre->getIdMembre() == $article->getMembreId()) ? "selected" : "");
        $auteur .= "<option value='".$membre->getIdMembre()."' ".$selected.">".utf8_encode($membre->getPseudo())."</option>";
    }

    ob_start();
    include 'view/article_form.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminSupArticle()
{
    $mysql = openConnexion();
    $article = Article::load($mysql, $_POST["idArticle"]);
    unlink($article->getImage());
    $article->delete();

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php?v=admin&a=contenus");
}

function showAdminPartenaire()
{
    $mysql = openConnexion();

    $pageTitle = " - Gestion des partenaires";

    $menu = getMenu();
    $top = getTop();

    $partenaires = Partenaire::loadAll($mysql);

    $table = "<table class='footable' data-filter='#filter' data-page-size='30'>";
    $table .= "<thead>";
    $table .= "<tr>";
    $table .= "<th data-sort-initial='true'>Nom</th>";
    $table .= "<th data-sort-ignore='true'>Logo</th>";
    $table .= "<th data-hide='phone'>Site</th>";
    $table .= "<th data-sort-ignore='true'>Actions</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($partenaires as $partenaire) {
        $table .= "<tr>";
        $table .= "<td>".utf8_encode($partenaire->getNom())."</td>";
        $table .= "<td class='logoPartenaire'><img alt='".$partenaire->getNom()."' src='".$partenaire->getImage()."' /></td>";
        $table .= "<td>".$partenaire->getSite()."</td>";
        $table .= "<td>";
        $table .= "<button class='btn btn-primary btn-xs' onclick='modPartenaire(\"".$partenaire->getIdPartenaire()."\")'>Modifier</button>";
        $table .= " ";
        $table .= "<button class='btn btn-primary btn-xs' onclick='supPartenaire(\"".$partenaire->getIdPartenaire()."\")'>Supprimer</button>";
        $table .= "</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "<tfoot class='hide-if-no-paging'>";
    $table .= "<tr>";
    $table .= "<td colspan='4'>";
    $table .= "<div class='pagination pagination-centered'></div>";
    $table .= "</td>";
    $table .= "</tr>";
    $table .= "</tfoot>";
    $table .= "</table>";

    ob_start();
    include 'view/partenaires_liste.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminNewPartenaire()
{
    $mysql = openConnexion();

    $pageTitle = " - Nouveau partenaire";

    $erreur = $nom = "";
    $ok = false;

    if (isset($_POST["nom"]) && isset($_POST["site"]) && isset($_FILES["image"])) {
        if ($_FILES["image"]['tmp_name'] != "") {
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
            $image_sizes = getimagesize($_FILES['image']['tmp_name']);

            if ($image_sizes[0] < 200 || $image_sizes[1] < 200) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'image est trop petite! 200x200 minimum!</div>";
            } else if ( ! in_array($extension_upload,$extensions_valides) ) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'extension de votre image n'est pas bonne!</div>";
            } else {
                $taille_maxi = 512000;
                $taille = filesize($_FILES['image']['tmp_name']);
                if ($taille > $taille_maxi) {
                    $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> La taille de votre fichier est supérieur à 512 Ko!</div>";
                } else {
                    $name = to_permalink($_POST["titre"])."-".random(10).strrchr($_FILES['image']['name'], '.');
                    $nom = "img/partenaires/$name";
                    $resultat = move_uploaded_file($_FILES['image']['tmp_name'],$nom);
                    if ($resultat) {
                        $ok = true;
                    } else {
                        $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Erreur lors de l'envoie du fichier!</div>";
                    }
                }
            }
        } else {
            $ok = true;
        }

        if ($ok) {
            Partenaire::create($mysql,$_POST["nom"],$nom,$_POST["site"]);
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header ("Location:http://$host$uri/index.php?v=admin&a=partenaires");
        }
    }

    $menu = getMenu();
    $top = getTop();

    $idPartenaire = "";
    $nom = "";
    $site = "";
    $image = "Logo du partenaire...";
    $img = "";
    $urlRetour = "index.php?v=admin&a=partenaires";
    $action = "Créer";

    ob_start();
    include 'view/partenaire_form.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminModPartenaire()
{
    $mysql = openConnexion();

    $pageTitle = " - Modification d'un partenaire";

    $partenaire = Partenaire::load($mysql, $_POST["idPartenaire"]);
    $erreur = $nom = "";
    $ok = false;

    if (isset($_POST["nom"]) && isset($_POST["site"]) && isset($_FILES["image"])) {
        if ($_FILES["image"]['tmp_name'] != "") {
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
            $image_sizes = getimagesize($_FILES['image']['tmp_name']);

            if ($image_sizes[0] < 200 || $image_sizes[1] < 200) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'image est trop petite! 200x200 minimum!</div>";
            } else if ( ! in_array($extension_upload,$extensions_valides) ) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'extension de votre image n'est pas bonne!</div>";
            } else {
                $taille_maxi = 512000;
                $taille = filesize($_FILES['image']['tmp_name']);
                if ($taille > $taille_maxi) {
                    $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> La taille de votre fichier est supérieur à 512 Ko!</div>";
                } else {
                    $name = to_permalink($_POST["titre"])."-".random(10).strrchr($_FILES['image']['name'], '.');
                    $nom = "img/partenaires/$name";
                    $resultat = move_uploaded_file($_FILES['image']['tmp_name'],$nom);
                    if ($resultat) {
                        $ok = true;
                    } else {
                        $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Erreur lors de l'envoie du fichier!</div>";
                    }
                }
            }
        } else {
            $ok = true;
        }

        if ($ok) {
            $partenaire->setNom($_POST["nom"], false);
            unlink($partenaire->getImage());
            $partenaire->setImage($nom, false);
            $partenaire->setSite($_POST["site"], false);
            $partenaire->update();
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header ("Location:http://$host$uri/index.php?v=admin&a=partenaires");
        }
    }

    $menu = getMenu();
    $top = getTop();

    $idPartenaire = $partenaire->getIdPartenaire();
    $nom = $partenaire->getNom();
    $site = $partenaire->getSite();
    $image = "Logo du partenaire...";
    $img = "<img src='".$partenaire->getImage()."' />";
    $urlRetour = "index.php?v=admin&a=partenaires";
    $action = "Modifier";

    ob_start();
    include 'view/partenaire_form.php';
    $content = ob_get_clean();

    include 'layout.php';
}

function showAdminSupPartenaire()
{
    $mysql = openConnexion();
    $partenaire = Partenaire::load($mysql, $_POST["idPartenaire"]);
    unlink($partenaire->getImage());
    $partenaire->delete();

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php?v=admin&a=partenaires");
}

function showAdminPresse()
{
    $pageTitle = " - Gestion des revues de presse";

    $mysql = openConnexion();

    $ok = false;
    $image = "";
    $nom = "";
    $erreur = "";

    if (isset($_FILES["image"])) {
        if ($_FILES["image"]['tmp_name'] != "") {
            $extensions_valides = array( 'jpg' , 'jpeg' , 'png', 'pdf' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
            $image_sizes = getimagesize($_FILES['image']['tmp_name']);

            if (($image_sizes[0] < 700 || $image_sizes[1] < 400) && ($extension_upload != 'pdf')) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'image est trop petite! 700x400 minimum!</div>";
            } else if ( ! in_array($extension_upload,$extensions_valides) ) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> L'extension de votre image n'est pas bonne!</div>";
            } else {
                $taille_maxi = 1000000;
                $taille = filesize($_FILES['image']['tmp_name']);
                if ($taille > $taille_maxi) {
                    $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> La taille de votre fichier est supérieur à 1Mo!</div>";
                } else {
                    $name = random(10).strrchr($_FILES['image']['name'], '.');
                    $nom = $_FILES['image']['name'];
                    $image = "img/presses/$name";
                    $resultat = move_uploaded_file($_FILES['image']['tmp_name'],$image);
                    if ($resultat) {
                        $ok = true;
                    } else {
                        $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Erreur lors de l'envoie du fichier!</div>";
                    }
                }
            }
        } else {
            $ok = true;
        }

        if ($ok) {
            $presse = Presse::create($mysql, $nom, $image);

            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php?v=admin&a=presses");
        }
    }

    $menu = getMenu();
    $top = getTop();
    $image = "Fichier...";

    $presses = Presse::loadAll($mysql);
    $table = "<table class='footable'>";
    $table .= "<thead>";
    $table .= "<tr>";
    $table .= "<th data-sort-initial='true'>Nom</th>";
    $table .= "<th data-sort-ignore='true'>Actions</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($presses as $presse) {
        $table .= "<tr>";
        $table .= "<td><a class='imageListeRevue' href='".$presse->getImage()."'>".utf8_encode($presse->getNom())."</a></td>";
        $table .= "<td>";
        $table .= "<button class='btn btn-primary btn-xs' onclick='supPresse(\"".$presse->getIdPresse()."\")'>Supprimer</button>";
        $table .= "</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "<tfoot class='hide-if-no-paging'>";
    $table .= "<tr>";
    $table .= "<td colspan='2'>";
    $table .= "<div class='pagination pagination-centered'></div>";
    $table .= "</td>";
    $table .= "</tr>";
    $table .= "</tfoot>";
    $table .= "</table>";

    ob_start();
    include 'view/presses_liste.php';
    $content = ob_get_clean();

    include 'layout.php';

}

function showAdminSupPresse()
{
    $mysql = openConnexion();
    $presse = Presse::load($mysql, $_POST["idPresse"]);
    unlink($presse->getImage());
    $presse->delete();

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php?v=admin&a=presses");
}


?>