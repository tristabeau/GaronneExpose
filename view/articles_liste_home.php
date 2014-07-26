<article class="article-medium listeArticle">
    
    <div class="row">
        
        <!--Image-->
        <div class="col-sm-6">
            <div class="frame">
                <div class="image">
                    <img src="img/articles/<?php echo $image; ?>" alt="<?php echo $titre; ?>">
                    <div class="image-light"></div>
                    <div class="container-link">
                        <div class="link">
                            <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>"><i class="fa fa-link fa-flip-horizontal"></i></a>
                            <a href="img/articles/<?php echo $image; ?>" title="<?php echo $titre; ?>"><i class="fa fa-search-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <img src="img/shadow.png" class="shadow" alt="shadow">                                    
        </div>
        
        <!--Content-->
        <div class="col-sm-6">
            <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>" class="title"><h4><?php echo $titre; ?></h4></a>
            <p class="post-meta">
                <small><?php echo $date; ?></small> &nbsp;
                <a href="profil/<?php echo $pseudo; ?>"><span class="fa fa-user"></span> <?php echo $pseudo; ?></a> &nbsp;
                <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>#commentaire"><span class="fa fa-comments"></span> <?php echo $nbCom; ?></a> &nbsp;
                <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>"><span class="fa fa-eye"></span> <?php echo $nbVue; ?></a>
            </p>
            <p class="hyphenate text"><?php echo $contenu; ?></p>                                    
        </div>
        
    </div>
    
    <!--Footer-->
    <div class="footer">
        <ul class="tags">
            <li><a href="article/liste/1/<?php echo $tag; ?>"><?php echo $categorie; ?></a></li>
        </ul> 
        <div class="read-more">
            <a class="btn btn-primary btn-sm" href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>" >Lire la suite</a> 
        </div>
    </div>
    
</article>      