<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// On récupère le nécessaire pour la vue v_choixFiche.php
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
        $pdo->majEtatFicheFrais($leVisiteur, $leMois, 'MP');
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        break;
    
    case 'ficheRemboursée':
        $pdo->majEtatFicheFrais($leVisiteur, $leMois, 'RB');
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        break;
}

// On affiche les vues
// Permet d'afficher la vue tout le temps
include 'vues/v_choixFiche.php';

if ($action != 'selectionnerFiche'){
    include 'vues/v_detailsFiche.php';
    include 'vues/v_miseEnPaiement.php';
    include 'vues/v_remboursement.php';
}