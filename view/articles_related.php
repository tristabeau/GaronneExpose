<article class="article-small col-md-3 col-sm-6">                                        
    <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>" class="image">
        <img src="img/articles/<?php echo $image; ?>" alt="<?php echo $titre; ?>">
        <div class="image-light"></div>
        <div class="container-link">
            <div class="link">
                <span class="dashicons dashicons-format-gallery"></span>
            </div>
        </div>
    </a>
    <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>" class="title"><h4><?php echo $titre; ?></h4></a>
    <p class="post-meta">
        <small><?php echo $date; ?></small> &nbsp;
        <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>#commentaire"><span class="fa fa-comments"></span> <?php echo $nbCom; ?></a> &nbsp;
    </p>
</article>