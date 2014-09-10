<div class="header clearfix"><h4><?php echo $titre; ?></h4></div>

<div class="row">
    <!-- ARTICLE~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="col-md-12">
        <article itemscope itemtype="http://schema.org/Article" class="article-large">

        <!-- MAIN BODY
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

            <!--Image-->
            <div class="mainImage">
                <div class="frame thick clearfix">
                    <a href="img/articles/<?php echo $image; ?>" title="<?php echo $titre; ?>" class="imageDetailArticle">
                       <img src="img/articles/<?php echo $image; ?>" alt="<?php echo $titre; ?>">
                    </a>
                    <p class="post-meta">
                        <small itemprop="datePublished"><?php echo $date; ?></small>
                        <a href="profil/<?php echo $pseudo; ?>"><span class="fa fa-user"></span> <?php echo $pseudo; ?></a> &nbsp;
                        <a href="javascript:;" onclick="document.location.hash='';"><span class="fa fa-eye"></span> <?php echo $nbVue; ?></a>
                    </p>
                </div>
                <img src="img/shadow.png" class="shadow" alt="shadow">
            </div>
            <br />
            <br />
            <!--Content-->
            <span itemprop="description articleBody" class="hyphenate text" ><?php echo $contenu; ?></span>

        </article>

        <!-- POST TAGS
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <section class="post-tags clearfix">
            <h5>Categorie: </h5>
            <ul class="tags">
                <li><a href="javascript:;" onclick="document.location.hash='';"><?php echo $categorie; ?></a></li>
            </ul>
        </section>

        <!-- AUTHOR
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <section class="widget author">

            <!--Header-->
            <div class="header clearfix"><h4>Auteur</h4></div>

            <!--Content-->
            <a href="javascript:;" onclick="document.location.hash='';" class="avatar">
                <img src="<?php echo $avatar; ?>" alt="<?php echo $pseudo; ?>" class="avatar" />
                <div class="image-light"></div>
            </a>
            <a href="profil/<?php echo $pseudo; ?>" class="name"><?php echo $pseudo; ?></a>
            <br />
            <br />
            <ul class="social clearfix">
                <?php if (isset($facebook)) { ?>
                <li><a href="http://www.facebook.com/<?php echo $facebook; ?>" title="Facebook" target="_blank"><span class="sc-md sc-facebook"></span></a></li>
                <?php } ?>
                <?php if (isset($twitter)) { ?>
                <li><a href="http://www.twitter.com/<?php $twitter ?>" title="Twitter" target="_blank"><span class="sc-md sc-twitter"></span></a></li>
                <?php } ?>
                <?php if (isset($google)) { ?>
                <li><a href="http://google.com/+<?php echo $google; ?>" rel="author" title="Google+" target="_blank"><span class="sc-md sc-googleplus"></span></a></li>
                <?php } ?>
                <?php if (isset($site)) { ?>
                <li><a href="http://<?php echo $site; ?>" title="Site" target="_blank"><span class="sc-md sc-dribbble"></span></a></li>
                <?php } ?>
            </ul>

        </section>
    </div>
</div>

<script type="text/javascript">

    +function ($) { "use strict"; 
        $.fn.editableform.buttons = '<button type="submit" class="editable-submit"><i class="fa fa-check"></i></button>';
        $.fn.editableform.buttons += '<button type="button" class="editable-cancel"><i class="fa fa-times"></i></button>';
        $.fn.editable.defaults.mode = 'inline';
        $('.comEdit').editable({
            type : 'textarea',
            url: 'ajax/updateCom.php',
            title: 'Commentaire'
        });
        
    } (jQuery);
</script>                    
