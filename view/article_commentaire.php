<li id="com<?php echo $c_id; ?>">
    <div itemprop="comment" itemscope itemtype="http://schema.org/UserComments" class="comment-container">
        <img src="http://www.gravatar.com/avatar/<?php echo $c_avatar; ?>?s=75&d=mm" alt="<?php echo $c_pseudo; ?>" class="avatar" />
        <div class="content">
            <p class="comment-meta">
				<span itemprop="creator" itemscope itemtype="http://schema.org/Person">
					<a href="profil/<?php echo $c_pseudo; ?>"><i class="fa fa-user"></i><span itemprop="name"><?php echo $c_pseudo; ?></span></a> &nbsp;
				</span>
				<span itemprop="commentTime">
					<a href="#"><i class="fa fa-clock-o"></i> <?php echo $c_date; ?></a>
				</span>
            </p>   
            <p itemprop="commentText" class="comment" id="ContenuCom<?php echo $c_id; ?>" >
            <?php if ($admin || $auteur) { ?>
               <a href='#' class='comEdit editable-click' data-pk="<?php echo $c_id; ?>"><?php echo $c_contenu; ?></a>
            <?php }  else { ?>
                <?php echo $c_contenu; ?>
            <?php } ?>
            </p> 
            <?php if ($admin || $auteur) { ?>            
            <div class="btn-group">
                <button class="btn btn-primary" onclick="supCom('<?php echo $c_id; ?>', '<?php echo $annee; ?>', '<?php echo $mois; ?>', '<?php echo $jour; ?>', '<?php echo $permalien; ?>');"><i class="fa fa-trash-o fa-fw"></i> Supprimer</button>          
            </div>
            <?php } ?>
        </div>
    </div>
</li>