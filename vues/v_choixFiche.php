<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<h2>Suivre le paiement des fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner une fiche : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=suiviPaiement&action=voirFicheFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstFiche" accesskey="n">Fiche à validée et mises en paiement : </label>
                <select id="lstFiche" name="lstFiche" class="form-control">
                    <?php
                    foreach ($lesFiches as $uneFiche) {
                        $id = $uneFiche['id'];
                        $nom = $uneFiche['nom'];
                        $prenom = $uneFiche['prenom'];
                        $mois = $uneFiche['mois'];
                        
                        if ($mois . ' - ' . $id == $ficheASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois . ' - ' . $id ?>">
                                <?php echo 'Fiche de ' . $nom . ' ' . $prenom . ' du ' . $mois ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois . ' - ' . $id ?>">
                                <?php echo 'Fiche de ' . $nom . ' ' . $prenom . ' du ' . $mois ?> </option>
                            <?php
                        }
                    }
                    ?>
                            
                </select>
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">

        </form>
    </div>
</div>
