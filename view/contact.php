<div class="row">
    <div id="map"></div>
    <br />
                        
    <!-- CONTACT INFO 
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <section class="widget col-md-5">
        
        <div class="header clearfix"><h4>Informations</h4></div>
        
        <p class="hyphenate text">LanceA News est une page web sur la culture vidéoludique et geek.</p>
        <p>Nous sommes une des multiples arborescences de l'association LanceA et de sa communauté « multivers » (<a href="http://www.lancea-online.com/" target="_parent">www.lancea-online.com/</a>).</p>
        
        <address>
        <strong>Association LanceA</strong><br>
        6 impasse Bel air<br>
        11000 Carcassonne
        </address>

        <address>
            <i class="fa fa-envelope"></i> admin@lancea-online.com
        </address>

		<div class="hyphenate text">
			<p><strong>L'association LanceA</strong> a pour but de promouvoir et de pratiquer toute activité en relation avec les sports électroniques, la culture internet ou l'informatique de loisir ; elle a un caractère non lucratif et éducatif.</p>
			<p>L'association a pour objet, notamment, l'organisation et la mise en place d'événements durant lesquels les participants pourront venir pratiquer des activité vidéoludiques, d'informer sur les jeux et l'e-sport, de réaliser des activités à caractère pédagogique, ou encore de mettre sur pied des partenariats et de mutualiser les moyens propres à réaliser son objet.</p>
			<p>Elle regroupe des personnes physiques pratiquant ou promouvant ces activités.</p>
		</div>
    </section>

    <!-- MESSAGE FORM 
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <section class="widget message-form col-md-7">

        <div class="header clearfix"><h4>Contactez nous</h4></div>

        <p>
            Pour nous contacter, remplissez ce formulaire :</p>

        <form method="post" action="">
            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" name="name" placeholder="Votre nom..." class="input-light"  required>
            </div>
            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Votre e-mail..." class="input-light"  required>
            </div>
            <div class="textarea">
                <textarea name="comment" placeholder="Votre message..." class="input-light" rows="12"  required></textarea>
            </div>  
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>

    </section>
                    
</div><!--.row-->

<script type="text/javascript">
   +function ($) { "use strict"; 
       
       /*
        * gmaps.js 
        * --------------------------------------------------------------
        */
        new GMaps({
            div: '#map',
            lat: 43.22293279093711, 
            lng: 2.3551739752292633,
            scrollwheel: false
        }).addMarker({
            lat: 43.22293279093711, 
            lng: 2.3551739752292633,
            title: 'LanceA'
        });

   } (jQuery);
</script>