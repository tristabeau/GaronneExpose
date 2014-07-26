<article class="article-large" itemscope itemtype="http://schema.org/WebPage">
    <meta itemprop="name" content="LanceA News">
	<meta itemprop="image" content="http://www.lancea-online.com/images/logo/News%20Logo.png">
	
    <!--frame-->
    <div class="frame thick">
        
        <!--link to original image-->
        <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>" id="lienTitreUne"> 
            <div data-zoom title="<?php echo $titre; ?>">
               <img src="img/articles/<?php echo $image; ?>" alt="<?php echo $titre; ?>">
               <div class="image-light"></div>
            </div>
        </a>
        
        <!--icons-->
        <div class="icons">
            <a href="profil/<?php echo $pseudo; ?>" title="<?php echo $pseudo; ?>"><img src="http://www.gravatar.com/avatar/<?php echo $avatar; ?>?s=120&d=mm" alt="<?php echo $pseudo; ?>" class="avatar" /></a>
            <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>" title="<?php echo $nbVue; ?> Vues"><i class="fa fa-eye"></i><span class="comment"><?php echo $nbVue; ?></span></a>
            <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>#commentaire" title="<?php echo $nbCom; ?> Commentaires"><i class="fa fa-comments"></i><span class="comment"><?php echo $nbCom; ?></span></a>
        </div>
        
        <!--title and date-->
        <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>" class="lien_titre" ><h4><?php echo $titre; ?></h4></a>
            
        <p class="post-meta">
            <small><?php echo $date; ?></small>
            <a href="profil/<?php echo $pseudo; ?>"><span class="fa fa-user"></span> <?php echo $pseudo; ?></a> &nbsp;
            <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>#commentaire"><span class="fa fa-comments"></span> <?php echo $nbCom; ?></a> &nbsp;
            <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>"><span class="fa fa-eye"></span> <?php echo $nbVue; ?></a>
        </p>
    </div>                            
    <img src="img/shadow.png" class="shadow" alt="shadow">

    
    <!--Content-->
    <p class="hyphenate text"><?php echo $contenu; ?></p>
    
    <!--Footer-->
    <div class="footer">
        <ul class="tags">
            <li><a href="article/liste/1/<?php echo $tag; ?>"><?php echo $categorie; ?></a></li>
        </ul>
        <div class="read-more">
            <a class="btn btn-primary btn-sm" href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>">Lire la suite</a> 
        </div>
    </div>
    
</article>      