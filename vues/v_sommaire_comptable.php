<?php 
/**
 * Sommaire pour les comptables

 * @author Sylvia Amar
 * @package default
 */
?>
 <!-- Division pour le sommaire propre aux comptables -->

<div id="menuGauche">
	
<ul id="menuList">
	<li >
	Comptable :<br>
	<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
	</li>
						         
     <!-- Menu propre au comptable -->
      <li class="smenu">
      	<a href="index.php?uc=validerFrais&action=voirEtatFrais" title="Valider les fiches de frais ">Valider les fiches de frais</a>
      </li>
      <li class="smenu">     
         <a href="index.php?uc=suivrePaiements&action=voirFichesValidees" title="Suivi du paiement des fiches de frais">Suivi du paiement des fiches de frais</a>
       </li>
       <li class="smenu">
          <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">D&eacute;connexion</a>
       </li>     
           
         </ul>
        
</div>
