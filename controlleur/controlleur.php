<?php

function getMenu()
{
    $mysql = openConnexion();
    global $admin, $artiste;

    $liste_categorie = "<li><a href='article/liste/all/'>Tous les articles</a></li>";
    $categories = Categorie::getCategoriePere($mysql);

    foreach ($categories as $categorie) {
        $liste_categorie .= "<li><a href='article/liste/".$categorie->getTag()."/'>".utf8_encode($categorie->getNom())."</a></li>";
    }

    ob_start();
    include 'view/menu.php';
    $res = ob_get_clean();
    return $res;
}

function getTop()
{
    $mysql = openConnexion();

    if (isset($_SESSION["idMembre"])) {
        global $membreCo;
        $id = $_SESSION["idMembre"];
        $pseudo = $membreCo->getPseudo();
        $avatar = md5(strtolower(trim($membreCo->getImage())));
        $url = "membre/deconnexion";
        ob_start();
        include 'view/widget_loged.php';
        $widget_loged = ob_get_clean();
    } else {
        ob_start();
        include 'view/widget_login.php';
        $widget_login = ob_get_clean();
    }

    ob_start();
    include 'view/article_proposer_form.php';
    $content = ob_get_clean();

    ob_start();
    include 'view/widget_search.php';
    $widget_search = ob_get_clean();

    ob_start();
    include 'view/top.php';
    $res = ob_get_clean();

    return $res;
}

function showHome()
{
    $mysql = openConnexion();

    $pageTitle = "";

    $menu = getMenu();
    
    $top = getTop();

    $articles = Article::getLastArticles($mysql);
    $content = "";

    foreach ($articles as $article) {
        $membre = $article->getMembre();
        $cat = $article->getCategorie();
        $titre = $article->getTitre();
        $id = $article->getIdArticle();
        $image = $article->getImage();
        $nbVue = $article->getNb_vues();
        $annee = $article->getAnnee();
        $mois = $article->getMois();
        $jour = $article->getJour();
        $permalien = $article->getPermalien();
        $pseudo = $membre->getPseudo();
        $avatar = md5(strtolower(trim($membre->getImage())));
        $categorie = utf8_encode($cat->getNom());
        $tag = $cat->getTag();
        $membreId = $membre->getIdMembre();
        $date = returnFrenchDate(date("Y-m-d H:i",$article->getDate()));
        $contenu = texte_resume_brut($article->getContenu(), 600);

        ob_start();
        include 'view/articles_liste_home.php';
        $content .= ob_get_clean();
    }

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    $content .= "<div id='boutonTous'><a class='btn btn-primary btn-sm' href='contenus/liste/1/all'>Anciennes publications</a></div>";

    include 'layout.php';
}

function showContact()
{
    $mysql = openConnexion();

    $pageTitle = " - Contact";

    if (isset($_POST["name"])) {
        $mail = new Email();
        $mail->setFrom("LanceA News");
        $mail->addTo("admin@lancea-online.com");
        $mail->setSubject("Contact : LanceA News");
        $message = "Nom : ".$_POST["name"]."<br /><br />";
        $message .= "Mail : ".$_POST["email"]."<br /><br />";
        $message .= $_POST["comment"];
        $mail->setMessage($message);
        $mail->sendMail();
    }

    $menu = getMenu();
    $top = getTop();

    ob_start();
    include 'view/contact.php';
    $contact = ob_get_clean();

    include 'layout.php';
}

function show404()
{
    $mysql = openConnexion();

    $menu = getMenu();
    $top = getTop();

    $pageTitle = " - Erreur";

    ob_start();
    include 'view/404.php';
    $error404 = ob_get_clean();

    

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();

    include 'layout.php';
}

function showPresentation ()
{
    $pageTitle = " - Présentation";

    $menu = getMenu();

    $top = getTop();

    ob_start();
    include 'view/presentation.php';
    $content = ob_get_clean();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}

