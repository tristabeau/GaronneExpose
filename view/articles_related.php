<div class="col-md-4">
    <article class="article-medium listeArticle">
        <div class="row">
            <div class="col-md-12">
                <div class="frame">
                    <div class="image">
                        <img src="img/articles/<?php echo $image; ?>" alt="<?php echo $titre; ?>">
                        <div class="image-light"></div>
                        <div class="container-link">
                            <div class="link">
                                <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>" class="title"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $annee; ?>/<?php echo $mois; ?>/<?php echo $jour; ?>/<?php echo $permalien; ?>" class="title"><h4><?php echo $titre; ?></h4></a>
                <p class="post-meta">
                    <small><?php echo $date; ?></small> &nbsp;
                </p>
                <img src="img/shadow.png" class="shadow" alt="shadow" />
            </div>
        </div>
    </article>
</div>