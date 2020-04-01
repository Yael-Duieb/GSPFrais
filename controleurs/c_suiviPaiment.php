<?php
/* 
/**
 * Controleur suiviPaiement
 * PHP Version 7
 * @category  PPE
 * @package   GSB
 * @author    Yael Haya Duieb
 */
$mois = getMois(date('d/m/Y'));
$moisPrecedent = getMoisPrecedent($mois); 

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (!$uc) {
   $uc = 'suiviPaiement';
}
switch ($action) {
case 'choixMV': 
    $lesVisiteurs = $pdo->getLesVisiteurs(); 
    $lesCles1 = array_keys($lesVisiteurs);
    $visiteurASelectionner = $lesCles1[0];
    $lesMois = getLesDouzeDerniersMois($mois);
    //var_dump($lesMois); //permet d'afficher tt les mois
    $lesCles2 = array_keys($lesMois);
    $moisASelectionner = $lesCles2[0];
    include 'vues/v_suiviPaiement.php';
    break;
case 'affichageFiche':
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
    $moisASelectionner = $leMois;
    include 'vues/v_suiviPaiement.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_suiviPaiement.php';
    break;

    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $visiteurASelectionner= $idVisiteur;
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois = getLesDouzeDerniersMois($mois);
    $moisASelectionner = $leMois;
    $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
      if (!is_array($pdo->getLesInfosFicheFrais($idVisiteur, $leMois))) {
        ajouterErreur('Pas de fiche de frais pour ce visiteur et pour ce mois');
        include 'vues/v_erreurs.php';
        include 'vues/v_listeVisiteursMois.php';
    } else {
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
    $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $leMois);
    include 'vues/v_afficheFrais.php';
           }  
    break;
case 'miseEnPaiement';
    include 'vues/v_suiviPaiement.php';
}