function showBureau()
{
    $mysql = openConnexion();

    $pageTitle = " - Bureau";

    $menu = getMenu();

    $top = getTop();

    $content = "";

    $auteurs = Membre::selectBureau($mysql);

    foreach ($auteurs as $auteur) {
        $membreId = $auteur->getIdMembre();
        $description = texte_resume_brut($auteur->getDescr(), 250);
        $pseudo = $auteur->getPseudo();
        $avatar = md5(strtolower(trim($auteur->getImage())));

        ob_start();
        include 'view/membre.php';
        $content .= ob_get_clean();
    }

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}

function showDocuments()
{
    $mysql = openConnexion();

    $pageTitle = " - Documents";

    $menu = getMenu();

    $top = getTop();

    ob_start();
    include 'view/documents.php';
    $content = ob_get_clean();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}

function showProjet()
{
    $mysql = openConnexion();

    $pageTitle = " - Projet";

    $menu = getMenu();

    $top = getTop();

    ob_start();
    include 'view/projet.php';
    $content = ob_get_clean();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}

function showArtistes()
{
    $mysql = openConnexion();

    $pageTitle = " - Les Artistes";

    $menu = getMenu();

    $top = getTop();

    $content = "";

    $auteurs = Membre::selectArtistes($mysql);

    foreach ($auteurs as $auteur) {
        $membreId = $auteur->getIdMembre();
        $description = texte_resume_brut($auteur->getDescr(), 250);
        $pseudo = $auteur->getPseudo();
        $avatar = md5(strtolower(trim($auteur->getImage())));

        ob_start();
        include 'view/membre.php';
        $content .= ob_get_clean();
    }

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}

