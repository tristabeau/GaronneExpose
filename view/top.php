<!-- TOP NAVIGATION BAR
================================================================ -->
<nav class="navbar navbar-inverse" id="top-nav" role="navigation">
    
    <div class="container">
        
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="top-nav-collapse">
                     
            <?php if(isset($widget_login)) { echo $widget_login; } ?>

            <?php if(isset($widget_loged)) { echo $widget_loged; } ?> 
            
            <?php if(isset($widget_search)) { echo $widget_search; } ?> 
            
        </div><!-- .navbar-collapse -->
        
            
        <div class="alert alert-danger" id="erreurId" style="display:none;">
            <strong>Erreur de connexion</strong> Votre identifiant et/ou votre mot de passe est faux !
        </div>
        
        <div class="alert alert-danger" id="erreurActive" style="display:none;">
            <strong>Erreur de connexion</strong> Votre compte n'est pas encore activé, verifiez votre boite mail !
        </div>
        
    </div><!--.container-->
    
</nav><!--#top-nav-->