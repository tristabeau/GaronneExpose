<div>
    <table>
        <tr>
            <td>
                <form name="formAction" method="post" action="" id="formAction">
                    <input  name="nom" id="nom" type="text" value="<?php echo $nom; ?>" placeholder="Nom du groupe" required />
                    <input type="hidden" name="idGroupe" id="idGroupe" />
                </form>
            </td>            
            <td>
                <button class="btn btn-primary" form="formAction" id="butAction">Créer le groupe</button>
                <button class="btn btn-primary" onclick="Annuler()">Annuler</button>
            </td>
        </tr> 
    </table>

    <br />
    <br />

    <?php echo $table; ?>
   
    <br />
    <br />
   
</div>
