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
    include 'vues/v_listeVisiteursMois.php';
    break;
case 'affichageFiche':
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $visiteurASelectionner= $idVisiteur;
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois= $pdo->getLesMoisVA();
    $moisASelectionner= $leMois;
    $lesInfosFicheFrais=$pdo->getLesInfosFicheFrais($idVisiteur, $mois);
   if (!is_array($pdo->getLesInfosFicheFrais($idVisiteur, $mois))) { 
        ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
        include 'vues/v_erreurs.php';
        include 'vues/v_listeVisiteursMois.php';
    } else {
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois); 
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_etatFrais.php';}
    break;
case 'rembourserFrais':
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $visiteurASelectionner= $idVisiteur;
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois= $pdo->getLesMoisVA();
    $moisASelectionner= $leMois;
    $lesInfosFicheFrais=$pdo->getLesInfosFicheFrais($idVisiteur, $mois);
    if (!is_array($pdo->getLesInfosFicheFrais($idVisiteur, $mois))) { 
        ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
        include 'vues/v_erreurs.php';
        include 'vues/v_listeVisiteursMois.php';
    } else {       
    $libEtat = $lesInfosFicheFrais['libEtat'];
    
        if($libEtat== 'Validée et mise en paiement'){
            $rembourser = $pdo->rembourserFiche($idVisiteur,$mois);
        }   
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois); 
    $numAnnee = substr($mois, 0, 4);
    $numMois = substr($mois, 4, 2);
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_etatFrais.php';
    } 
    break;
}