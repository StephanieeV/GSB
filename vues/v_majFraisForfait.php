<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="panel panel-info">
    <div class="panel-heading">Eléments forfaitisés</div>
    <form method="post" 
          action="index.php?uc=validerFicheFrais&action=majFraisForfait" 
          role="form">
        <fieldset>
            <input type="hidden" name="lstVisiteur" value="<?php echo $leVisiteur ?>">
            <input type="hidden" name="lstMois" value="<?php echo $leMois ?>">

            <table class="table table-bordered table-responsive">
                <tr>
                    <?php
                    foreach ($lesFraisForfait as $unFraisForfait) {
                        $libelle = $unFraisForfait['libelle'];
                        ?>
                        <th> <?php echo htmlspecialchars($libelle) ?></th>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <?php
                    foreach ($lesFraisForfait as $unFraisForfait) {
                        $idFraisForfait = $unFraisForfait['idfrais'];
                        $quantite = $unFraisForfait['quantite'];
                        ?>
                    <td class="qteForfait">
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFraisForfait ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
            <button class="btn btn-success" type="submit">Corriger</button>
            <button class="btn btn-danger" type="reset">Réinitialiser</button>
            
        </fieldset><br>
    </form>
</div>