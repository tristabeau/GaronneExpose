<!DOCTYPE html>
<html id="blog-version-1" lang="fr-FR">
    
    <head>
        <title>LanceA News <?php echo $pageTitle; ?></title>
        <!-- <base href="http://37.59.55.9/news/"> -->
        <!-- <base href="http://37.59.55.9/news/"> -->
        <base href="http://localhost/GaronneExpose/">
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" lang="fr" content="">
		<link rel="canonical" href="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />

        <!-- Stylesheet
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <link href="css/style-color-lancea.css" rel="stylesheet">
        <link rel="stylesheet" href="lib/datepicker/themes/classic.css" type="text/css" />
        <link rel="stylesheet" href="lib/datepicker/themes/classic.date.css" type="text/css" />
        <link rel="stylesheet" href="lib/datepicker/themes/classic.time.css" type="text/css" />
        <link rel="stylesheet" href="lib/footable/css/footable.core.min.css" type="text/css" />
        <link rel="stylesheet" href="lib/footable/css/footable.standalone.css" type="text/css" />
        <link rel="stylesheet" href="css/lancea.css" type="text/css" />
        <link rel="stylesheet" href="lib/jeditable/css/bootstrap-editable.css" type="text/css" />
        <link rel="stylesheet" href="lib/ckeditor/contents.css" type="text/css" /> 
        <link rel="stylesheet" href="lib/ckeditor/spoiler.css" type="text/css" /> 
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

        <!-- jQuery 
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/jquery-ui-1.10.4.custom.min.js"></script>
         
        <script src="lib/jeditable/js/bootstrap-editable.min.js"></script>      

        <!-- Google Map API and gmaps.js jQuery plugin
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>        
        <script type="text/javascript" src="js/gmaps.js"></script>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
             ie8.css and ie8.js custom style  and script that needed for IE8.
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!--[if lt IE 9]>
            <link href="css/ie8.css" rel="stylesheet">        
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
            <script src="js/ie8.js"></script>
            <script type="text/javascript" src="lib/datepicker/lagacy.js"></script> 
        <![endif]-->
    </head>
    
    <body>
	
        <!-- HEADER
        =================================================================== --> 
        <header>             
            
            <?php if(isset($top)) { echo $top; } ?>

            <?php if(isset($menu)) { echo $menu; } ?>

        </header><!--header-->       
                
        <!-- CONTENT
        ==================================================================== -->
        <div id="content"> 
        
            <?php if(isset($page_title)) { echo $page_title; } ?>

            <!-- Main Container 
            ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <div class="container">
                
                <div class="row">
                
                    <!-- MAIN CONTENT
                    ======================================================== -->
                    <div id="main-content">

                        <?php if(isset($articles_liste)) { echo $articles_liste; } ?>
                        
                        <?php if(isset($article_detail)) { echo $article_detail; } ?>                          
                        
                        <?php if(isset($content)) { echo $content; } ?>  
                        
                        <?php if(isset($error404)) { echo $error404; } ?>

                    </div><!--#main-content-->

                </div><!--.row-->
                
                <?php if(isset($contact)) { echo $contact; } ?> 
                
            </div><!--.container-->
                        
        </div><!--#content-->
        
        <!-- FOOTER
        ==================================================================== -->
        <footer>
            
            <!-- MAIN FOOTER
            ================================================================ -->
            <div id="footer-main">
                
                <div class="container">

                    <div class="row">


                    </div><!--.row-->

                </div><!--.container-->
                
            </div><!--#footer-main-->
            
            <!-- FOOTER BOTTOM 
            ================================================================ -->
            <div id="footer-bottom">
                
                <div class="container">
                    
                    <p>Copyright &copy; 2013 - <strong>LanceA</strong></p>
                    
                    <ul>
                        <li><a href="article/proposer">Proposer une news</a></li>
						<li><a href="charte">Charte de publication</a></li>
                        <li><a href="contact">Contact</a></li>
                    </ul>
                    
                </div>
                
            </div><!--#footer-bottom-->
            
        </footer><!--footer-->
           
        <!-- Main Script
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <script src="js/fonctions.js"></script>
        <script src="lib/datepicker/picker.js"></script>        
        <script src="lib/datepicker/picker.date.js"></script>        
        <script src="lib/datepicker/picker.time.js"></script>        
        <script src="lib/datepicker/translations/fr_FR.js"></script>        
		<script src="lib/footable/js/footable.js"></script>
		<script src="lib/footable/js/footable.sort.js"></script>
		<script src="lib/footable/js/footable.filter.js"></script>
		<script src="lib/footable/js/footable.paginate.js"></script>
        <script src="lib/ckeditor/ckeditor.js"></script>        
        <script src="lib/ckeditor/spoiler.js"></script>        
        <script src="js/script.js"></script>
        <script src="lib/hyphen/Hyphenator.js" ></script>
        
        <!-- Configurations
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <script type="text/javascript">
            
           +function ($) { "use strict"; 

                new $.CarouselAnimation('#carousel-large');
           
               /*
                * Nivo Lightbox 
                * --------------------------------------------------------------
                */
               $('.image a:has(.fa-search-plus), #main-content .frame > a:not(.lien_titre):not(#lienTitreUne)').nivoLightbox({
                   effect  : 'fadeScale'
               });
               
               /*
                * jQuery Marquee 
                * --------------------------------------------------------------
                */
                $('.breaking-news .content').marquee({   
                    duplicated      : true,                 
                    duration        : 20000,     
                    pauseOnHover    : true
                });
               
               // Don't run on small devices
               if( $(window).width() >= 768 ) {                
        
                    /*
                     * JQUERY ZOOM
                     * ---------------------------------------------------------------------
                     */
                    $('.article-large .frame [data-zoom]').each(function () {
                        $(this).zoom({
                            url: $(this).attr('href')
                        });
                    });

                }      
               
                $('.footable').footable();                
                
                $(window).scroll(function () {//Au scroll dans la fenetre on déclenche la fonction
                    if ($(this).scrollTop() > 30) { //si on a défilé de plus de 150px du haut vers le bas
                        $('#main-nav').addClass("fixNavigation"); 
                    } else {
                        $('#main-nav').removeClass("fixNavigation");
                    }
                });
                
                Hyphenator.config({
                        displaytogglebox : true,
                        minwordlength : 4
                });
                
                Hyphenator.config({displaytogglebox : false});
                Hyphenator.run();

           } (jQuery);
        </script>                        

    </body>
    
</html>
