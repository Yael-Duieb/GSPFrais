<?php

/* 
/**
 * Controleur validerFrais
 * PHP Version 7
 * @category  PPE
 * @package   GSB
 * @author    Yael Haya Duieb
 * @author    Beth Sefer
 */
$mois = getMois(date('d/m/Y'));
$moisPrecedent = getMoisPrecedent($mois); 

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (!$uc) {
   $uc = 'validFrais';
}
switch ($action) {
case 'choixVM': 
    $lesVisiteurs = $pdo->getLesVisiteurs(); 
    $lesCles1 = array_keys($lesVisiteurs);
    $visiteurASelectionner = $lesCles1[0];
    $lesMois = getLesDouzeDerniersMois($mois);
    //var_dump($lesMois); //permet d'afficher tt les mois
    $lesCles2 = array_keys($lesMois);
    $moisASelectionner = $lesCles2[0];
    include 'vues/v_listeVisiteursMois.php';
    break;
case 'afficheFrais':
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);  
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);  
    $lesVisiteurs = $pdo->getLesVisiteurs(); 
    $visiteurASelectionner = $idVisiteur;
    $lesMois = getLesDouzeDerniersMois($mois);
    $moisASelectionner = $leMois;
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    include 'vues/v_afficheFrais.php';
    break;
}