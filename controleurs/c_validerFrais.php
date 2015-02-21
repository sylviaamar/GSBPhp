<?php

/**
 * Contr�leur de traitement de modification et de validation des frais pour le comptable

 * @author Sylvia Amar
 * @package default
 */
session_start();
//Affichage du sommaire sp�cifique au comptable
include("vues/v_sommaire_comptable.php");
$action = $_REQUEST['action'];

switch($action){
	case 'voirEtatFrais':{
		//R�cup�ration des donn�es choisies par le comptable et d�claration de ces donn�es en variables de session
		$leVisiteur = 'vide';
		if (isset($_POST['lstVisiteurs'])){
			$leVisiteur = $_POST['lstVisiteurs'];
			$_SESSION['lstVisiteurs']=$leVisiteur;
		}
		$lesVisiteurs=$pdo->getLesVisiteurs();
		$leMois = 'vide';
		if (isset($_POST['lstMois'])){
			$leMois = $_POST['lstMois'];
			$_SESSION['lstMois']=$leMois;
		}
		//R�cup�re les fiches existantes pour le visiteur choisi
		$lesMois=$pdo->getLesMoisDisponibles($leVisiteur);
		$visiteurASelectionner = $leVisiteur;
		$moisASelectionner = $leMois;
		//Affichage de la vue permettant le choix du visiteur et du mois
		include("vues/v_listeVisiteurs.php");
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
		//Affichage de l'�tat de la fiche
		if ($idEtat=='VA'){
			echo "<p style='text-align:center;font-weight:bold;font-size:16px;'>".'Cette fiche a d&eacute;j&agrave; &eacute;t&eacute; valid&eacute;e.'."</p>";
		}
		else if ($idEtat=='RB'){
			echo "<p style='text-align:center;font-weight:bold;font-size:16px;'>".'Les frais correspondants &agrave; cette fiche ont d&eacute;j&agrave; &eacute;t&eacute; rembours&eacute;s.'."</p>";
		}
		else if ($idEtat=='CR'){
			echo "<p style='text-align:center;font-weight:bold;font-size:16px;'>".'La fiche est en cours de saisie.'."</p>";
		}
		else {
		//Si la fiche est clotur�e, affichage du menu de validation
			include("vues/v_optionsValidation.php");
		}
		break;
	}
	case 'modifierFiche':{
		//R�cup�ration des variables de session
		$leVisiteur ='vide';
		if (isset($_SESSION['lstVisiteurs'])){
			$leVisiteur = $_SESSION['lstVisiteurs'];
		}
		$leMois ='vide';
		if (isset($_SESSION['lstMois'])){
			$leMois = $_SESSION['lstMois'];
		}
		//R�cup�ration des donn�es de la fiche correspondante
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($leVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur,$leMois);
		$idEtat = $lesInfosFicheFrais['idEtat'];
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		//Affichage de la vue de modification de la fiche
		include("vues/v_modifListeFrais.php");
		break;
	}
		case 'modifierFrais':{
			//R�cup�ration des variables de session
			$leVisiteur ='vide';
			if (isset($_SESSION['lstVisiteurs'])){
				$leVisiteur = $_SESSION['lstVisiteurs'];
			}
			$leMois ='vide';
			if (isset($_SESSION['lstMois'])){
				$leMois = $_SESSION['lstMois'];
			}
			//Modification de la fiche de frais forfait
			$lesFrais =array ('vide'=>'vide');
			if (isset($lesFrais)){
				$lesFrais = $_REQUEST['lesFrais'];
				if(lesQteFraisValides($lesFrais)){
					$pdo->majFraisForfait($leVisiteur,$leMois,$lesFrais);
					include("vues/v_majFraisForfait.php");
				}
				else{
					ajouterErreur("Les valeurs des frais doivent être numériques");
					include("vues/v_erreurs.php");
				}
			break;
			}
		}
		case 'modifierNbJustificatifs':{
			//R�cup�ration des variables de session
				$leVisiteur ='vide';
				if (isset($_SESSION['lstVisiteurs'])){
					$leVisiteur = $_SESSION['lstVisiteurs'];
				}
				$leMois ='vide';
				if (isset($_SESSION['lstMois'])){
					$leMois = $_SESSION['lstMois'];
				}
				//Modification du nombre de justificatifs
				$lesJustificatifs=0;
				if (isset($lesJustificatifs)){
					$lesJustificatifs = $_POST['lesJustificatifs'];
					if(lesQteFraisValides($lesJustificatifs)){
						$pdo->majNbJustificatifs($leVisiteur, $leMois, $lesJustificatifs);
						include("vues/v_majJustificatifs.php");
					}
					else{
						ajouterErreur("Les valeurs des frais doivent être numériques");
						include("vues/v_erreurs.php");
					}
				}
			break;
			}
		case 'supprimerFrais':{
			//R�cup�ration des variables de session
			$leVisiteur ='vide';
			if (isset($_SESSION['lstVisiteurs'])){
				$leVisiteur = $_SESSION['lstVisiteurs'];
			}
			$leMois ='vide';
			if (isset($_SESSION['lstMois'])){
				$leMois = $_SESSION['lstMois'];
			}
			//Suppression des lignes hors forfait
			$idFrais=0;
			if(isset($idFrais) && isset($_REQUEST['idFrais'])){
				$idFrais = $_REQUEST['idFrais'];
				$pdo->supprimerFraisHorsForfait($idFrais);
			}
			include("vues/v_majSupFrais.php");
			break;
			}
	
		case 'reporterFiche':{
			//R�cup�ration des variables de session
			$leVisiteur ='vide';
			if (isset($_SESSION['lstVisiteurs'])){
				$leVisiteur = $_SESSION['lstVisiteurs'];
			}
			$leMois ='vide';
			if (isset($_SESSION['lstMois'])){
				$leMois = $_SESSION['lstMois'];
			}
			$idFrais=0;
			//Report de la fiche de frais
			if(isset($idFrais) && isset($_REQUEST['idFrais'])){
				$idFrais = $_REQUEST['idFrais'];
				$pdo->reporterFraisHorsForfait($idFrais,$leVisiteur,$leMois);
			}
			include("vues/v_reportFraisHorsForfait.php");
			break;
		}
		case 'validerFiche':{
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
			//Mise � jour de l'�tat de la fiche
			$pdo->majEtatFicheFrais($leVisiteur,$leMois,"VA");
			//Calcul du montant total � rembourser
			$lesMontants = $pdo->getLesMontants();
			$lesFraisForfait = $pdo->getLeNombreFraisForfait($leVisiteur,$leMois);
			for($i=0;$i<=3;$i++){
				$sommeTotale+=($lesMontants[$i][0]*$lesFraisForfait[$i][0]);
			}
			$lesFraisNonForfait = $pdo->getSommeFraisNonForfait($leVisiteur,$leMois);
			$sommeTotale+=$lesFraisNonForfait[0];
			//Mise � jour du montant de la fiche
			$pdo->majMontantValide($leVisiteur,$leMois,$sommeTotale);
			echo "<p style='text-align:center;font-weight:bold;font-size:16px;'>".'Cette fiche a bien &eacute;t&eacute; valid&eacute;e.'."</p>";
			break;
			}
	}
?>