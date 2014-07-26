<?php echo $erreur; ?>

<div id="formProfil">
    <form name="formCategorie" id="formCategorie" method="post" action=""  enctype="multipart/form-data">
        <table class="table table-responsive">
            <tr>
                <td><label for="pseudo">Pseudo</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-user"></i>
                        <input  name="pseudo" id="pseudo" type="text" value="<?php echo $pseudo; ?>" placeholder="Pseudo" <?php echo $optionPseudo; ?> />
                    </div>
                    <input  name="idMembre" type="hidden" value="<?php echo $idMembre; ?>" />
                </td>
            </tr>
            <?php if ($auteur || $admin) { ?>
            <tr>
                <td><label for="titre">Titre</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-users"></i>
                        <input  name="titre" id="titre" type="text" value="<?php echo $titre; ?>" placeholder="Titre" <?php echo $titre; ?> />
                    </div>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td><label for="mail">Adresse e-mail</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-envelope"></i>
                        <input name="mail"  id="mail" type="email" value="<?php echo $mail; ?>" placeholder="Adresse e-mail" required />
                    </div>
                </td>
            </tr>   
            <tr>
                <td><label for="password">Mot de passe</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-lock"></i>
                        <input  name="mdp" id="passwordForm" type="password" value="" placeholder="Mot de passe" <?php echo $mdpReq; ?>/>
                    </div>
                </td>
            </tr> 
            <tr>
                <td><label for="password2">Confirmation du mot de passe</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-lock"></i>
                        <input  name="mdp2" id="password2" type="password" value="" placeholder="Mot de passe" <?php echo $mdpReq; ?>/>
                    </div>
                </td>
            </tr> 
            <tr>
                <td><label for="facebook">Pseudo Facebook</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-facebook"></i>
                        <input name="facebook"  id="facebook" type="text" value="<?php echo $facebook; ?>" placeholder="Pseudo Facebook" />
                    </div>
                </td>
            </tr>    
            <tr>
                <td><label for="twitter">Pseudo Twitter</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-twitter"></i>
                        <input name="twitter"  id="twitter" type="text" value="<?php echo $twitter; ?>" placeholder="Pseudo Twitter" />
                    </div>
                </td>
            </tr>    
            <tr>
                <td><label for="google">Pseudo Google+</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-google-plus"></i>
                        <input name="google"  id="google" type="text" value="<?php echo $google; ?>" placeholder="Pseudo Google+" />
                    </div>                    
                </td>
            </tr>    
            <tr>
                <td><label for="site">Site</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-link"></i>
                        <input name="site"  id="site" type="text" value="<?php echo $site; ?>" placeholder="Adresse du site" />
                    </div>
                </td>
            </tr>               
            <tr>
                <td><label for="site">Avatar (e-mail <a href="http://fr.gravatar.com" target="_blank">gravatar</a>)</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-camera"></i>
                        <input name="avatar"  id="avatar" type="email" value="<?php echo $avatar; ?>" placeholder="E-mail de votre compte gravatar" />
                    </div>
                </td>
            </tr> 
            <tr>
                <td colspan="2">
                    <textarea class="ckeditor" id="desc" name="desc" ><?php echo $desc; ?></textarea>
                </td>
            </tr>   
        </table>
    </form>
  
    <br />
    
    <div class="buttons">
        <button class="btn btn-primary" form="formCategorie"><?php echo $action; ?></button>
        <button class="btn btn-primary" onclick="window.location.href='<?php echo $urlRetour; ?>'">Annuler</button>
    </div>
    
    <br />
    <br />
    
</div>

<script>
    $(document).ready( function() {        
        $('.ckeditor').ckeditor();
    });
</script>