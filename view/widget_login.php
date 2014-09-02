<!-- LOGIN WIDGET ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->  
<div>   
    <form class="navbar-form navbar-left" role="navigation" autocomplete="off">
        <input type="text" id="login" name="login" placeholder="Identifiant" onKeyPress="if(event.keyCode == 13) connexion()" />
        <input type="password" id="password" name="password" placeholder="Mot de passe" onKeyPress="if(event.keyCode == 13) connexion()" />
        <button type="button" onclick="connexion();">
            <span class="fa fa-power-off"></span>
            <span class="sr-only">Connexion</span>
        </button>
    </form>  
    
    <ul class="nav navbar-nav">
        <li><a href="artiste/inscription">Inscription</a></li>
        <li><a href="artiste/password">Mot de passe oublié ?</a></li>
    </ul>
    
</div>