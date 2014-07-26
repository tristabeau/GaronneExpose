<!-- RECENT POSTS WIDGET ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<section class="col-sm-6 col-md-12 widget">
    
    <!-- Tab Menus
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <ul class="nav nav-tabs" id="recent">
        <li class="active"><a href="#popular-aside" data-toggle="tab">Populaire</a></li>
        <li><a href="#comments-aside" data-toggle="tab">Com</a></li>
    </ul>
                                                 
    <!-- Tab Contents
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="tab-content">
        
        <!--Popular-->
        <div class="tab-pane active fade in" id="popular-aside">
            <?php echo $articles_pop; ?>
        </div>
             
        <!--Comments-->
        <div class="tab-pane fade" id="comments-aside">
            <ul class="recent-comments clearfix">
                <?php echo $com_rec; ?>
            </ul>
        </div>
        
    </div>
        
    
</section>