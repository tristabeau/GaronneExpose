<div id="filtres">
    <form name="formFiltres" id="formFiltres" method="post" action="" >
        <table>
            <tr>
                <td id="filtreAnnees">
                    <label for="annee">Années : </label>
                    <select name="annee" id="annee" onchange="<?php echo $selectAnnee; ?>">
                        <?php echo $filtreAnnees; ?>
                    </select>    
                </td>
                <td id="filtreMois">
                    <label for="mois">Mois : </label>
                    <select name="mois" id="mois" onchange="<?php echo $selectMois; ?>" <?php if (!isset($_GET["y"]) || ($_GET["y"] == "all")) { ?>disabled<?php } ?>>                        
                        <?php echo $filtreMois; ?>
                    </select>    
                </td>
                <td id="filtreJours">
                    <label for="jours">Jours : </label>
                    <select name="jours" id="jours" <?php if (!isset($_GET["m"]) || ($_GET["m"] == "all")) { ?>disabled<?php } ?>>
                        <?php echo $filtreJours; ?>
                    </select>    
                </td>
                <td class="buttons">
                    <button class="btn btn-primary" onclick="<?php echo $filtrer; ?>">Afficher</button>
                </td>
            </tr>
        </table>
    </form>
</div>