function getFiltres($a, $val = "")
{
    $mysql = openConnexion();

    $filtreAnnees = "<option value='all'>Toutes</option>";
    $filtreMois = "<option value='all'>Tous</option>";
    $filtreJours = "<option value='all'>Tous</option>";


    if ($a == "e") {
        $selectAnnee = "selectAnnee('3');";
        $selectMois = "selectMois('3');";
        $annees = Article::selectDistinctAnnee($mysql, 3);

        foreach ($annees as $annee) {
            $selected = (($annee["annee"] == $_GET["y"]) ? "selected" : "");
            $filtreAnnees .= "<option value='".$annee["annee"]."' ".$selected.">".$annee["annee"]."</option>";
        }

        if (isset($_GET["y"]) && ($_GET["y"] != "all")) {
            $mois = Article::selectDistinctMois($mysql, $_GET["y"], 3);

            foreach ($mois as $moi) {
                $selected = (($moi["mois"] == $_GET["m"]) ? "selected" : "");
                $filtreMois .= "<option value='".$moi["mois"]."' ".$selected.">".$moi["mois"]."</option>";
            }

            if (isset($_GET["m"]) && ($_GET["m"] != "all")) {
                $jours = Article::selectDistinctJours($mysql, $_GET["y"], $_GET["m"], 3);

                foreach ($jours as $jour) {
                    $selected = (($jour["jour"] == $_GET["j"]) ? "selected" : "");
                    $filtreJours .= "<option value='".$jour["jour"]."' ".$selected.">".$jour["jour"]."</option>";
                }
            }
        }

        $filtrer = "filtrerListeEvenement();";
    } else if ($a == "p"){
        $m = Membre::selectByPseudo($mysql, $val);
        $membre = $m[0];

        $selectAnnee = "selectAnneeProfil('".$membre->getIdMembre()."');";
        $selectMois = "selectMoisProfil('".$membre->getIdMembre()."');";

        $annees = Article::selectDistinctAnneeByProfil($mysql, $membre->getIdMembre());

        foreach ($annees as $annee) {
            $selected = (($annee["annee"] == $_GET["y"]) ? "selected" : "");
            $filtreAnnees .= "<option value='".$annee["annee"]."' ".$selected.">".$annee["annee"]."</option>";
        }

        if (isset($_GET["y"]) && ($_GET["y"] != "all")) {
            $mois = Article::selectDistinctMoisByProfil($mysql, $_GET["y"], $membre->getIdMembre());

            foreach ($mois as $moi) {
                $selected = (($moi["mois"] == $_GET["m"]) ? "selected" : "");
                $filtreMois .= "<option value='".$moi["mois"]."' ".$selected.">".$moi["mois"]."</option>";
            }

            if (isset($_GET["m"]) && ($_GET["m"] != "all")) {
                $jours = Article::selectDistinctJoursByProfil($mysql, $_GET["y"], $_GET["m"], $membre->getIdMembre());

                foreach ($jours as $jour) {
                    $selected = (($jour["jour"] == $_GET["j"]) ? "selected" : "");
                    $filtreJours .= "<option value='".$jour["jour"]."' ".$selected.">".$jour["jour"]."</option>";
                }
            }
        }

        $filtrer = "filtrerProfil('".$val."');";
    } else {
        $selectAnnee = "selectAnneeSearch('".$val."');";
        $selectMois = "selectMoisSearch('".$val."');";
        $annees = Article::selectDistinctAnneeBySearch($mysql, $val);

        foreach ($annees as $annee) {
            $selected = (($annee["annee"] == $_GET["y"]) ? "selected" : "");
            $filtreAnnees .= "<option value='".$annee["annee"]."' ".$selected.">".$annee["annee"]."</option>";
        }

        if (isset($_GET["y"]) && ($_GET["y"] != "all")) {
            $mois = Article::selectDistinctMoisBySearch($mysql, $_GET["y"], $val);

            foreach ($mois as $moi) {
                $selected = (($moi["mois"] == $_GET["m"]) ? "selected" : "");
                $filtreMois .= "<option value='".$moi["mois"]."' ".$selected.">".$moi["mois"]."</option>";
            }

            if (isset($_GET["m"]) && ($_GET["m"] != "all")) {
                $jours = Article::selectDistinctJoursBySearch($mysql, $_GET["y"], $_GET["m"], $val);

                foreach ($jours as $jour) {
                    $selected = (($jour["jour"] == $_GET["j"]) ? "selected" : "");
                    $filtreJours .= "<option value='".$jour["jour"]."' ".$selected.">".$jour["jour"]."</option>";
                }
            }
        }

        $filtrer = "filtrerSearch('".$val."');";
    }

    ob_start();
    include 'view/articles_liste_filtres.php';
    return ob_get_clean();
}

