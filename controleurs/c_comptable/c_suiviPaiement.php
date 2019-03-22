<?php
/**
 * Gestion du suivi du paiement
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

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// On récupère le nécessaire pour les vues
// On récupère les informations des fiches
$lesFiches = $pdo->getLesFiches();
$laFiche = filter_input(INPUT_POST, 'lstFiche', FILTER_SANITIZE_STRING);
$ficheASelectionner = $laFiche;
$leVisiteur = substr($laFiche, 9, 4);
$leMois = substr($laFiche, 0, 6);
$numAnnee = substr($laFiche, 0, 4);
$numMois = substr($laFiche, 4, 2);
$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
$libEtat = $lesInfosFicheFrais['libEtat'];
$dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
$montantValide = $lesInfosFicheFrais['montantValide'];
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
$lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);
$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];

switch ($action) {
    case 'selectionnerFiche':
        // Permet d'afficher la vue 
        break;
    case 'voirFicheFrais':
        // Permet d'afficher la vue
        break;
    case 'miseEnPaiement':
        // Passe l'etat de la fiche vers "Mise en paiement"
        $pdo->majEtatFicheFrais($leVisiteur, $leMois, 'MP');
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        break;
    
    case 'ficheRemboursée':
        // Passe l'etat de la fiche vers "Remboursée"
        $pdo->majEtatFicheFrais($leVisiteur, $leMois, 'RB');
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        break;
}

// On affiche les vues
// Permet d'afficher la vue tout le temps
include 'vues/v_comptable/v_choixFiche.php';

if ($action != 'selectionnerFiche'){
    include 'vues/v_comptable/v_detailsFiche.php';
    include 'vues/v_comptable/v_miseEnPaiement.php';
    include 'vues/v_comptable/v_remboursement.php';
}