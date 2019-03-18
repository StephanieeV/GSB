<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<br>
<div class="center-div">
    
    <form method="post" 
          action="index.php?uc=suiviPaiement&action=ficheRemboursée" 
          role="form">
        <fieldset>
            <input type="hidden" name="lstFiche" value="<?php echo $laFiche ?>">
            <button class="btn btn-success center-button" id="center-button" type="submit">Remboursement</button>
        </fieldset>
    </form>
</div>
<br>