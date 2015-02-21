<?php 
/**
 *Affichage d'une erreur

 * @author Sylvia Amar
 * @package default
 */
?>
<div class ="erreur">
<ul>
<?php 
foreach($_REQUEST['erreurs'] as $erreur)
	{
      echo "<li>$erreur</li>";
	}
?>
</ul></div>
