<?php
/**
 * Vue du suivi du paiement des fiches
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Yael Haya Duieb
 */
?>
<h2 style="color:orange">Suivre le paiement des fiches de frais</h2>
<div class="row">
   <div class="col-md-4">
      <form action="index.php?uc=suiviPaiement&action=affichageFiche" method="post" role="form">
           <?php//liste déroulante des visiteurs?>
           
           <div class="form-group" style="display: inline-block">
               <label for="lstVisiteurs" accesskey="n">Choisir le visiteur : </label>
               <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                   <?php
                   foreach ($lesVisiteurs as $unVisiteur) {
                       $id = $unVisiteur['id'];
                       $nom = $unVisiteur['nom'];
                       $prenom = $unVisiteur['prenom'];
                       if ($unVisiteur == $visiteurASelectionner) {
                           ?>
                           <option selected value="<?php echo $id ?>">
                               <?php echo $nom . ' ' . $prenom ?> </option>
                           <?php
                       } else {
                           ?>
                           <option value="<?php echo $id ?>">
                               <?php echo $nom . ' ' . $prenom ?> </option>
                           <?php
                       }
                   }
                   ?>    

               </select>
           </div>
           
           <?php//liste déroulante des mois?>
           
           &nbsp;<div class="form-group" style="display: inline-block">
               <label for="lstMois" accesskey="n">Mois : </label>
               <select id="lstMois" name="lstMois" class="form-control">
                   <?php
                   foreach ($lesMois as $unMois) {
                       $mois = $unMois['mois'];
                       $numAnnee = $unMois['numAnnee'];
                       $numMois = $unMois['numMois'];
                       if ($mois == $moisASelectionner) {
                           ?>
                           <option selected value="<?php echo $mois ?>">
                               <?php echo $numMois . '/' . $numAnnee ?> </option>
                           <?php
                       } else {
                           ?>
                           <option value="<?php echo $mois ?>">
                               <?php echo $numMois . '/' . $numAnnee ?> </option>
                           <?php
                       }
                   }
                   ?>    

               </select>
           </div>
           <input id="ok" type="submit" value="Valider" class="btn btn-success"
                  role="button">
     </form> 
   </div>
</div>




<form action="index.php?uc=suiviPaiement&action=miseEnPaiement" method="post" role="form">
    <hr>
<div class="panel panel-primary">
    <div class="panel-heading">Fiche de frais du mois 
        <?php echo $numMois . '-' . $numAnnee ?> : </div>
    <div class="panel-body">
        <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
        depuis le <?php echo $dateModif ?> <br> 
        <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Eléments forfaitisés</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle']; ?>
                <th> <?php echo htmlspecialchars($libelle) ?></th>
                <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $quantite = $unFraisForfait['quantite']; ?>
                <td class="qteForfait"><?php echo $quantite ?> </td>
                <?php
            }
            ?>
        </tr>
    </table>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Descriptif des éléments hors forfait - 
        <?php echo $nbJustificatifs ?> justificatifs reçus</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>                
        </tr>
        <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
            $montant = $unFraisHorsForfait['montant']; ?>
            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

</form>
 
