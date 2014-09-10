<div class="header clearfix"><h4>Inscription</h4></div>

<div class="row">
    <section class="widget col-md-12">
        <?php echo $erreur; ?>


        <div id="inscription">
            <form name="formInscription" id="formInscription" method="post" action="">
                <table class="table table-responsive">
                    <tr>
                        <td><label for="login">Identifiant</label></td>
                        <td>
                            <input  name="login" id="loginIns" type="text" placeholder="Identifiant" required />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="mail">Adresse e-mail</label></td>
                        <td>
                            <input name="mail"  id="mail" type="email" placeholder="Adresse E-mail" required />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="mdp">Mot de passe</label></td>
                        <td>
                            <input name="mdp"  id="passwordIns" type="password" placeholder="Mot de passe" required />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="mdp2">Confirmation du mot de passe</label></td>
                        <td>
                            <input name="mdp2"  id="password2" type="password" placeholder="Mot de passe" required />
                        </td>
                    </tr>
                </table>
            </form>

            <br />

            <div class="buttons">
                <button class="btn btn-primary" form="formInscription" >Inscription</button>
                <button class="btn btn-primary" onclick="window.location.href='.'">Annuler</button>
            </div>

        </div>

    </section>
</div>


