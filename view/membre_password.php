<?php echo $erreur; ?>

<div id="formPass">
    <form name="formPassword" id="formPassword" method="post" action="">
        <table class="table table-responsive">
            <tr>
                <td><label for="mail">Adresse e-mail de votre compte</label></td>
                <td>
                    <div class="input-group">
                        <i class="fa fa-envelope"></i>
                        <input name="mail"  id="mail" type="email" value="" placeholder="Adresse e-mail de votre compte" required />
                    </div>
                </td>
            </tr>   
        </table>
    </form>
  
    <br />
    
    <div class="buttons">
        <button class="btn btn-primary" form="formPassword">Réinitialiser</button>
        <button class="btn btn-primary" onclick="window.location.href='.'">Annuler</button>
    </div>
    
    <br />
    <br />
    
</div>
