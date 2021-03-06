<?php

/**
 * Vue Mise en paiement
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @author    Stéphanie Viéville
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
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
