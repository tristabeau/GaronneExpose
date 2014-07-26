<!DOCTYPE html>
<html id="blog-version-1" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#" lang="fr-FR">
    
    <head>
        <title>LanceA News <?php echo $pageTitle; ?></title>
        <!-- <base href="http://37.59.55.9/news/"> -->
        <base href="http://37.59.55.9/news/">
        <!-- <base href="http://localhost/news/">  -->
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="LanceA News, ou des informations de qualité sur le monde jeu vidéo -- d'abord à l'attention de la guilde du même nom, mais aussi du reste de l'univers !">
        <meta name="keywords" lang="fr" content="jeu vidéo, jeux vidéos, jeux vidéo, news, info, infos, information, informations, mmo, mmorpg, rpg, rts, mmorts, fps, mmofps, aventure, point & click, guilde">
		<link rel="canonical" href="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
		
		<meta property="og:title" content="<?php if(isset($titre)) { echo $titre; } ?>" />
		<meta property="og:type" content="article" />
		<meta property="og:image" content="<?php if(isset($image)) { echo "http://news.lancea-online.com/img/articles/".$image; } ?>" />
		<meta property="og:article:section" content="<?php if(isset($categorie)) { echo $categorie; } ?>" />
		<meta property="og:title" content="<?php if(isset($titre)) { echo $titre; } ?>" />
		<meta property="og:description" content="<?php if(isset($contenu)) { echo texte_resume_brut($contenu, 200); } ?>" />
		<meta property="article:published_time" content="<?php if(isset($article)) { echo $article->getDate(); } ?>" />
		<meta property="fb:admins" content="1594058512, 1525703866, 100006566533967, 1219068667" />
		
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:site" content="@LanceA_Online" />
		<meta name="twitter:title" content="<?php if(isset($titre)) { echo $titre; } ?>" />
		<meta name="twitter:description" content="<?php if(isset($contenu)) { echo texte_resume_brut($contenu, 200); } ?>" />
		<meta name="twitter:creator" content="@<?php if(isset($twitter)) { echo $twitter; } ?>" />
		<meta name="twitter:image:src" content="<?php if(isset($image)) { echo "http://news.lancea-online.com/img/articles/".$image; } ?>" />

        <!-- Social page link
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <script type="text/javascript">
			window.___gcfg = {lang: 'fr'};
		
			(function(doc, script) {
				var js, 
					fjs = doc.getElementsByTagName(script)[0],
					frag = doc.createDocumentFragment(),
					add = function(url, id) {
						if (doc.getElementById(id)) {return;}
						js = doc.createElement(script);
						js.src = url;
						id && (js.id = id);
						frag.appendChild( js );
					};
				  
				// Google+ button
				add('https://apis.google.com/js/plusone.js?publisherid=118003626933935879413');
				// Facebook SDK
				add('//connect.facebook.net/fr_FR/all.js#xfbml=1', 'facebook-jssdk');
				// Twitter SDK
				add('//platform.twitter.com/widgets.js', 'twitter-wjs');

				fjs.parentNode.insertBefore(frag, fjs);
			}(document, 'script'));
        </script>

        <!-- Google Analytics
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-48618992-1', 'lancea-online.com');
            ga('send', 'pageview');
        </script>        

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
            
            <?php if(isset($full_width_carousel)) { echo $full_width_carousel; } ?>
            
            <!-- Main Container 
            ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <div class="container">
                
                <div class="row">
                
                    <!-- MAIN CONTENT
                    ======================================================== -->
                    <div id="main-content" class="col-md-8">
                                                    
                        <?php if(isset($breaking_news)) { echo $breaking_news; } ?>

                        <?php if(isset($articles_liste)) { echo $articles_liste; } ?>
                        
                        <?php if(isset($article_detail)) { echo $article_detail; } ?>                          
                        
                        <?php if(isset($content)) { echo $content; } ?>  
                        
                        <?php if(isset($error404)) { echo $error404; } ?>

                    </div><!--#main-content-->
                    
                    <!-- SIDEBAR 
                    ======================================================== -->
                    <aside id="sideBar" class="col-md-4">
                        
                        <div class="row">
                                                        
                            <?php if(isset($widget_social)) { echo $widget_social; } ?>
                            
                            <?php if(isset($widget_recent)) { echo $widget_recent; } ?>
                                                       
                            <?php if(isset($widget_pub)) { echo $widget_pub; } ?>

                        </div><!--.row-->
                        
                    </aside>
                
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
