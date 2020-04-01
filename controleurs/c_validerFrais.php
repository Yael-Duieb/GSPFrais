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
case 'corrigerFicheForfait':
   $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
   $lesVisiteurs= $pdo->getLesVisiteurs();
   $visiteurASelectionner= $idVisiteur;
   $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
   $lesMois = getLesDouzeDerniersMois($mois);
   $moisASelectionner= $leMois;
   $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
   if (lesQteFraisValides($lesFrais)) {
       $pdo->majFraisForfait($idVisiteur, $leMois, $lesFrais);
   } else {
       ajouterErreur('Les valeurs des frais doivent être numériques');
       include 'vues/v_erreurs.php';
   } 
   $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
   $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
   $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $leMois);
   include 'vues/v_afficheFrais.php';
   break;
case 'corrigerFicheHorsForfait':
   $idVisiteur = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_STRING);
   $lesVisiteurs= $pdo->getLesVisiteurs();
   $visiteurASelectionner= $idVisiteur;
   $leMois = filter_input(INPUT_POST, 'idMois', FILTER_SANITIZE_STRING);
   $lesMois = getLesDouzeDerniersMois($mois);
   $moisASelectionner =$leMois;
   $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
   //echo $libelle;
   $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
   //echo $date;
   $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
   //echo $montant;
   valideInfosFrais($date, $libelle, $montant);
   if (nbErreurs() != 0) {
       include 'vues/v_erreurs.php';
   } else {
       $pdo->MajFraisHorsForfait($idVisiteur,$leMois,$libelle,$date,$montant);
          }
   $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
   $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
   $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $leMois);
   include 'vues/v_afficheFrais.php';
   break;
case 'validerFrais':
  $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
  $lesVisiteurs= $pdo->getLesVisiteurs();
  $visiteurASelectionner= $idVisiteur;
  $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
  $lesMois = getLesDouzeDerniersMois($mois);
  $moisASelectionner =$leMois;
  $etat="VA";
  $valideFrais=$pdo->majEtatFicheFrais($idVisiteur, $mois, $etat);
  $montantTotal=$pdo->montantTotal($idVisiteur,$mois);
  $montantTotalHF=$pdo->montantTotalHorsF($idVisiteur,$mois);
  if ($montantTotalHF[0][0]==null){   //si il n y a pas de frais hors forfaits alors $montantTotalHF est=0
      $montantTotalHF=array();
      $montantTotalHF[0]=array(0);
   }
  $pdo->calculMontantValide($idVisiteur,$leMois,$montantTotal,$montantTotalHF);
   ?>
   <div class="alert alert-info" role="alert">
   <p>La fiche a bien été validée!</p>
   </div>
   <?php
  include 'vues/v_listeVisiteursMois.php';
  break;
case 'supprimerFrais':
   $unIdFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
   $ceMois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
   $idVisiteur =filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
   ?>
    <div class="alert alert-info" role="alert">
       <p><h4>Voulez vous modifier ou supprimer le frais?<br></h4>
       <a href="index.php?uc=validerFrais&action=supprimer&idFrais=<?php echo $unIdFrais ?>&mois=<?php echo $ceMois ?>">Supprimer</a>
       ou <a href="index.php?uc=validerFrais&action=reporter&idFrais=<?php echo $unIdFrais ?>&mois=<?php echo $ceMois ?>">Reporter</a></p>
    </div>
   <?php
   break;
case 'supprimer':
   $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
   $pdo->refuserFraisHorsForfait($idFrais);
   ?>
    <div class="alert alert-info" role="alert">
       <p>Ce frais hors forfait a bien été supprimé !</h4>
    </div>
   <?php
   break;
case 'reporter':
   $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
    $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
    $moisSuivant= getMoisSuivant($mois);
    $idVisiteur = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    if ($pdo->estPremierFraisMois($idVisiteur, $moisSuivant)) {
        $pdo->creeNouvellesLignesFrais($idVisiteur,$moisSuivant);
    }
    $moisAReporter=$pdo->reporterFraisHorsForfait($idFrais,$mois);  
   ?>
    <div class="alert alert-info" role="alert">
       <p>Ce frais hors forfait a bien été reporter au mois suivant !</h4>
    </div>
   <?php
   break;
} 