function showProfilArtiste()
{
    $mysql = openConnexion();

    $menu = getMenu();
    $top = getTop();

    $page = 1;

    $m = membre::selectByPseudo($mysql, $_GET["n"]);
    $membre = $m[0];
    $membreId = $membre->getIdMembre();

    if ($_GET["p"] == "") {
        $_GET["p"] = "1";
    }

    if ($_GET["y"] == "") {
        $_GET["y"] = "all";
    }

    if ($_GET["m"] == "") {
        $_GET["m"] = "all";
    }

    if ($_GET["j"] == "") {
        $_GET["j"] = "all";
    }

    $articles = array();
    $total = Article::countPeintureByAuteur($mysql, $membreId, $_GET["y"], $_GET["m"], $_GET["j"]);
    $articles = Article::getPeintureByAuteur($mysql, $membreId, $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 12, $total);
    $nb_page = ceil($total / 12);

    $filtres = getFiltres("p", $_GET["n"]);

    $articles_related = "";
    $nb_peinture = count($articles);

    if ($total > 0) {
        $i = 1;
        $articles_related .= "<div class='row'>";

        foreach ($articles as $article) {
            if ($i >= 5) {
                $articles_related .= "</div><br />";

                $articles_related .= "<div class='row'>";
                $i = 1;
            }

            $titre = $article->getTitre();
            $id = $article->getIdArticle();
            $annee = $article->getAnnee();
            $mois = $article->getMois();
            $jour = $article->getJour();
            $permalien = $article->getPermalien();
            $image = $article->getImage();
            $date = date("d/m/Y H:i",$article->getDate());

            ob_start();
            include 'view/articles_related.php';
            $articles_related .= ob_get_clean();

            $i++;
        }

        $articles_related .= "</div><br />";

        if ($nb_page > 1) {
            $articles_related .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "profil/".$_GET["n"]."/".($_GET["y"] != "all" ? $_GET["y"]."/" : "").($_GET["m"] != "all" ? $_GET["m"]."/" : "").($_GET["j"] != "all" ? $_GET["j"]."/" : "");
            $articles_related .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
            $articles_related .= "<li class='divider'></li>";
            for ($i = 1; $i <= $nb_page; $i++) {
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $articles_related .= "<li ".$active."><a href='".$url.$i."§'>".$i."</a></li>";
            }
            $articles_related .= "<li class='divider'></li>";
            $articles_related .= "<li><a href='".$url.$nb_page."§' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            $articles_related .= "</ul></div>";
        }
    }

    $pageTitle = " - ".$membre->getPseudo();

    $pseudo = $membre->getPseudo();
    $titre = $membre->getTitre();
    $desc = $membre->getDescr();
    $avatar = md5(strtolower(trim($membre->getImage())));

    if ($membre->getFacebook()) {
        $facebook = $membre->getFacebook();
    }
    if ($membre->getTwitter()) {
        $twitter = $membre->getTwitter();
    }
    if ($membre->getGoogle()) {
        $google = $membre->getGoogle();
    }
    if ($membre->getSite()) {
        $site = $membre->getSite();
    }

    ob_start();
    include 'view/profil.php';
    $content = ob_get_clean();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}

function showEvenements()
{
    $mysql = openConnexion();

    $pageTitle = " - Évènements";

    $menu = getMenu();
    $top = getTop();

    $page = 1;

    if ($_GET["p"] == "") {
        $_GET["p"] = "1";
    }

    if ($_GET["y"] == "") {
        $_GET["y"] = "all";
    }

    if ($_GET["m"] == "") {
        $_GET["m"] = "all";
    }

    if ($_GET["j"] == "") {
        $_GET["j"] = "all";
    }

    $articles = array();
    $total = 0;

    $total = Article::countEvenement($mysql, $_GET["y"], $_GET["m"], $_GET["j"]);
    $articles = Article::getEvenement($mysql, $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 5, $total);
    $nb_page = ceil($total / 5);

    $content = "<div id='articles'>";

    $content .= getFiltres("e");

    if (count($articles)) {
        foreach ($articles as $article) {
            $membre = $article->getMembre();
            $cat = $article->getCategorie();
            $titre = $article->getTitre();
            $id = $article->getIdArticle();
            $image = $article->getImage();
            $nbVue = $article->getNb_vues();
            $annee = $article->getAnnee();
            $mois = $article->getMois();
            $jour = $article->getJour();
            $permalien = $article->getPermalien();
            $pseudo = $membre->getPseudo();
            $avatar = md5(strtolower(trim($membre->getImage())));
            $categorie = utf8_encode($cat->getNom());
            $tag = $cat->getTag();
            $membreId = $membre->getIdMembre();
            $date = returnFrenchDate(date("Y-m-d H:i",$article->getDate()));
            $contenu = texte_resume_brut($article->getContenu(), 250);

            ob_start();
            include 'view/articles_liste_home.php';
            $content .= ob_get_clean();
        }

        $content .= "</div>";

        if ($nb_page > 1) {
            $content .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "article/liste/".$_GET["c"]."/".($_GET["y"] != "all" ? $_GET["y"]."/" : "").($_GET["m"] != "all" ? $_GET["m"]."/" : "").($_GET["j"] != "all" ? $_GET["j"]."/" : "");
            $content .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
            $content .= "<li class='divider'></li>";
            for ($i = 1; $i <= $nb_page; $i++) {
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $content .= "<li ".$active."><a href='".$url.$i."§/'>".$i."</a></li>";
            }
            $content .= "<li class='divider'></li>";
            $content .= "<li><a href='".$url.$nb_page."§/' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            $content .= "</ul></div>";
        }
    } else {
        $content = "Il n'y a aucun événement";
    }

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}




