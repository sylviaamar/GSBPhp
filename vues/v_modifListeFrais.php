<?php 
/**
 * Vue du formulaire de modification d'une fiche de frais

 * @author Sylvia Amar
 * @package default
 */
?>
<div id="contenu">
<h2>Modifier la fiche de frais du mois <?php echo substr( $_SESSION['lstMois'],4,2)."-".substr( $_SESSION['lstMois'],0,4) ?> de <?php echo $_SESSION['prenom']." ".$_SESSION['nom'] ?></h2>
         
      <form method="POST"  action="index.php?uc=validerFrais&action=modifierFrais">
      <div class="corpsForm">
          
          <fieldset>
          <--Modification des frais forfaitisÈs -->
            <legend>El√©ments forfaitis√©s
            </legend>
			<?php
			if (isset($lesFraisForfait)){
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
			?>
					<p>
						<label for="idFrais"><?php echo $libelle ?></label>
						<input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite ?>" >
					</p>
			
			<?php
				}
			}
			?>
			 </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
      <form method="POST"  action="index.php?uc=validerFrais&action=modifierNbJustificatifs">
      <div class="corpsForm">
<--Modification du nombre de justificatifs -->          
          <fieldset>
            <legend>Nombre de justificatifs re&ccedil;us
            </legend>
					<p>
						<input type="text" name="lesJustificatifs" size="10" maxlength="5" value="<?php if (isset($nbJustificatifs)){ echo $nbJustificatifs;} ?>" >
					</p>
			</fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
<--Modification des frais non forfaitisÈs (report ou suppression)-->
			<table class="listeLegere">
		<caption>Descriptif des &eacute;l&eacute;ments hors forfait -<?php if (isset($nbJustificatifs)){ echo $nbJustificatifs; }?> justificatifs re&ccedil;us -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libell&eacute;</th>
                <th class='montant'>Montant</th>                
             </tr>
        <?php
        if (isset($lesFraisHorsForfait)) {     
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
		  {
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
			$montant = $unFraisHorsForfait['montant'];
			$id = $unFraisHorsForfait['id'];
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <td><a href="index.php?uc=validerFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
				onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
				<td><a href="index.php?uc=validerFrais&action=reporterFiche&idFrais=<?php echo $id ?>" 
				onclick="return confirm('Voulez-vous vraiment reporter ce frais?');">Reporter ce frais</a></td>
             </tr>
        <?php 
          }
        }
		?>
    </table>
			