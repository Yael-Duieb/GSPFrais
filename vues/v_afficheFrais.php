<?php
/**
 * Vue Affichage de Frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Yael Haya Duieb
 */
?>
   
<form action="index.php?uc=validerFrais&action=corrigerFicheForfait"
        method="post" role="form">
    <div class="col-md-4">
            <?php//liste déroulante des visiteurs?>
           
            <div class="form-group" style="display: inline-block">
                <label for="lstVisiteurs" accesskey="n">Choisir le visiteur : </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($id == $visiteurASelectionner) {
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
    </div><br><br><br><br>

    <div class="row">
    <h2 style="color:orange">&nbsp;Valider la fiche de frais</h2>
    <h3>&nbsp;&nbsp;Eléments forfaitisés</h3>
        <div class="col-md-4">  
            <fieldset>
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais"
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5"
                               value="<?php echo $quantite ?>"
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                <button class="btn btn-success" type="edit">Corriger</button>      
                <button class="btn btn-danger" type="reset">Reinitialiser</button>
            </fieldset>
        </div>
    
    </div> 
</form>
<hr>

     
<form action="index.php?uc=validerFrais&action=corrigerFicheHorsForfait"
              method="post" role="form">
    <div class="panel-c panel-info-c">
        <div class="panel-heading-c">Descriptif des éléments hors forfait </div>
        <input type="hidden" id="idVisiteur" name="idVisiteur" size="10" 
               maxlength="5" value="<?php echo $visiteurASelectionner ?>" class="form-control">
        <input type="hidden" id="idMois" name="idMois" size="10" 
               maxlength="5" value="<?php echo $moisASelectionner ?>" class="form-control">
        <table class="table table-bordered table-responsive">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>
            <th class='action'>Action</th>
            <th></th>
        </tr>
        <?php
        
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
            $montant = $unFraisHorsForfait['montant'];
            $id = $unFraisHorsForfait['id']; ?>

            <tr> 
                <td> <input type="text" id="idDate"
                               name="date"
                               value="<?php echo $date ?>"
                               class="form-control"></td>
                 <td> <input type="text" id="idLibelle"
                               name="libelle"
                               value="<?php echo $libelle ?>"
                               class="form-control"></td>
                <td>  <input type="text" id="idMontant"
                               name="montant"
                               value="<?php echo $montant ?>"
                               class="form-control"></td>
                 
                <th><button class="btn btn-success" type="edit">Corriger</button>
                    <button class="btn btn-danger" type="reset">Reinitialiser</button>
                    <a href="index.php?uc=validerFrais&action=supprimerFrais&idFrais=<?php echo $id ?>&mois=<?php echo $unFraisHorsForfait['mois'] ?>"  
                       type="reset" class="btn btn-danger" role="button">Supprimer</a>
            </tr>
            <?php
        }
        ?>
        </table>
    </div>
    <h5>Nombre de justificatifs: <?php echo $nbJustificatifs ?><br><br></h5>
</form>

 <form action="index.php?uc=validerFrais&action=validerFrais"
       method="post" role="form">
   <input type="hidden" name="lstMois" id="idMois" size="10" value="<?php echo $moisASelectionner?>" class="form-control"/>
   <input type="hidden" name="lstVisiteurs" id="idVisiteur" size="10" value="<?php echo $visiteurASelectionner ?>" class="form-control"/>
   <input id="ok" type="submit" value="Valider" class="btn btn-success"
            role="button"></input>
    <button class="btn btn-danger" type="reset">Reinitialiser</button>
    </form>