function showDetailArticle()
{
    $mysql = openConnexion();

    global $admin, $artiste;

    $menu = getMenu();
    $top = getTop(); 

    $a = Article::selectDetail($mysql, $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"]);

    if (count($a)) {
        $article = $a[0];
        
        //Compteur de visite sur IP
        compter_visite($mysql, $article);       
        $article->setNb_vues($article->nbVues());        
        
        $membre = $article->getMembre();

        if ($membre->getFacebook()) {
            $facebook = $membre->getFacebook();
        }
        if ($membre->getTwitter()) {
            $twitter = $membre->getTwitter();
        }
        if ($membre->getGoogle()) {
            $google = $membre->getGoogle();
        }
        if ($membre->getSite()) {
            $site = $membre->getSite();
        }

        $cat = $article->getCategorie();
        $titre = $article->getTitre();
        $annee = $article->getAnnee();
        $mois = $article->getMois();
        $jour = $article->getJour();
        $permalien = $article->getPermalien();
        $image = $article->getImage();
        $nbVue = $article->getNb_vues();
        $pseudo = $membre->getPseudo();
        $avatar = md5(strtolower(trim($membre->getImage())));
        $mtitre = $membre->getTitre();
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $url = "http://$host$uri/".$article->getAnnee()."/".$article->getMois()."/".$article->getJour()."/".$article->getPermalien();
        $categorie = utf8_encode($cat->getNom());
        $tag = $cat->getTag();
        $membreId = $membre->getIdMembre();
        $date = returnFrenchDate(date("Y-m-d H:i",$article->getDate()));
        $contenu = $article->getContenu();
        $id = $article->getIdArticle();

        ob_start();
        include 'view/article_detail.php';
        $article_detail = ob_get_clean();
    } else {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header ("Location:http://$host$uri/404");
    }
    
    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();

    include 'layout.php';
}

function showListeArticle()
{
    $mysql = openConnexion();

    $pageTitle = " - Articles";
    
    $menu = getMenu();
    $top = getTop(); 
    
    $page = 1;
    
    if ($_GET["p"] == "") {
        $_GET["p"] = "1";
    } 
    
    if ($_GET["c"] == "") {
        $_GET["c"] = "all";
    } 
    
    if ($_GET["y"] == "") {
        $_GET["y"] = "all";
    } 
    
    if ($_GET["m"] == "") {
        $_GET["m"] = "all";
    } 
    
    if ($_GET["j"] == "") {
        $_GET["j"] = "all";
    }

    $articles = array();
    $total = 0;

    if ($_GET["c"] != "all") {
        $categories = Categorie::loadAll($mysql);

        foreach ($categories as $categorie) {
            if ($_GET["c"] == $categorie->getTag()) {
                $total = Article::countByCategorie($mysql, $categorie, $_GET["y"], $_GET["m"], $_GET["j"]);
                $articles = Article::getByCategorie($mysql, $categorie,  $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 5, $total);
                $cat = utf8_encode($categorie->getNom());
                break;
            }
        }
    } else {
        $cat = "Tous les articles";
        $total = Article::countAllCategorie($mysql, $_GET["y"], $_GET["m"], $_GET["j"]);
        $articles = Article::selectAllCategorie($mysql, $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 5, $total);
    }

    $nb_page = ceil($total / 5);
    
    $content = "<div id='articles'>";

    $content .= getFiltres("l", $_GET["c"]);
    
    if (count($articles)) {
        foreach ($articles as $article) {
            $membre = $article->getMembre();
            $cat = $article->getCategorie();
            $titre = $article->getTitre();
            $id = $article->getIdArticle();
            $image = $article->getImage();
            $nbVue = $article->getNb_vues();
            $annee = $article->getAnnee();
            $mois = $article->getMois();
            $jour = $article->getJour();
            $permalien = $article->getPermalien();
            $pseudo = $membre->getPseudo();
            $avatar = md5(strtolower(trim($membre->getImage())));
            $categorie = utf8_encode($cat->getNom());
            $tag = $cat->getTag();
            $membreId = $membre->getIdMembre();
            $date = returnFrenchDate(date("Y-m-d H:i",$article->getDate()));
            $contenu = texte_resume_brut($article->getContenu(), 250);

            ob_start();
            include 'view/articles_liste_home.php';
            $content .= ob_get_clean();
        }

        $content .= "</div>";

        if ($nb_page > 1) {       
            $content .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "article/liste/".$_GET["c"]."/".($_GET["y"] != "all" ? $_GET["y"]."/" : "").($_GET["m"] != "all" ? $_GET["m"]."/" : "").($_GET["j"] != "all" ? $_GET["j"]."/" : "");
            $content .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
            $content .= "<li class='divider'></li>";
            for ($i = 1; $i <= $nb_page; $i++) {  
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $content .= "<li ".$active."><a href='".$url.$i."§/'>".$i."</a></li>";
            }
            $content .= "<li class='divider'></li>";
            $content .= "<li><a href='".$url.$nb_page."§/' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            $content .= "</ul></div>";
        }
    } else {
        $content = "Il n'y a aucun articles dans cette catégorie";
    }

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}

function showSearchArticle()
{
    $mysql = openConnexion();
    $pageTitle = " - Recherche";

    $menu = getMenu();
    $top = getTop();

    $page = 1;

    if ($_GET["p"] == "") {
        $_GET["p"] = "1";
    }

    if ($_GET["y"] == "") {
        $_GET["y"] = "all";
    }

    if ($_GET["m"] == "") {
        $_GET["m"] = "all";
    }

    if ($_GET["j"] == "") {
        $_GET["j"] = "all";
    }

    $articles = array();
    $total = Article::countSearch($mysql, $_GET["s"], $_GET["y"], $_GET["m"], $_GET["j"]);
    $articles = Article::getBySearch($mysql, $_GET["s"], $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 5, $total);
    $nb_page = ceil($total / 5);

    if ($total <= 0) {
        $content = "<div id='articles'>Aucun resultat ne correspond à votre recherche.</div>";
    } else {
        $content = "<div id='articles'>";

        $content .= getFiltres("s", $_GET["s"]);

        foreach ($articles as $article) {
            $membre = $article->getMembre();
            $cat = $article->getCategorie();
            $titre = $article->getTitre();
            $id = $article->getIdArticle();
            $annee = $article->getAnnee();
            $mois = $article->getMois();
            $jour = $article->getJour();
            $permalien = $article->getPermalien();
            $image = $article->getImage();
            $nbVue = $article->getNb_vues();
            $pseudo = $membre->getPseudo();
            $avatar = md5(strtolower(trim($membre->getImage())));
            $categorie = utf8_encode($cat->getNom());
            $tag = $cat->getTag();
            $membreId = $membre->getIdMembre();
            $date = returnFrenchDate(date("Y-m-d H:i",$article->getDate()));
            $contenu = texte_resume_brut($article->getContenu(), 250);

            ob_start();
            include 'view/articles_liste_home.php';
            $content .= ob_get_clean();
        }

        $content .= "</div>";

        if ($nb_page > 1) {
            $content .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "recherche/".$_GET["s"]."/".($_GET["y"] != "all" ? $_GET["y"]."/" : "").($_GET["m"] != "all" ? $_GET["m"]."/" : "").($_GET["j"] != "all" ? $_GET["j"]."/" : "");
            $content .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
            $content .= "<li class='divider'></li>";
            for ($i = 1; $i <= $nb_page; $i++) {
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $content .= "<li ".$active."><a href='".$url.$i."§'>".$i."</a></li>";
            }
            $content .= "<li class='divider'></li>";
            $content .= "<li><a href='".$url.$nb_page."§' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            $content .= "</ul></div>";
        }
    }

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}

function showPassword()
{
    $mysql = openConnexion();
    $erreur = "";
    
    $pageTitle = "";

    $menu = getMenu();
    $top = getTop(); 

    if (isset($_POST["mail"])) {
        $membre = Membre::selectByMail($mysql, $_POST["mail"]);
        if (count($membre)) {
                $password = random(10);
                $salt = random(5);
                $mdp = md5(md5($salt).md5($password));
                $membre[0]->setMdp($mdp);
                $membre[0]->setSalt($salt);
                $content = "<div class='alert alert-success' id='succes'><strong>Félicitation!</strong> Votre mot de passe a bien été réinitialisé, rendez-vous dans votre boite mail!</div>";

                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

                ob_start();
                include 'view/mail_password.php';
                $text = ob_get_clean();

                $mail = new Email();
                $mail->setFrom("LanceA News");
                $mail->addTo($membre[0]->getMail());
                $mail->setSubject("LanceA News: Mot de passe");
                $mail->setMessage($text);
                $mail->sendMail();

                header ("Refresh: 3;URL=http://$host$uri/");
        } else {
            $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Votre e-mail n'est pas connue!</div>";

            ob_start();
            include 'view/membre_password.php';
            $content = ob_get_clean();
        }
    } else {
        ob_start();
        include 'view/membre_password.php';
        $content = ob_get_clean();
    }
    include 'layout.php';
}

function showInscriptionArtiste()
{
    $mysql = openConnexion();
    $erreur = "";

    $pageTitle = " - Inscription";
    
    $menu = getMenu();
    $top = getTop(); 

    if (isset($_POST["login"]) && isset($_POST["mail"]) && isset($_POST["mdp"])) {
        $membrePseudo = Membre::selectByPseudo($mysql, $_POST["login"]);
        $membreMail = Membre::selectByMail($mysql, $_POST["mail"]);
        if (!count($membrePseudo) && !count($membreMail)) {
            if ($_POST["mdp"] == $_POST["mdp2"]) {
                $salt = random(5);
                $mdp = md5(md5($salt).md5($_POST["mdp"]));
                $groupe = Groupe::load($mysql, 2);
                $membre = Membre::create($mysql,$_POST["login"],$mdp,0,'','','','','','',$salt,$_POST["mail"],random(20),"",$groupe,0);
                $content = "<div class='alert alert-success' id='succes'><strong>Bienvenue</strong> Rendez-vous dans votre boite mail afin de valider votre inscription!</div>";

                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

                $url = "http://$host$uri/artiste/validation/".$membre->getIdMembre()."/".$membre->getActivation();

                ob_start();
                include 'view/mail_inscription.php';
                $text = ob_get_clean();

                $mail = new Email();
                $mail->setFrom("LanceA News");
                $mail->addTo($_POST["mail"]);
                $mail->setSubject("Bienvenu sur le site LanceA News");
                $mail->setMessage($text);
                $mail->sendMail();

                header ("Refresh: 3;URL=http://$host$uri/");
            } else {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Les deux mots de passe ne correspondent pas!</div>";
                ob_start();
                include 'view/inscription.php';
                $content = ob_get_clean();
            }
        } else {
            if(count($membrePseudo)) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Votre pseudo est deja utilisé!</div>";
            }
            if(count($membreMail)) {
                $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Votre e-mail est deja utilisée!</div>";$erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Votre e-mail est deja utilisée!</div>";
            }
            ob_start();
            include 'view/inscription.php';
            $content = ob_get_clean();
        }
    } else {
        ob_start();
        include 'view/inscription.php';
        $content = ob_get_clean();
    }
    include 'layout.php';
}

