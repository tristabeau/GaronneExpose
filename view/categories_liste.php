<div class="header clearfix"><h4>Gestion des catégories</h4></div>

<div class="row">
    <section class="widget col-md-12">
        <form name="formAction" method="post" action="" id="formAction">
            <input type="hidden" name="idCategorie" id="idCategorie" />
        </form>

        <button class="btn btn-primary" form="formAction" formaction="index.php?v=admin&a=newCat">Créer une catégorie</button>

        <br />
        <br />

        <?php echo $table; ?>

    </section>
</div>
