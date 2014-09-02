<!-- LOGED WIDGET ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div id="loggedProfil">
    <img src="http://www.gravatar.com/avatar/<?php echo $avatar; ?>?s=30&d=mm" alt="avatar" id="avatar" class="avatar"/>
    <h3 class="pseudo"><?php echo $pseudo; ?></h3>
                
    <ul class="nav navbar-nav">
        <li><a href="profil/<?php echo $pseudo; ?>">Mon Profil</a></li>
        <li><a href="artiste/modification">Modifier mon profil</a></li>
        <li><a href="artiste/deconnexion">Déconnexion</a></li>
    </ul>
</div>