<div class="header clearfix"><h4>Formulaire des contenus</h4></div>

<div class="row">
    <section class="widget col-md-12">
        <?php echo $erreur; ?>
        <div class='alert alert-success'>
            <strong>Règles</strong>
            <ul>
                <li>Mettre une image obligatoirement de grande taille (700x400 minimum)</li>
                <li>Mettre une image obligatoirement d'un poid maximum de 2Mo</li>
                <li>Le titre ne doit pas commencer par un chiffre</li>
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
                        <td><label for="categorie">Catégorie</label></td>
                        <td><select name="categorie" required><?php echo $categorie; ?></select></td>
                    </tr>
                    <tr>
                        <td><label for="auteur">Auteur</label></td>
                        <td><select name="auteur" required><?php echo $auteur; ?></select></td>
                    </tr>
                    <tr>
                        <td><label for="date">Date de publication</label></td>
                        <td>
                            <input name="date" class="datepicker" type="text" data-value="<?php echo $date; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="heure">Heure de publication</label></td>
                        <td>
                            <input name="heure" class="timepicker" type="text" data-value="<?php echo $heure; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="publie">Publié</label></td>
                        <td>
                            <div class="btn-group" data-toggle-name="publie" data-toggle="buttons-radio" >
                                <button type="button" value="0" id="publieNon" class="btn <?php echo $butPubNon; ?>" data-toggle="button">Non</button>
                                <button type="button" value="1" id="publieOui" class="btn <?php echo $butPubOui; ?>" data-toggle="button">Oui</button>
                            </div>
                            <input type="hidden" name="publie"  id="publie" value="<?php echo $publie; ?>" />
                        </td>
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
                    <?php echo $img; ?>
                    <tr>
                        <td colspan="2">
                            <label for="contenu">Contenu de l'article</label>
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
                <button id="sub" class="btn btn-primary" form="formArticle"><?php echo $action; ?></button>
                <button class="btn btn-primary" onclick="window.location.href='index.php?v=admin&a=contenus'">Annuler</button>
            </div>

            <br />
            <br />

        </div>
    </section>
</div>

<script>
window.onload = function() {
    var btnRelease = document.getElementById('sub');                 
    //Find the button set null value to click event and alert will not appear for that specific button
    function setGlobal() {
      window.onbeforeunload = null;
    }
    $(btnRelease).click(setGlobal);

    // Alert will not appear for all links on the page
    $('a').click(function() {
      window.onbeforeunload = null;
    });
    
    window.onbeforeunload = function() {
          return 'Votre article ne sera pas enregistré.';
    };             
};
   
$(document).ready( function() {

    $('#image').change(function (){
        name = $(this).val();
        tab = name.split('\\');
        $(".form-control").val(tab[tab.length - 1]);
    });
    
    $('div.btn-group[data-toggle-name]').each(function() {
        var group = $(this);
        var form = group.parents('form').eq(0);
        var name = group.attr('data-toggle-name');
        var hidden = $('input[name="' + name + '"]', form);
        $('button', group).each(function() {
            var button = $(this);
            button.on('click', function() {
                switch (button.attr("id")) {
                    case "publieNon":
                        $("#publieNon").addClass("btn-danger").addClass("active");
                        $("#publieOui").removeClass("btn-success").removeClass("active");
                        break;
                    case "publieOui":
                        $("#publieNon").removeClass("btn-danger").removeClass("active");
                        $("#publieOui").addClass("btn-success").addClass("active");
                        break;
                }
                hidden.val($(this).val());
            });
            if (button.val() == hidden.val()) {
                button.addClass('active');
            }
        });
    });

    $('.datepicker').pickadate({
        formatSubmit: 'dd/mm/yyyy',
    });

    $('.timepicker').pickatime({
        format: 'HH:i',
        formatLabel: 'HH:i',
        formatSubmit: 'HH:i',
    });
    
    $('.ckeditor').ckeditor();

});
</script>