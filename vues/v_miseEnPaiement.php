<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="center-div">
    <form method="post" 
          action="index.php?uc=suiviPaiement&action=miseEnPaiement" 
          role="form">
        <fieldset>
            <input type="hidden" name="lstFiche" value="<?php echo $laFiche ?>">
            <button class="btn btn-success center-button" type="submit">Mettre en paiement</button>
        </fieldset>
    </form>
    
</div>
<br>
