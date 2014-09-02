<!-- MENU ================================================================ -->
<nav class="navbar navbar-default" id="main-nav" role="navigation">
    
    <div class="container">
        
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="."><img src="img/logo.png" alt="logo"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="main-nav-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="."><i class="fa fa-home"></i></a></li>
                <li><a href=".">Accueil</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Présentation <b class="caret"></b></a>
                    <ul class="nav dropdown-menu">
                        <li><a href="presentation">Présentation de l'association</a></li>
                        <li><a href="bureau">Le bureau</a></li>
                        <li><a href="">Documents</a></li>
                        <li><a href="">Projet</a></li>
                    </ul>
                </li>
                <li><a href="staff">Galerie des artistes</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Qui parle de nous <b class="caret"></b></a>
                    <ul class="nav dropdown-menu">
                        <li><a href="">Evenement</a></li>
                        <li><a href="">Galerie</a></li>
                        <li><a href="">Revue de presse</a></li>
                    </ul>
                </li>
                <li><a href="partenaires">Partenaires</a></li>
                <li><a href="contact">Contactez nous</a></li>
                <?php if ($admin || $artiste) { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration <b class="caret"></b></a>
                    <ul class="nav dropdown-menu">
                        <?php if ($admin) { ?>
                            <li><a href="index.php?v=admin&a=groupe">Gestion des groupes</a></li>
                            <li><a href="index.php?v=admin&a=membre">Gestion des membres</a></li>
                        <?php } ?>
                        <li><a href="index.php?v=admin&a=categorie">Gestion des catégories</a></li>
                        <li><a href="index.php?v=admin&a=article">Gestion des articles</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div><!-- .navbar-collapse -->
        
    </div><!--.container-->
    
</nav><!--#main-nav-->