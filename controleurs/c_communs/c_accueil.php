<?php
/**
 * Gestion de l'accueil
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

if ($estConnecte) 
    {
     $type= $_SESSION['type'];
    }
   
if ($estConnecte &&  $type=="visiteur")
    {
    include 'vues/v_visiteur/v_accueil.php';
    }
else
    {
    if ($estConnecte &&  $type=="comptable")
    {
    include 'vues/v_comptable/v_accueilComptable.php';
    }
 else {   
    include 'vues/v_communes/v_connexion.php';
 }
}
