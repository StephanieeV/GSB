<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<hr>
<div class="panel panel-info">
    <div class="panel-heading">Descriptif des éléments hors forfait</div>
    <table class="table table-bordered table-responsive" action="index.php?uc=validerFicheFrais&action=majFraisForfait">
        <thead>
            <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>  
                <th class="montant">Montant</th>  
                <th class="action">&nbsp;</th> 
            </tr>
        </thead>  
        <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id'];
                ?>           
                <tr>
                    <td> <input type="text" id="idFraisHorsForfait" 
                               name="lesFraisHorsForfait[<?php echo $id ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $date ?>" 
                               class="form-control">
                    <td><input type="text" id="idFraisHorsForfait" 
                               name="lesFraisHorsForfait[<?php echo $id ?>]"
                               size="20" maxlength="5" 
                               value="<?php echo $libelle ?>" 
                               class="form-control"></td>
                    <td><input type="text" id="idFraisHorsForfait" 
                               name="lesFraisHorsForfait[<?php echo $id ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $montant ?>" 
                               class="form-control"></td>
                    
                    <td><a href="index.php?uc=validerFicheFrais&action=refuserFraisHorsForfait&idFrais=<?php echo $id ?>&lstVisiteur=<?php echo $leVisiteur ?>&lstMois=<?php echo $leMois ?>" 
                           onclick="return confirm('Voulez-vous vraiment refuser ce frais?');">Refuser ce frais</a></td>
                    <td><a href="index.php?uc=validerFicheFrais&action=reporterFraisHorsForfait&idFrais=<?php echo $id ?>&lstVisiteur=<?php echo $leVisiteur ?>&lstMois=<?php echo $leMois ?>" 
                           onclick="return confirm('Voulez-vous vraiment reporter ce frais?');">Reporter ce frais</a></td> 
   
                </tr>
                <?php
            }
            ?>
        </tbody> 
        
    </table>
    
</div>
<div>
    <label for="nbJustificatifs" accesskey="n">Justificatifs reçus : </label>
    <input type="text" id="nbJustificatifs" name="nbJustificatifs" value="<?php echo $nbJustificatifs ?>" size="4" class="form-control" style="width:50px;"/>
</div>
<br>
<div class="center-div">
    <form method="post" 
          action="index.php?uc=validerFicheFrais&action=validerFiche" 
          role="form">
        <fieldset>
            <input type="hidden" name="lstVisiteur" value="<?php echo $leVisiteur ?>">
            <input type="hidden" name="lstMois" value="<?php echo $leMois ?>">
            <button class="btn btn-success center-button" type="submit" onclick="return confirm('Voulez-vous vraiment valider cette fiche?');">Valider la fiche</button>
            
        </fieldset>
    </form>
</div>
<br>