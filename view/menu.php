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
            <a class="navbar-brand" id="logo" href="."><img src="img/logo.png" alt="logo"></a>
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
                        <li><a href="documents">Documents</a></li>
                        <li><a href="projet">Projet</a></li>
                    </ul>
                </li>
                <li><a href="artistes">Galerie des artistes</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Médias <b class="caret"></b></a>
                    <ul class="nav dropdown-menu">
                        <li><a href="evenements">Évènements</a></li>
                        <li><a href="presses">Revue de presse</a></li>
                    </ul>
                </li>
                <li><a href="partenaires">Partenaires</a></li>
                <?php if ($admin || $artiste) { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration <b class="caret"></b></a>
                    <ul class="nav dropdown-menu">
                        <?php if ($admin) { ?>
                            <li><a href="index.php?v=admin&a=groupes">Gestion des groupes</a></li>
                            <li><a href="index.php?v=admin&a=artistes">Gestion des artistes</a></li>
                            <li><a href="index.php?v=admin&a=categories">Gestion des catégories</a></li>
                            <li><a href="index.php?v=admin&a=presses">Gestion des revues de presse</a></li>
                            <li><a href="index.php?v=admin&a=partenaires">Gestion des partenaires</a></li>
                        <?php } ?>
                        <li><a href="index.php?v=admin&a=contenus">Gestion des contenus</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div><!-- .navbar-collapse -->
        
    </div><!--.container-->
    
</nav><!--#main-nav-->