<!-- SOCIALS WIDGET ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<section class="col-sm-6 col-md-12 widget">

    <!-- Widget Header
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="header clearfix"><h4>Partenaires</h4></div>

    <!-- Widget Content
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div id="carousel-partenaire" class="carousel slide social clearfix" data-ride="carousel">

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <?php echo $partenaires; ?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-partenaire" role="button" data-slide="prev">
            <span class="fa fa-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-partenaire" role="button" data-slide="next">
            <span class="fa fa-chevron-right"></span>
        </a>
    </div>

</section>
