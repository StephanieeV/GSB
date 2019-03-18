<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// On récupère le visiteur et le mois 
$idVisiteur = $_SESSION['idVisiteur'];
$leVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
$leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
if (!$leVisiteur && !$leMois){
    $leVisiteur = filter_input(INPUT_GET, 'lstVisiteur', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_GET, 'lstMois', FILTER_SANITIZE_STRING);
}
// On récupère le nécessaire pour la vue v_choixVisiteurMois
$lesVisiteurs = $pdo->getListeVisiteurs();
$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
$moisASelectionner = $leMois;
$visiteurASelectionner = $leVisiteur;
// On récupère le nécessaire pour afficher la vue v_infosEtatFicheFrais
$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
$numAnnee = substr($leMois, 0, 4);
$numMois = substr($leMois, 4, 2);
$libEtat = $lesInfosFicheFrais['libEtat'];
$dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
$montantValide = $lesInfosFicheFrais['montantValide'];
// On récupère le nécessaire pour afficher la vue v_actualisationFraisForfait et la vue v_actualisationFraisHorsForfait
$lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];

switch ($action) {
    case 'selectionnerVisiteurEtMois':
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles[0];
        break;
    case 'voirFicheFrais':
        // Affichage des vues en fonction du test en bas de la page
        break;
    case 'majFraisForfait':
        // On met à jour les frais forfait si besoin
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        // Test sur la validité des modifications
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($leVisiteur, $leMois, $lesFrais);
            ajouterSucces('Les modifications ont été prises en compte.');
            include 'vues/v_succes.php';
        } else {
            ajouterErreur('Les valeurs des frais sont invalides. Vérifiez que les valeurs soient numériques.');
            include 'vues/v_erreurs.php';
        }
        $lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);
        break;
     
    case 'refuserFraisHorsForfait':
        // Pour refuser un frais hors forfait et ajouter la mention "Refusé" au debut du libellé du frais
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
        $leFraisHorsForfait = $pdo->getLeFraisHorsForfait($idFrais);             
        if (substr($leFraisHorsForfait['libelle'], 0, 6) != 'REFUSE') {
            $pdo->refuserFraisHorsForfait($idFrais);
        }
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
        break;
    case 'validerFiche':
        // On calcul le montant validé
        $montantValide = 0;
        // Pour les frais forfait:
        foreach ($lesFraisForfait as $unFraisForfait){            
            $montantFrais = $pdo->getMontantFraisForfait($unFraisForfait['idfrais']);
            $montantFrais = floatval($montantFrais) * $unFraisForfait['quantite'];
            $montantValide += $montantFrais;
        }
        // Pour les frais hors forfait:
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait){
            // Test pour savoir si le frais n'est pas refusé                
            if (substr($unFraisHorsForfait['libelle'], 0, 6) != 'REFUSE'){
                $montantValide += floatval($unFraisHorsForfait['montant']);
            }
        }
        // Ajout du montant dans le montant validé
        $pdo->majMontantValide($leVisiteur, $leMois, $montantValide);
        
        // On met à jour l'état de la fiche validée
        $pdo->majEtatFicheFrais($leVisiteur, $leMois, 'VA');
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        $montantValide = $lesInfosFicheFrais['montantValide'];
        
        break;
    case 'reporterFraisHorsForfait':
        // Pour reporter un frais hors forfait
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
        // On prend le mois suivant
        $leMoisSuivant = getMois(date('d/m/Y')); 
        
        // On test si la fiche du mois suivant existe, sinon on l'a crée
        if (!$pdo->existeFicheFrais($leVisiteur, $leMoisSuivant)) {
            $pdo->creeNouvellesLignesFrais($leVisiteur, $leMoisSuivant);
        }
        
        // On ajoute la ligne du frais dans la fiche du mois suivant
        $leFraisReporte = $pdo->getLeFraisHorsForfait($idFrais);
        $pdo->creeNouveauFraisHorsForfait(
        $leFraisReporte['idvisiteur'], $leMoisSuivant, $leFraisReporte['libelle'], 
        dateAnglaisVersFrancais($leFraisReporte['date']), $leFraisReporte['montant']);
        
        // On supprime la ligne dans la fiche actuelle
        $pdo->supprimerFraisHorsForfait($idFrais);
        // On met à jour les frais hors forfait de la fiche actuelle
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
        break;
}

// On affiche les vues
include 'vues/v_choixVisiteurMois.php';
// Test sur l'action 'selectionnerVisiteurEtMois'
if ($action != 'selectionnerVisiteurEtMois'){
    // Test s'il existe une fiche de frais pour le visiteur et le mois sélectionné
    // Si elle existe on affiche les vues nécessaires, si elle n'existe pas on renvoie un message d'erreur
    if ($pdo->existeFicheFrais($leVisiteur, $leMois)) {
            include 'vues/v_infosEtatFicheFrais.php';
            include 'vues/v_majFraisForfait.php';
            include 'vues/v_majFraisHorsForfait.php';
        } else {
            ajouterErreur('Pas de fiche de frais pour le visiteur et le mois sélectionné.');
            include 'vues/v_erreurs.php';
        }
}