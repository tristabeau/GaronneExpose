<div>
    <form name="formCategorie" id="formCategorie" method="post" action="">
        <table class="table table-responsive">
            <tr>
                <td><label for="nom">Nom</label></td>
                <td>
                    <input  name="nom" id="nom" type="text" value="<?php echo $nom; ?>" placeholder="Nom de la catégorie" required />
                    <input  name="idCategorie" type="hidden" value="<?php echo $idCategorie; ?>" />
                </td>
            </tr>
            <tr>
                <td><label for="parent">Catégorie parente</label></td>
                <td><select name="parent" ><?php echo $parent; ?></select></td>
            </tr>
        </table>
    </form>
  
    <br />
    
    <div class="buttons">
        <button class="btn btn-primary" form="formCategorie"><?php echo $action; ?></button>
        <button class="btn btn-primary" onclick="window.location.href='index.php?v=admin&a=categorie'">Annuler</button>
    </div>
    
    <br />
    <br />
    
</div>