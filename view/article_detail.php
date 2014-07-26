<!-- ARTICLE~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<article itemscope itemtype="http://schema.org/Article" class="article-large">

<!-- MICRO DATA
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<meta itemprop="name" content="<?php echo $titre; ?>">
<meta itemprop="articleSection" content="<?php echo $categorie; ?>">
<meta itemprop="image" content="<?php echo "http://".$_SERVER['HTTP_HOST']."/img/articles/".$image; ?>">
<div itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
	<meta itemprop="name" content="<?php echo $pseudo; ?>">
</div>
<link href="<?php echo "http://news.lancea-online.com/img/articles/".$image; ?>" rel="image_src" />

<!-- MAIN BODY
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->    
    
    <!--Image-->
    <div class="frame thick clearfix">
        <a href="img/articles/<?php echo $image; ?>"  data-zoom title="<?php echo $titre; ?>">
           <img src="img/articles/<?php echo $image; ?>" alt="<?php echo $titre; ?>">
           <div class="image-light"></div>
        </a>
        <div class="icons">
            <a href="profil/<?php echo $pseudo; ?>" title="<?php echo $pseudo; ?>"><img src="http://www.gravatar.com/avatar/<?php echo $avatar; ?>?s=120&d=mm" alt="<?php echo $pseudo; ?>" class="avatar" /></a>
             <a href="javascript:;" onclick="document.location.hash='';" title="<?php echo $nbVue; ?> Vues"><i class="fa fa-eye"></i><span class="comment"><?php echo $nbVue; ?></span></a>
            <a href="javascript:;" onclick="document.location.hash='commentaire';" title="<?php echo $nbCom; ?> Commentaires"><i class="fa fa-comments"></i><span class="comment"><?php echo $nbCom; ?></span></a>
        </div>
        <p class="post-meta">
            <small itemprop="datePublished"><?php echo $date; ?></small>
            <a href="profil/<?php echo $pseudo; ?>"><span class="fa fa-user"></span> <?php echo $pseudo; ?></a> &nbsp;
            <a href="javascript:;" onclick="document.location.hash='commentaire';"><span class="fa fa-comments"></span> <?php echo $nbCom; ?></a> &nbsp;
            <a href="javascript:;" onclick="document.location.hash='';"><span class="fa fa-eye"></span> <?php echo $nbVue; ?></a>
        </p>
    </div>
    <img src="img/shadow.png" class="shadow" alt="shadow">
    
    <!--Content-->
    <span itemprop="description articleBody" class="hyphenate text" ><?php echo $contenu; ?></span>
    
</article>  

<!-- SHARE POST
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->                        
<section class="share-post clearfix">
	<div class="social-container">
		<div id="fb-root"></div>
		<div class="social-button">
			<div class="fb-share-button" data-type="button_count"></div>
		</div>
		<div class="social-button">
			<div class="g-plus" data-action="share" data-annotation="bubble"></div>
		</div>
		<div class="social-button">
			<a href="https://twitter.com/share" class="twitter-share-button" data-lang="fr" data-count="horizontal">Tweeter</a>
		</div>
	</div>
</section>

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
        <img src="http://www.gravatar.com/avatar/<?php echo $avatar; ?>?s=120&d=mm" alt="<?php echo $pseudo; ?>" class="avatar" />
        <div class="image-light"></div>
    </a>
    <a href="profil/<?php echo $pseudo; ?>" class="name"><?php echo $pseudo; ?> - <?php echo $mtitre; ?></a>
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

<!-- COMMENTS 
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<section class="widget" id="commentaire">

    <!--Header-->
    <div class="header clearfix"><h4>Commentaires</h4></div>

    <!--Content-->
    <ol class="post-comments">
        <?php echo $commentaires; ?>
    </ol>

</section>

<!-- COMMENT FORM 
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<section class="widget message-form">

    <!--Header-->
    <div class="header clearfix"><h4>Ecrire un commentaire</h4></div>

    <!--Content-->
    <?php if (isset($_SESSION["idMembre"])) { ?>
    <form method="post" action="">
        <div class="textarea">
            <textarea name="contenu" placeholder="Votre commentaire ..." class="input-light" rows="12"  required></textarea>
        </div>             
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
    <?php } else { ?>
        Connectez-vous pour ajouter un commentaire.
    <?php } ?>

</section>


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
