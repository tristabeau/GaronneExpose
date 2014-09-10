<div class="header clearfix"><h4>Gestion des contenus</h4></div>

<div class="row">
    <section class="widget col-md-12">
        <div id="larticle">
            <form name="formAction" method="post" action="" id="formAction">
                <input type="hidden" name="idArticle" id="idArticle" value="" />
            </form>

            <button class="btn btn-primary" id="barticle" form="formAction" formaction="index.php?v=admin&a=newContenu">Créer un contenu</button>

            <div id='search'>
                <label for='filter' id='filterSearch' >Recherche : </label>
                <input id='filter' name='filter' type='text'>
            </div>
        </div>
        <br />
        <br />

        <?php echo $table; ?>

    </section>
</div>
