<?php
function showHome()
{
    $mysql = openConnexion();

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
        $nbCom = count($article->selectCommentaires());
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

    $content .= "<div id='boutonTous'><a class='btn btn-primary btn-sm' href='article/liste/1/all'>Tous les articles</a></div>";

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

function showCharte()
{
    $pageTitle = " - Charte de publication";
    
    $menu = getMenu();
    $top = getTop();
    
    ob_start();
    include 'view/charte.php';
    $contact = ob_get_clean();

    include 'layout.php';
}

function showStaff()
{
    $mysql = openConnexion();

    $pageTitle = " - Staff";
    
    $menu = getMenu();
    $top = getTop();    

    $groupes = Groupe::loadAll($mysql);
    $groupe = "<option value='all'>Tous</option>";

    foreach ($groupes as $g) {
        if ($g->getIdGroupe() != 1) {
            $selected = ((isset($_GET["groupe"]) && ($g->getNom() == $_GET["groupe"])) ? "selected" : "");
            $groupe .= "<option value='".utf8_encode($g->getNom())."' ".$selected.">".utf8_encode($g->getNom())."</option>";
        }
    }

    $content = "<div id='staff'><form name='formAction' method='get' action='' id='formAction'>";
    $content .= "<input name='v' value='staff' type='hidden' />";
    $content .= "<select name='groupe' onchange='selectGroupe($(this).val());'>".$groupe."</select></form></div><br /><br />";
    $titre = "LanceA News";
    $categorie = "Le staff";

    if (isset($_GET["groupe"]) && ($_GET["groupe"] != "")) {
        if ($_GET["groupe"] == "all") {
            $auteurs = Membre::selectStaff($mysql);
            $categorie .= " : Tous";
        } else {
            $gr = Groupe::selectByNom($mysql, $_GET["groupe"]);
            if (count($gr)) {
                $auteurs = Membre::selectByGroupe($mysql, $gr[0]);
                $categorie .= " : ".$gr[0]->getNom();
            } else {
                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                header ("Location:http://$host$uri/staff");
            }
        }

    }   else {
        $auteurs = Membre::selectStaff($mysql);
        $categorie .= " : Tous";
    }
    

    foreach ($auteurs as $auteur) {
        $membreId = $auteur->getIdMembre();
        $description = texte_resume_brut($auteur->getDescr(), 250);
        $pseudo = $auteur->getPseudo();
        $avatar = md5(strtolower(trim($auteur->getImage())));

        ob_start();
        include 'view/staff.php';
        $content .= ob_get_clean();
    }
    
    ob_start();
    include 'view/page_title.php';
    $page_title = ob_get_clean();

    $widget_recent = getRecent();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();

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

        if (isset($_POST["contenu"]) && (trim($_POST["contenu"]) != "")) {
            global $membreCo;
            Commentaire::create($mysql, time(), trim($_POST["contenu"]), $membreCo, $article);
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
        
        $pageTitle = " - ".$article->getTitre();
        
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
        $nbCom = count($article->selectCommentaires());
        $date = returnFrenchDate(date("Y-m-d H:i",$article->getDate()));
        $contenu = $article->getContenu();
        $id = $article->getIdArticle();
        $coms = $article->selectCommentaires();
        $commentaires = "";

        if (count($coms)) {
            foreach ($coms as $com) {
                $c_membre = $com->getMembre();
                $c_avatar =  md5(strtolower(trim($c_membre->getImage())));
                $c_pseudo = $c_membre->getPseudo();
                $c_membreId = $c_membre ->getIdMembre();
                $c_date = returnFrenchDate(date("Y-m-d H:i",$com->getDate()));
                $c_contenu = $com->getContenu();
                $c_id = $com->getIdCommentaire();

                ob_start();
                include 'view/article_commentaire.php';
                $commentaires .= ob_get_clean();
            }
        } else {
            $commentaires = "Aucun commentaire";
        }

        ob_start();
        include 'view/article_detail.php';
        $article_detail = ob_get_clean();

        ob_start();
        include 'view/page_title.php';
        $page_title = ob_get_clean();
    } else {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header ("Location:http://$host$uri/404");
    }

    $widget_recent = getRecent();

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
    
    $categorie = isset($cat) ? $cat : "";
    $titre = "LanceA News";
    ob_start();
    include 'view/page_title.php';
    $page_title = ob_get_clean();

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
            $nbCom = count($article->selectCommentaires());
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
    
    $widget_recent = getRecent();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();

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

    $categorie = "Recherche";
    $titre = "LanceA News";
    ob_start();
    include 'view/page_title.php';
    $page_title = ob_get_clean();
    
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
            $nbCom = count($article->selectCommentaires());
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

    $widget_recent = getRecent();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();

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

    $widget_recent = getRecent();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();

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

function showInscriptionMembre()
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
                $groupe = Groupe::load($mysql, 1);
                $membre = Membre::create($mysql,$_POST["login"],$mdp,0,'','','','','','',$salt,$_POST["mail"],random(20),"",$groupe,0);
                $content = "<div class='alert alert-success' id='succes'><strong>Bienvenue</strong> Rendez-vous dans votre boite mail afin de valider votre inscription!</div>";

                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

                $url = "http://$host$uri/membre/validation/".$membre->getIdMembre()."/".$membre->getActivation();

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

function showValidationMembre()
{
    $mysql = openConnexion();

    $pageTitle = "";
    
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

function showDeconnexionMembre()
{
    $mysql = openConnexion();

    $pageTitle = "";
    
    $menu = getMenu();
    $top = getTop(); 

    unset($_SESSION["idMembre"]);
    setCookie('membre', '', 0, "/");

    $content = "<div id='deconnexion' class='alert alert-success'><strong>Déconnexion</strong> ...</div>";

    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header ("Refresh: 3;URL=http://$host$uri/");
    
    $widget_recent = getRecent();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();


    include 'layout.php';
}

function showProfilMembre()
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
    $total = Article::countByAuteur($mysql, $membreId, $_GET["y"], $_GET["m"], $_GET["j"]);
    $articles = Article::getByAuteur($mysql, $membreId, $_GET["y"], $_GET["m"], $_GET["j"], $_GET["p"], 12, $total);
    $nb_page = ceil($total / 12);
    
    $filtres = getFiltres("p", $_GET["n"]);

    $articles_related = "";
    
    if ($total <= 0) {
        $content = "Cet auteur n'a encore publié aucun article.";
    } else {
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
            $nbCom = count($article->selectCommentaires());
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

    $isAdmin = false;
    if ($membre->getGroupeId() == 3) {
        $isAdmin = true;
    }
    
    $isAuteur = false;
    if ($membre->getGroupeId() == 2) {
        $isAuteur = true;
    }
    
    ob_start();
    include 'view/profil.php';
    $content = ob_get_clean();

    $widget_recent = getRecent();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();

    include 'layout.php';
}

function showModMembre()
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

    $widget_recent = getRecent();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();
    
    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();

    include 'layout.php';
}

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

function getRecent()
{
    $mysql = openConnexion();

    $a_pop = Article::getPopularArticles($mysql);
    $c_rec = Commentaire::getRecentCommentaires($mysql);

    $articles_pop = "";
    $articles_rec = "";
    $com_rec = "";

    foreach ($a_pop as $article) {
        $cat = $article->getCategorie();
        $date = date("d/m/Y H:i",$article->getDate());
        $articles_pop .= "<article class='article-tiny'>";
        $articles_pop .= "<a href='".$article->getAnnee()."/".$article->getMois()."/".$article->getJour()."/".$article->getPermalien()."' class='image'>";
        $articles_pop .= "<img src='img/articles/".$article->getImage()."' alt='".$article->getTitre()."'>";
        $articles_pop .= "<div class='image-light'></div>";
        $articles_pop .= "<div class='link'>";
        $articles_pop .= "<span class='dashicons dashicons-format-gallery'></span>";
        $articles_pop .= "</div>";
        $articles_pop .= "</a>";
        $articles_pop .= "<a href='".$article->getAnnee()."/".$article->getMois()."/".$article->getJour()."/".$article->getPermalien()."'><h5>".$article->getTitre()."</h5></a>";
        $articles_pop .= "<p class='post-meta'>";
        $articles_pop .= "<small>".$date."</small> &nbsp;";
        $articles_pop .= "<a href='article/liste/1/".$cat->getTag()."'><span class='fa fa-folder'></span> ".utf8_encode($cat->getNom())."</a>";
        $articles_pop .= "</p>";
        $articles_pop .= "<hr>";
        $articles_pop .= "</article>";
    }

    foreach ($c_rec as $commentaire) {
        $membre = $commentaire->getMembre();
        $article = Article::load($mysql, $commentaire->getArticleId());
        $date = date("d/m/Y H:i",$article->getDate());
        $com_rec .= "<li>";
        $com_rec .= "<div class='avatar'>";
        $com_rec .= "<a href='".$article->getAnnee()."/".$article->getMois()."/".$article->getJour()."/".$article->getPermalien()."#com".$commentaire->getIdCommentaire()."' class='light'>";
        $com_rec .= "<img src='http://www.gravatar.com/avatar/".md5(strtolower(trim($membre->getImage())))."?s=120&d=mm' alt='".$membre->getPseudo()."'>";
        $com_rec .= "<div class='layer'></div>";
        $com_rec .= "</a>";
        $com_rec .= "</div>";
        $com_rec .= "<div class='content'>";
        $com_rec .= "<div class='comment-content'>";
        $com_rec .= "<a href='".$article->getAnnee()."/".$article->getMois()."/".$article->getJour()."/".$article->getPermalien()."#com".$commentaire->getIdCommentaire()."'>".texte_resume_brut($commentaire->getContenu(),150)."</a>";
        $com_rec .= "</div>";
        $com_rec .= "<div class='comment-meta'>";
        $com_rec .= "<a href='profil/".$membre->getPseudo()."'><i class='fa fa-user'></i> ".$membre->getPseudo()."</a>&nbsp;";
        $com_rec .= "<small>".$date."</small> &nbsp;";
        $com_rec .= "</div>";
        $com_rec .= "</div>";
        $com_rec .= "</li>";
    }

    ob_start();
    include 'view/widget_recent.php';
    $res = ob_get_clean();
    return $res;
}

function getFiltres($a, $val)
{
    $mysql = openConnexion();

    $filtreAnnees = "<option value='all'>Toutes</option>";
    $filtreMois = "<option value='all'>Tous</option>";
    $filtreJours = "<option value='all'>Tous</option>";


    if ($a == "l") {
        $selectAnnee = "selectAnnee();";
        $selectMois = "selectMois();";
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
    $res = ob_get_clean();
    return $res;
}

function showProposerArticle()
{
    $mysql = openConnexion();

    $erreur = "";

    $pageTitle = " - Proposer un article";
    
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
                $taille_maxi = 512000;
                $taille = filesize($_FILES['image']['tmp_name']);
                if ($taille > $taille_maxi) {
                    $erreur .= "<div class='alert alert-danger'><strong>Erreur</strong> La taille de votre fichier est supérieur à 512 Ko!</div>";
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
            $membre = Membre::load($mysql, 1);
            $categorie = Categorie::load($mysql, $_POST["categorie"]);
            $permalien = to_permalink($_POST["titre"]);
            $contenu = $_POST["contenu"]."<br /><br /> <em>Merci à ".$_POST["auteur"]." pour la proposition de News!</em>";
            $article = Article::create($mysql, $_POST["titre"], time(), date("Y",time()), date("m",time()), date("d",time()), date("H:i",time()), $contenu, $image, 0, $permalien, '', '', $membre, $categorie, 0, 0, 0);

            $mail = new Email();
            $mail->setFrom("LanceA News");
            $staffs = Membre::selectStaff($mysql);
            foreach ($staffs as $staff) {
                $mail->addTo($staff->getMail());
            }
            $mail->setSubject("LanceA News :  Un article a été proposé");
            $message = "Titre : ".$_POST["titre"]."<br /><br />";
            $message = "Auteur : ".$_POST["auteur"]."<br /><br />";
            $message .= "Image : <img src='http://news.lancea-online.com/img/articles/".$image."' alt='Titre'/><br /><br />";
            $message .= "Contenu : ".$contenu;
            $mail->setMessage($message);
            $mail->sendMail();
            
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            
            $erreur .= "<div class='alert alert-success'><strong>Merci</strong> Votre article a bien été soumit! Il sera publié après relecture de notre équipe.</div>";
            
            header ("Refresh: 3;URL=http://$host$uri/");
        }
    } 
    
    $menu = getMenu();
    $top = getTop(); 

    $titre = (isset($_POST["titre"]) ? $_POST["titre"] : "");
    $idArticle = "";
    $date = (isset($_POST["date"]) ? $_POST["date"] : "");
    $auteur = (isset($_POST["auteur"]) ? $_POST["auteur"] : "");
    $heure = (isset($_POST["heure"]) ? $_POST["heure"] : "");

    $contenu = (isset($_POST["contenu"]) ? $_POST["contenu"] : "Contenu de votre article");

    $categories = Categorie::loadAll($mysql);
    $categorie = "<option value=''>Aucune</option>";
    foreach ($categories as $cat) {
        $selected = ((isset($_POST["categorie"]) && ($cat->getIdCategorie() == $_POST["categorie"])) ? "selected" : "");
        $categorie .= "<option value='".$cat->getIdCategorie()."' ".$selected.">".utf8_encode($cat->getNom())."</option>";
    }

    ob_start();
    include 'view/article_proposer_form.php';
    $content = ob_get_clean();
    
    $widget_recent = getRecent();

    ob_start();
    include 'view/widget_social.php';
    $widget_social = ob_get_clean();

    ob_start();
    include 'view/widget_partenaires.php';
    $widget_pub = ob_get_clean();

    include 'layout.php';
}

?>
