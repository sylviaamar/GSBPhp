<?php 
/**
 *Vue d'affichage de la liste des visiteurs et des mois dans une liste déroulante

 * @author Sylvia Amar
 * @package default
 */
?>
 <div id="contenu">
      <h2>Validation des fiches de frais</h2>
      <h3>Visiteur m&eacute;dical &agrave; s&eacute;lectionner : </h3>
      <p> Apr&egrave;s validation du choix du visiteur, les mois correspondants &agrave; ses fiches de frais apparaitront dans le menu d&eacute;roulant.<p>
      <form action="index.php?uc=validerFrais&action=voirEtatFrais" method="post">
      <div class="corpsForm">
         
      <p>
      
	 	<label for="lstVisiteurs" accesskey="n">Visiteur : </label>
        <select id="lstVisiteurs" name="lstVisiteurs">
           <?php
 			foreach ($lesVisiteurs as $unVisiteur){
 				$id = $unVisiteur['id'];
				$nom =  $unVisiteur['nom'];
				$_SESSION['nom']=$nom;
				$prenom =  $unVisiteur['prenom'];
				$_SESSION['prenom']=$prenom;
				if(isset($id) && $id == $visiteurASelectionner){
				?>
				<option selected value="<?php echo $id ?>"><?php echo  $nom." ".$prenom ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $id ?>"><?php echo  $nom." ".$prenom ?> </option>
				<?php 
				}
			}
			 ?>
			 </select> 
     	 </p>
      	</div>
      	</br>
      	<div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
      	</br>
 <--Affichage de la liste des mois disponibles pour le visiteur choisi dans une liste déroulante -->      	
      	<div class="corpsForm">
         
      <p>
      
      	<label for="lstMois" accesskey="n">Mois : </label>
        <select id="lstMois" name="lstMois">
            <?php
			foreach ($lesMois as $unMois)
			{
			    $mois = $unMois['mois'];
				$numAnnee =  $unMois['numAnnee'];
				$numMois =  $unMois['numMois'];
				if(isset($mois) && $mois == $moisASelectionner){
				?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
			
			}
           
		   ?>    
            
        </select>
        </p>
        </div>
        
         <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p>
      </form> 
		</div> 

      	