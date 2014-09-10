<div class="header clearfix"><h4>Formulaire des catégories</h4></div>

<div class="row">
    <section class="widget col-md-12">
        <form name="formCategorie" id="formCategorie" method="post" action="">
            <table class="table table-responsive">
                <tr>
                    <td><label for="nom">Nom</label></td>
                    <td>
                        <input  name="nom" id="nom" type="text" value="<?php echo $nom; ?>" placeholder="Nom de la catégorie" required />
                        <input  name="idCategorie" type="hidden" value="<?php echo $idCategorie; ?>" />
                    </td>
                </tr>
            </table>
        </form>

        <br />

        <div class="buttons">
            <button class="btn btn-primary" form="formCategorie"><?php echo $action; ?></button>
            <button class="btn btn-primary" onclick="window.location.href='index.php?v=admin&a=categories'">Annuler</button>
        </div>

    </section>
</div>