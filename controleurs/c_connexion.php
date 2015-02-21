<?php

/**
 * Contrôleur de connexion de l'application
 
 *Redirige vers les sommaires des visiteurs ou des comptables suivant le profil de l'utilisateur
 * @author Sylvia Amar
 * @package default
 */
session_start();
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else if ($visiteur['type']=='visiteur'){
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			connecter($id,$nom,$prenom);
			include("vues/v_sommaire.php");
			}
//Affiche du sommire propre aux comptables pour les comptables
			else {
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			connecter($id,$nom,$prenom);
			include("vues/v_sommaire_comptable.php");
			}
			break;	
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>