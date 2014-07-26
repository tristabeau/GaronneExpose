<?php echo $erreur; ?>
<div class='alert alert-success'>
    <strong>Règles</strong> 
    <ul>
        <li>Lire la <a href="charte">charte</a> de publication</li>
        <li>Mettre une image obligatoirement de grande taille (700x400 minimum)</li>
        <li>Mettre une image obligatoirement d'un poid maximum de 512 Ko</li>
        <li>Pas de copier / coller d'autre site</li>
        <li>Le titre ne doit pas commencer par un chiffre</li>
        <li>Faire une première relecture</li>
    </ul>
</div>
<div>
    <form name="formArticle" id="formArticle" method="post" action="" enctype="multipart/form-data">
        <table class="table table-responsive">
            <tr>
                <td><label for="titre">Titre</label></td>
                <td>
                    <input  name="titre" id="titre" type="text" value="<?php echo $titre; ?>" placeholder="Titre de l'article" required />
                    <input  name="idArticle" type="hidden" value="<?php echo $idArticle; ?>" />
                </td>
            </tr>  
            <tr>
                <td><label for="auteur">Auteur</label></td>
                <td>
                    <input  name="auteur" id="auteur" type="text" value="<?php echo $auteur; ?>" placeholder="Auteur de l'article" required />
                </td>
            </tr> 
            <tr>
                <td><label for="categorie">Catégorie</label></td>
                <td><select name="categorie" required><?php echo $categorie; ?></select></td>
            </tr>   
            <tr>
                <td colspan="2">
                    <div class="myfileupload-buttonbar">
                        <label class="myui-button">
                            <span>Image</span>
                            <input name="image"  id="image" type="file" />
                        </label>
                        <input type="text" class="form-control" readonly="" required>
                    </div>
                </td>
            </tr> 
            <tr>
                <td colspan="2">
                    <textarea cols="80" class="ckeditor" id="contenu" name="contenu" rows="10"><?php echo $contenu; ?></textarea>
                </td>
            </tr> 
        </table>
    </form>
  
    <br />
    
    <div class="buttons">
        <button id="sub" class="btn btn-primary" form="formArticle">Envoyer</button>
        <button class="btn btn-primary" onclick="window.location.href='.'">Annuler</button>
    </div>
    
    <br />
    <br />
    
</div>

<script>
$(document).ready( function() {

    $('#image').change(function (){
        name = $(this).val();
        tab = name.split('\\');
        $(".form-control").val(tab[tab.length - 1]);
    });
    
    $('.ckeditor').ckeditor();

});
</script>