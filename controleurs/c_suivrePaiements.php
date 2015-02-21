<?php
/**
 * Contr�leur de traitement de consultation des frais pour le comptable

 * @author Sylvia Amar
 * @package default
 */
session_start();
//Affichage du sommaire sp�cifique au comptable
include("vues/v_sommaire_comptable.php");
$action = $_REQUEST['action'];

switch($action){
	case 'voirFichesValidees':{
		//R�cup�ration des donn�es choisies par le comptable et d�claration de ces donn�es en variables de session
		$leVisiteur = 'vide';
		if (isset($_POST['lstVisiteurs'])){
			$leVisiteur = $_POST['lstVisiteurs'];
			$_SESSION['lstVisiteurs']=$leVisiteur;
		}
		//R�cup�re les visiteurs ayant des fiches en attente de remboursement
		$lesVisiteurs=$pdo->getLesVisiteursARembourser();
		$leMois = 'vide';
		if (isset($_POST['lstMois'])){
			$leMois = $_POST['lstMois'];
			$_SESSION['lstMois']=$leMois;
		}
		//R�cup�re les mois en attente de remboursement
		$lesMois=$pdo->getLesMoisDisponiblesARembourser($leVisiteur);
		$visiteurASelectionner = $leVisiteur;
		$moisASelectionner = $leMois;
		//Affichage de la vue permettant le choix du visiteur et du mois
		include("vues/v_listeSuivi.php");
		//r�cup�ration des donn�es correspondantes � la fiche choisie
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($leVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$_SESSION['numAnnee']=$numAnnee;
		$numMois =substr( $leMois,4,2);
		$_SESSION['numMois']=$numMois;
		$idEtat = $lesInfosFicheFrais['idEtat'];
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		//Affichage de la vue permettant la consultation des donn�es
		include("vues/v_etatFrais.php");
		//Affichage du lien de remboursement
		include("vues/v_inviteRembourserFrais.php");
		break;
	}
	case 'mettreEtatRembourse':{
		//R�cup�ration des variables de session
		$sommeTotale=0;
			$leVisiteur ='vide';
			if (isset($_SESSION['lstVisiteurs'])){
				$leVisiteur = $_SESSION['lstVisiteurs'];
			}
			$leMois ='vide';
			if (isset($_SESSION['lstMois'])){
				$leMois = $_SESSION['lstMois'];
			}
			//Mise � jour de la fiche en remboursement
			$pdo->majEtatFicheFrais($leVisiteur,$leMois,"RB");
			echo "<p style='text-align:center;font-weight:bold;font-size:16px;'>".'Cette fiche a bien &eacute;t&eacute; rembours&eacute;e.'."</p>";
			break;
	}
	
}
?>