function showValidationArtiste()
{
    $mysql = openConnexion();

    $pageTitle = " - Validation du compte";
    
    $menu = getMenu();
    $top = getTop(); 

    $membre = Membre::load($mysql, $_GET["m"]);
    if ($membre->getActivation() == $_GET["c"]) {
        $content = "<div class='alert alert-success'><strong>Félicitation</strong> Votre inscription est maintenant terminée ! Vous allez être redirigé vers la page d'acceuil dans quelques secondes.</div>";
        $membre->setActive(1,false);
        $membre->setActivation("",false);
        $membre->update();
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header ("Refresh: 8;URL=http://$host$uri/");
    } else {
        $content = "<div class='alert alert-danger'><strong>Erreur</strong> Le code soumit est erroné !</div>";
    }

    include 'layout.php';
}

function showDeconnexionArtiste()
{
    $mysql = openConnexion();

    $pageTitle = "Déconexion";
    
    $menu = getMenu();
    $top = getTop(); 

    unset($_SESSION["idMembre"]);
    setCookie('membre', '', 0, "/");

    $content = "<div id='deconnexion' class='alert alert-success'><strong>Déconnexion</strong> ...</div>";

    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header ("Refresh: 3;URL=http://$host$uri/");

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();


    include 'layout.php';
}

