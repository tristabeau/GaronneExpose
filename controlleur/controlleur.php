<?php

function showHome()
{
    $mysql = openConnexion();

    $pageTitle = "";

    $menu = getMenu();
    
    $top = getTop();

    $articles = Article::getLastArticles($mysql);
    $content = "<div class='header clearfix'><h4>Les derniers ajouts</h4></div>";
    $content .= "<div class='row'>";
    $it = 1;

    if (count($articles)) {
        foreach ($articles as $article) {
            if ($it > 3) {
                $content .= "</div>";
                $content .= "<div class='row'>";
                $it = 1;
            }
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

            $it++;
        }

        $content .= "</div>";

        $content .= "<div id='boutonTous' class='col-md-12'><a class='btn btn-primary btn-sm' href='contenus/liste/1/all'>Toutes les publications</a></div>";

    } else {
        $content .= "Il n'y a aucun contenu</div>";
    }

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

    include 'layout.php';
}

function showContact()
{
    $mysql = openConnexion();

    $pageTitle = " - Contact";

    if (isset($_POST["name"])) {
        $mail = new Email();
        $mail->setFrom("Garonne Expose");
        $mail->addTo("contact@la-garonne-expose.com; presidente@la-garonne-expose.com");
        $mail->setSubject("Contact : Garonne Expose");
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

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

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

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

    include 'layout.php';
}

function showPresentation ()
{
    $mysql = openConnexion();
    $pageTitle = " - Présentation";

    $menu = getMenu();

    $top = getTop();

    ob_start();
    include 'view/presentation.php';
    $content = ob_get_clean();

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

    include 'layout.php';
}

function showBureau()
{
    $mysql = openConnexion();

    $pageTitle = " - Bureau";

    $menu = getMenu();

    $top = getTop();

    $content = "";

    $artistes = Membre::selectBureau($mysql);

    $content = "<div class='header clearfix'><h4>Le bureau</h4></div>";
    $content .= "<div class='row'>";
    $it = 1;

    if (count($artistes)) {
        foreach ($artistes as $artiste) {
            if ($it > 3) {
                $content .= "</div>";
                $content .= "<div class='row'>";
                $it = 1;
            }
            $membreId = $artiste->getIdMembre();
            $description = texte_resume_brut($artiste->getDescr(), 250);
            $pseudo = $artiste->getPseudo();
            $articles = Article::selectPeintureByArtiste($mysql, $artiste);
            if (count($articles)) {
                $num = rand(0, count($articles)-1);
                $article = $articles[$num];
                $image = "img/articles/".$article->getImage();
            } else {
                $image = "img/avatars/default.png";
            }
            if ($artiste->getFacebook()) {
                $facebook = $artiste->getFacebook();
            }
            if ($artiste->getTwitter()) {
                $twitter = $artiste->getTwitter();
            }
            if ($artiste->getGoogle()) {
                $google = $artiste->getGoogle();
            }
            if ($artiste->getSite()) {
                $site = $artiste->getSite();
            }

            ob_start();
            include 'view/artiste.php';
            $content .= ob_get_clean();

            $it++;
        }
    } else {
        $content .= "Il n'y a aucun membre du bureau";
    }

    $content .= "</div>";

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

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

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

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

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

    include 'layout.php';
}

function showArtistes()
{
    $mysql = openConnexion();

    $pageTitle = " - Les Artistes";

    $menu = getMenu();

    $top = getTop();

    $artistes = Membre::selectArtistes($mysql);

    $content = "<div class='header clearfix'><h4>Galerie des artistes</h4></div>";
    $content .= "<div class='row'>";
    $it = 1;

    if (count($artistes)) {
        foreach ($artistes as $artiste) {
            if ($it > 3) {
                $content .= "</div>";
                $content .= "<div class='row'>";
                $it = 1;
            }
            $membreId = $artiste->getIdMembre();
            $description = texte_resume_brut($artiste->getDescr(), 250);
            $pseudo = $artiste->getPseudo();
            $articles = Article::selectPeintureByArtiste($mysql, $artiste);
            if (count($articles)) {
                $num = rand(0, count($articles)-1);
                $article = $articles[$num];
                $image = "img/articles/".$article->getImage();
            } else {
                $image = "img/avatars/default.png";
            }
            if ($artiste->getFacebook()) {
                $facebook = $artiste->getFacebook();
            }
            if ($artiste->getTwitter()) {
                $twitter = $artiste->getTwitter();
            }
            if ($artiste->getGoogle()) {
                $google = $artiste->getGoogle();
            }
            if ($artiste->getSite()) {
                $site = $artiste->getSite();
            }

            ob_start();
            include 'view/artiste.php';
            $content .= ob_get_clean();

            $it++;
        }
    } else {
        $content .= "Il n'y a aucun artiste";
    }

    $content .= "</div>";

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

    include 'layout.php';
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
    $articles = Article::getPeintureByAuteur($mysql, $membreId, $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 9, $total);
    $nb_page = ceil($total / 9);

    $filtres = getFiltres("p", $_GET["n"]);

    $articles_related = "";
    $nb_peinture = count($articles);

    if ($total > 0) {
        $i = 1;
        $articles_related .= "<div class='row'>";

        foreach ($articles as $article) {
            if ($i > 3) {
                $articles_related .= "</div>";
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

        $articles_related .= "</div>";

        if ($nb_page > 1) {
            $articles_related .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "profil/".$_GET["n"]."/".($_GET["y"] != "all" ? $_GET["y"]."/" : "").($_GET["m"] != "all" ? $_GET["m"]."/" : "").($_GET["j"] != "all" ? $_GET["j"]."/" : "");
            if ($_GET["p"] != 1) {
                $articles_related .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
                $articles_related .= "<li class='divider'></li>";
            }
            for ($i = 1; $i <= $nb_page; $i++) {
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $articles_related .= "<li ".$active."><a href='".$url."page-".$i."'>".$i."</a></li>";
            }
            if ($_GET["p"] != $nb_page) {
                $articles_related .= "<li class='divider'></li>";
                $articles_related .= "<li><a href='".$url."page-".$nb_page."' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            }
            $articles_related .= "</ul></div>";
        }
    }

    $pageTitle = " - ".$membre->getPseudo();

    $pseudo = $membre->getPseudo();
    $titre = $membre->getTitre();
    $desc = $membre->getDescr();
    $articles = Article::selectPeintureByArtiste($mysql, $membre);
    if (count($articles)) {
        $num = rand(0, count($articles)-1);
        $article = $articles[$num];
        $avatar = "img/articles/".$article->getImage();
    } else {
        $avatar = "img/avatars/default.png";
    }

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

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

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
    $articles = Article::getEvenement($mysql, $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 6, $total);
    $nb_page = ceil($total / 5);

    $content = "<div class='header clearfix'><h4>Les évènements</h4></div>";
    $content .= "<div class='row'>";
    $it = 1;

    if (count($articles)) {

        $content .= getFiltres("e");

        foreach ($articles as $article) {
            if ($it > 3) {
                $content .= "</div>";
                $content .= "<div class='row'>";
                $it = 1;
            }
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

            $it++;
        }

        $content .= "</div>";

        if ($nb_page > 1) {
            $content .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "evenements/".($_GET["y"] != "all" ? $_GET["y"]."/" : "").($_GET["m"] != "all" ? $_GET["m"]."/" : "").($_GET["j"] != "all" ? $_GET["j"]."/" : "");
            if ($_GET["p"] != 1) {
                $content .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
                $content .= "<li class='divider'></li>";
            }
            for ($i = 1; $i <= $nb_page; $i++) {
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $content .= "<li ".$active."><a href='".$url."page-".$i."'>".$i."</a></li>";
            }
            if ($_GET["p"] != $nb_page) {
                $content .= "<li class='divider'></li>";
                $content .= "<li><a href='".$url."page-".$nb_page."' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            }

            $content .= "</ul></div>";
        }
    } else {
        $content .= "Il n'y a aucun événement</div>";
    }

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

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

        $articles = Article::selectPeintureByArtiste($mysql, $membre);
        if (count($articles)) {
            $num = rand(0, count($articles)-1);
            $article = $articles[$num];
            $avatar = "img/articles/".$article->getImage();
        } else {
            $avatar = "img/avatars/default.png";
        }

        ob_start();
        include 'view/article_detail.php';
        $article_detail = ob_get_clean();
    } else {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header ("Location:http://$host$uri/404");
    }

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

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

    $_GET["c"] = "all";
    
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

    $cat = "Tous les articles";
    $total = Article::countAllCategorie($mysql, $_GET["y"], $_GET["m"], $_GET["j"]);
    $articles = Article::selectAllCategorie($mysql, $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 6, $total);

    $nb_page = ceil($total / 6);

    $content = "<div class='header clearfix'><h4>Toutes les publications</h4></div>";
    $content .= getFiltres("l", $_GET["c"]);
    $content .= "<div class='row'>";


    if (count($articles)) {
        $it = 1;

        foreach ($articles as $article) {
            if ($it > 3) {
                $content .= "</div>";
                $content .= "<div class='row'>";
                $it = 1;
            }
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

            $it++;
        }

        $content .= "</div>";

        if ($nb_page > 1) {       
            $content .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "contenus/liste/".($_GET["y"] != "all" ? $_GET["y"]."/" : "").($_GET["m"] != "all" ? $_GET["m"]."/" : "").($_GET["j"] != "all" ? $_GET["j"]."/" : "");
            if ($_GET["p"] != 1) {
                $content .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
                $content .= "<li class='divider'></li>";
            }
            for ($i = 1; $i <= $nb_page; $i++) {
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $content .= "<li ".$active."><a href='".$url."page-".$i."'>".$i."</a></li>";
            }
            if ($_GET["p"] != $nb_page) {
                $content .= "<li class='divider'></li>";
                $content .= "<li><a href='".$url."page-".$nb_page."' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            }
            $content .= "</ul></div>";
        }
    } else {
        $content = "Il n'y a aucun articles dans cette catégorie";
    }

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

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
    $articles = Article::getBySearch($mysql, $_GET["s"], $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 6, $total);
    $nb_page = ceil($total / 6);

    $content = "<div class='header clearfix'><h4>Résultat de la recherche : ".$_GET["s"]."</h4></div>";

    if ($total <= 0) {
        $content .= "<div class='row'>Aucun resultat ne correspond à votre recherche.</div>";
    } else {
        $content .= getFiltres("s", $_GET["s"]);
        $content .= "<div class='row'>";
        $it = 1;

        foreach ($articles as $article) {
            if ($it > 3) {
                $content .= "</div>";
                $content .= "<div class='row'>";
                $it = 1;
            }
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

            $it++;
        }

        $content .= "</div>";


        if ($nb_page > 1) {
            $content .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "recherche/".$_GET["s"]."/".($_GET["y"] != "all" ? $_GET["y"]."/" : "").($_GET["m"] != "all" ? $_GET["m"]."/" : "").($_GET["j"] != "all" ? $_GET["j"]."/" : "");
            if ($_GET["p"] != 1) {
                $content .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
                $content .= "<li class='divider'></li>";
            }
            for ($i = 1; $i <= $nb_page; $i++) {
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $content .= "<li ".$active."><a href='".$url."page-".$i."'>".$i."</a></li>";
            }
            if ($_GET["p"] != $nb_page) {
                $content .= "<li class='divider'></li>";
                $content .= "<li><a href='".$url."page-".$nb_page."' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            }

            $content .= "</ul></div>";
        }
    }

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

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
                $mail->setFrom("Garonne Expose");
                $mail->addTo($membre[0]->getMail());
                $mail->setSubject("Garonne Expose: Mot de passe");
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
                $mail->setFrom("Garonne Expose");
                $mail->addTo($_POST["mail"]);
                $mail->setSubject("Bienvenu sur le site Garonne Expose");
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

    unset($_SESSION["idArtiste"]);
    setCookie('artiste', '', 0, "/");

    $content = "<div id='deconnexion' class='alert alert-success'><strong>Déconnexion</strong> ...</div>";

    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header ("Refresh: 3;URL=http://$host$uri/");

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);


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

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

    include 'layout.php';
}

function showPresse()
{
    $mysql = openConnexion();

    $pageTitle = " - Revue de presse";

    $menu = getMenu();
    $top = getTop();

    if ($_GET["p"] == "") {
        $_GET["p"] = "1";
    }

    $total = Presse::count($mysql);
    $nb_page = ceil($total / 6);
    $presses = Presse::loadFromPage($mysql, $_GET["p"], $total);

    $content = "<div class='header clearfix'><h4>Les revues de presse</h4></div>";
    $content .= "<div class='row'>";
    $it = 1;

    if (count($presses)) {
        foreach ($presses as $presse) {
            if ($it > 3) {
                $content .= "</div>";
                $content .= "<div class='row'>";
                $it = 1;
            }

            $nom = $presse->getNom();
            $file = $presse->getImage();

            if (stripos($presse->getImage(), '.pdf')) {
                $image = "img/presses/defaultPdf.png";
            } else {
                $image = $presse->getImage();
            }

            ob_start();
            include 'view/revue_presse.php';
            $content .= ob_get_clean();

            $it++;
        }

        $content .= "</div>";

        if ($nb_page > 1) {
            $content .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "presses/";
            if ($_GET["p"] != 1) {
                $content .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
                $content .= "<li class='divider'></li>";
            }
            for ($i = 1; $i <= $nb_page; $i++) {
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $content .= "<li ".$active."><a href='".$url."page-".$i."'>".$i."</a></li>";
            }
            if ($_GET["p"] != $nb_page) {
                $content .= "<li class='divider'></li>";
                $content .= "<li><a href='".$url."page-".$nb_page."' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            }

            $content .= "</ul></div>";
        }
    } else {
        $content .= "Il n'y a aucune revue de presse</div>";
    }

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

    include 'layout.php';
}

function showPartenaire()
{
    $mysql = openConnexion();

    $pageTitle = " - Partenaires";

    $menu = getMenu();
    $top = getTop();

    if ($_GET["p"] == "") {
        $_GET["p"] = "1";
    }

    $total = Partenaire::count($mysql);
    $nb_page = ceil($total / 6);
    $partenaires = Partenaire::loadFromPage($mysql, $_GET["p"], $total);

    $content = "<div class='header clearfix'><h4>Les partenaires</h4></div>";
    $content .= "<div class='row'>";
    $it = 1;

    if (count($partenaires)) {
        foreach ($partenaires as $partenaire) {
            if ($it > 3) {
                $content .= "</div>";
                $content .= "<div class='row'>";
                $it = 1;
            }

            $nom = $partenaire->getNom();
            $site = $partenaire->getSite();
            $image = $partenaire->getImage();

            ob_start();
            include 'view/partenaires.php';
            $content .= ob_get_clean();

            $it++;
        }

        $content .= "</div>";

        if ($nb_page > 1) {
            $content .= "<div id='paginationBox'><ul class='pagination'>";
            $url = "partenaires/";
            if ($_GET["p"] != 1) {
                $content .= "<li><a href='".$url."' title='prev'><i class='fa fa-angle-double-left'></i></a></li>";
                $content .= "<li class='divider'></li>";
            }
            for ($i = 1; $i <= $nb_page; $i++) {
                $active = (((isset($_GET["p"])) && ($i == $_GET["p"])) || (($i == 1) && (!isset($_GET["p"])))) ? "class='active'" : "" ;
                $content .= "<li ".$active."><a href='".$url."page-".$i."'>".$i."</a></li>";
            }
            if ($_GET["p"] != $nb_page) {
                $content .= "<li class='divider'></li>";
                $content .= "<li><a href='".$url."page-".$nb_page."' title='next'><i class='fa fa-angle-double-right'></i></a></li>";
            }
            $content .= "</ul></div>";
        }
    } else {
        $content .= "Il n'y a aucune revue de presse</div>";
    }

    $widget_social = widgetSocial();
    $widget_partenaires = widgetPartenaires($mysql);
    $widget_gallerie = widgetGallerie($mysql);

    include 'layout.php';
}

function widgetGallerie($pdo)
{
    $peints = Article::getPeintures($pdo);
    $peintures = "";
    $first = 1;

    if (count($peints)) {
        foreach ($peints as $peint) {
            if ($first) {
                $peintures .= "<div class='item active'>";
                $peintures .= "<img src='".$peint->getImage()."' alt='".$peint->getTitre()."'>";
                $peintures .= "</div>";
                $first = false;
            } else {
                $peintures .= "<div class='item'>";
                $peintures .= "<img src='".$peint->getImage()."' alt='".$peint->getTitre()."'>";
                $peintures .= "</div>";
            }
        }
    } else {
        $peintures .= "Aucune peinture";
    }

    ob_start();
    include 'view/widget_gallerie.php';
    return ob_get_clean();
}

function widgetSocial()
{
    ob_start();
    include 'view/widget_social.php';
    return ob_get_clean();
}

function widgetPartenaires($pdo)
{
    $parts = Partenaire::loadAll($pdo);
    $partenaires = "";
    $first = 1;
    if (count($parts)) {
        foreach ($parts as $part) {
            if ($first) {
                $partenaires .= "<div class='item active'>";
                $partenaires .= "<a href='".$part->getSite()."' target='_blank' ><img src='".$part->getImage()."' alt='".$part->getNom()."'></a>";
                $partenaires .= "</div>";
                $first = false;
            } else {
                $partenaires .= "<div class='item'>";
                $partenaires .= "<a href='".$part->getSite()."' target='_blank' ><img src='".$part->getImage()."' alt='".$part->getNom()."'></a>";
                $partenaires .= "</div>";
            }
        }
    } else {
        $partenaires .= "Aucun partenaire";
    }

    ob_start();
    include 'view/widget_partenaires.php';
    return ob_get_clean();
}

function getMenu()
{
    global $admin, $artiste;

    ob_start();
    include 'view/menu.php';
    $res = ob_get_clean();
    return $res;
}

function getTop()
{
    $mysql = openConnexion();

    if (isset($_SESSION["idArtiste"])) {
        global $membreCo;
        $id = $_SESSION["idArtiste"];
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

function getFiltres($a, $val = "")
{
    $mysql = openConnexion();

    $filtreAnnees = "<option value='all'>Toutes</option>";
    $filtreMois = "<option value='all'>Tous</option>";
    $filtreJours = "<option value='all'>Tous</option>";

    if ($a == "l") {
        $selectAnnee = "selectAnnee('all');";
        $selectMois = "selectMois('all');";
        $annees = Article::selectDistinctAnnee($mysql);

        foreach ($annees as $annee) {
            $selected = (($annee["annee"] == $_GET["y"]) ? "selected" : "");
            $filtreAnnees .= "<option value='".$annee["annee"]."' ".$selected.">".$annee["annee"]."</option>";
        }

        if (isset($_GET["y"]) && ($_GET["y"] != "all")) {
            $mois = Article::selectDistinctMois($mysql, $_GET["y"]);

            foreach ($mois as $moi) {
                $selected = (($moi["mois"] == $_GET["m"]) ? "selected" : "");
                $filtreMois .= "<option value='".$moi["mois"]."' ".$selected.">".$moi["mois"]."</option>";
            }

            if (isset($_GET["m"]) && ($_GET["m"] != "all")) {
                $jours = Article::selectDistinctJours($mysql, $_GET["y"], $_GET["m"]);

                foreach ($jours as $jour) {
                    $selected = (($jour["jour"] == $_GET["j"]) ? "selected" : "");
                    $filtreJours .= "<option value='".$jour["jour"]."' ".$selected.">".$jour["jour"]."</option>";
                }
            }
        }

        $filtrer = "filtrerListe('".$val."');";
    }else if ($a == "e") {
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
