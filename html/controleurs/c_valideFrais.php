<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
//$idComptable = $_SESSION['idVisiteur'];
switch($action){
	case 'selectionVisiteurMois':{
		if(isset($_REQUEST['pm'])){
			switch($_REQUEST['pm']){
				case "ValidationFicheFrais":{
					$idVisiteur = $_REQUEST['lstVisiteurs'];
					$idMois = $_REQUEST['lstMois'];					
					$pdo->ValideFicheFrais($idVisiteur, $idMois);
					include("vues/v_msgValidation.php");
					break;
				}
				default :
				{
					break;
				}
			}
		}
		$lesVisiteurs=$pdo->getVisiteur();
		$lesClesVisiteur = array_keys($lesVisiteurs);
		$VisiteurASelectionner = $lesClesVisiteur[0];
		$lesMois=$pdo->getMois();
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys($lesMois);
		$moisASelectionner = $lesCles[0];
		include("vues/v_listeUserMois.php");
		break;
	}
	case 'voirFicheFrais': {
		$message = "";
		$idVisiteur = $_REQUEST['lstVisiteurs'];
		$lesVisiteurs=$pdo->getVisiteur();
		$VisiteurASelectionner = $idVisiteur;
		
		$NomPrenomVisiteur =$pdo->getNomPrenomVisiteur($idVisiteur);
		
		$idMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getMois();
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$moisASelectionner = $idMois;
		
		$AnneeSelect =substr( $idMois,0,4);
		$MoisSelect =substr( $idMois,4,2);
		
		include("vues/v_listeUserMois.php");
		
		$pm = "";
		if(isset($_REQUEST['pm'])) {
			$pm = $_REQUEST['pm'];
		}
		switch($pm) {
			case 'MiseAJourFicheFraisForfait': {
		/*$idVisiteur = $_REQUEST['lstVisiteurs'];
		$idMois = $_REQUEST['lstMois'];*/

		$lesFrais = $_REQUEST['lesFrais'];
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$idMois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}
		if(isset($_REQUEST['ok']))
		{
			$message = "La modification des frais forfaitisés a été effectuée.";	
		}
		break;
		}
			case 'MiseAJourFicheFraisHorsForfait': {
				$idHF = $_REQUEST['idHF'];
				$dateHF = dateFrancaisVersAnglais($_REQUEST['date']);
				$libelleHF = $_REQUEST['libelle'];
				$montantHF = $_REQUEST['montant'];
				$commande = $_REQUEST['Commande'];
				switch($commande)
				{
					case 'Corriger' : {
						$pdo->majFraisHorsForfait($idVisiteur, $idMois, $idHF, $libelleHF, $dateHF, $montantHF);
						break;
					}
					case 'Refuser' : {
						$libelleRefus = "REFUSE : ". $libelleHF;
						$pdo->majFraisHorsForfait($idVisiteur, $idMois, $idHF, $libelleRefus, $dateHF, $montantHF);
						break;
					}
					case 'Reporter': {
						$pdo->ligneHFReport($idVisiteur, $idMois, $idHF);
						break;
					}
				}
						
				break;
			}
			case 'MiseAJourNbJustificatifs': {
				$NbJustificatifsMAJ = $_REQUEST['NbJustificatifs'];
				$pdo->majNbJustificatifs($idVisiteur, $idMois, $NbJustificatifsMAJ);
				break;
			}
		default :
		{
			break;
		}
}
		$lesFraisForfait= $pdo->getLesFraisForfaitCompta($idVisiteur,$idMois);
		if(empty($lesFraisForfait))
		{
			ajouterErreur("Pas de fiche de frais en ".$MoisSelect."/".$AnneeSelect);
			include("vues/v_erreurs.php");
		}
		else
		{
			include("vues/v_listeFraisForfaitCompta.php");
			$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$idMois);
			include("vues/v_listeFraisHorsForfaitCompta.php");
			$NbJustificatifs =$pdo->getNbjustificatifs($idVisiteur, $idMois);
			include("vues/v_justificatifs.php");
			include("vues/v_validationFicheFrais.php");
		}
		break;
	}
	/*case 'MiseAJourFicheFraisForfait': {
		$idVisiteur = $_REQUEST['idVisiteur'];
		$idMois = $_REQUEST['idMois'];

		$lesFrais = $_REQUEST['lesFrais'];
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$idMois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}
		break;
	}*/
}
?>