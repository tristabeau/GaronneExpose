<div id="profil">
    <img src="http://www.gravatar.com/avatar/<?php echo $avatar; ?>?s=120&d=mm" alt="avatar" class="avatar"/>
    <h1><?php echo $pseudo;  ?></h1>
    <?php if ($isAuteur || $isAdmin) { ?>   
    <h6><?php echo $titre;  ?></h6>
    <?php } ?>    
    <p><?php echo $desc;  ?></p>    
    <ul class="social clearfix">
        <?php if (isset($facebook)) { ?>
        <li><a href="http://www.facebook.com/<?php echo $facebook; ?>" title="Facebook" target="_blank"><span class="sc-md sc-facebook"></span></a></li>
        <?php } ?>
        <?php if (isset($twitter)) { ?>
        <li><a href="http://www.twitter.com/<?php echo $twitter; ?>" title="Twitter" target="_blank"><span class="sc-md sc-twitter"></span></a></li>                                                        
        <?php } ?>
        <?php if (isset($google)) { ?>
        <li><a href="http://google.com/+<?php echo $google; ?>" title="Google+" target="_blank"><span class="sc-md sc-googleplus"></span></a></li> 
        <?php } ?>
        <?php if (isset($site)) { ?>
        <li><a href="http://<?php echo $site; ?>" title="Site" target="_blank"><span class="sc-md sc-dribbble"></span></a></li>
        <?php } ?>
    </ul>
    
    <br /> <br />

</div>
<img src="img/shadow.png" class="shadow" alt="shadow">

<br />

<?php if ($isAuteur || $isAdmin) { ?>

<section class="widget">
    <!--Header-->
    <div class="header clearfix"><h4>Les articles de <?php echo $pseudo;  ?></h4></div>
    <div><?php echo $filtres;  ?></div>
    
    <?php echo $articles_related; ?>

</section>

<?php } ?>