function showModArtiste()
{
    $mysql = openConnexion();

    global $admin, $artiste, $membreCo;
    
    $erreur = "";

    if (isset($_POST["idMembre"]) && isset($_POST["mail"]) && isset($_POST["mdp"]) && isset($_POST["mdp2"]) && isset($_POST["desc"]) && isset($_POST["facebook"]) && isset($_POST["twitter"]) && isset($_POST["google"]) && isset($_POST["site"])) {
        if ($_POST["mdp"] == $_POST["mdp2"])  {
            $membre = Membre::load($mysql, $_POST["idMembre"]);
            $membre->setMail($_POST["mail"],false);
            if ($_POST["mdp"] != "") {
                $salt = random(5);
                $mdp = md5(md5($salt).md5($_POST["mdp"]));
                $membre->setMdp($mdp,false);
                $membre->setSalt($salt,false);
            }
            $membre->setImage($_POST["avatar"],false);
            $membre->setDescr($_POST["desc"],false);
            $membre->setFacebook($_POST["facebook"],false);
            $membre->setTwitter($_POST["twitter"],false);
            $membre->setGoogle($_POST["google"],false);
            $membre->setSite($_POST["site"],false);
            $membre->setTitre($_POST["titre"],false);
            $membre->update();

            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header ("Location:http://$host$uri/profil/".$membre->getPseudo());
        } else {
            $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> Les deux mots de passe ne correspondent pas!</div>";
        }
    }

    $menu = getMenu();
    $top = getTop(); 

    $pageTitle = " - ".$membreCo->getPseudo();
    
    $idMembre = $membreCo->getIdMembre();
    $pseudo = $membreCo->getPseudo();
    $optionPseudo = "disabled";
    $mail = $membreCo->getMail();
    $desc = ($membreCo->getDescr() ? $membreCo->getDescr() : " Votre biographie") ;
    $avatar = $membreCo->getImage();
    $facebook = $membreCo->getFacebook();
    $twitter = $membreCo->getTwitter();
    $urlRetour = "/";
    $google = $membreCo->getGoogle();
    $mdpReq = "";
    $titre = $membreCo->getTitre();
    $site = $membreCo->getSite();
    $action = "Modifier";

    ob_start();
    include 'view/membre_form.php';
    $content = ob_get_clean();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_partenaires = ob_get_clean();

    include 'layout.php';
}