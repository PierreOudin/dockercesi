<?php 
include("vues/v_sommaire.php");
if(!isset($_REQUEST['action'])){
     $_REQUEST['action'] = 'listeFicheFrais';
}	 
$action = $_REQUEST['action'];
$message = "";
switch($action){
	case 'listeFicheFrais' : {
		if(isset($_REQUEST['pm']))
		{
			$pm = $_REQUEST['pm'];
			switch($pm) {
				case 'MiseAJourFicheFrais' :
				{
					$commande = $_REQUEST['Commande'];
					$idVisiteur = $_REQUEST['idVisiteur'];
					$idMois = $_REQUEST['mois'];
					switch($commande)
					{
						case 'Mise en Paiement' :
						{
							$sommeTotale = $_REQUEST['montantValide'];
							$pdo->miseEnPaiementFicheFrais($idVisiteur, $idMois, $sommeTotale);
							$message = 'La fiche de frais a bien été mise en paiement.';
							
							break;
						}
						case 'Remboursement' :
						{
							$pdo->miseEnRemboursementFicheFrais($idVisiteur, $idMois);
							$message = 'La fiche de frais a bien été remboursée.';
							break;
						}
						default :
						{
							break;
						}
					}
					break;
				}
					
				
				default : {
					break;
				}
			}
		}
		$lesFicheFrais =$pdo->AfficheFicheFrais();
		include("vues/v_suiviFrais.php");
		break;
	}
	
	case 'affichageDetailFicheFrais' : {
		$idVisiteur = $_REQUEST['idVisiteur'];
		$idMois = $_REQUEST['mois'];
		$etat = $_REQUEST['idEtat'];
		$DetailFicheFrais =$pdo->AfficheFicheFraisDetail($idVisiteur, $idMois);
		include("vues/v_enteteDetailFicheFrais.php");
		$DetailFicheForfait=$pdo->FraisForfaitDetail($idVisiteur, $idMois);
		$sommeMontant = 0;
		foreach($DetailFicheForfait as $uneLigne)
		{
			$sommeMontant += $uneLigne['montantTotal'];
		}
		include("vues/v_ficheFraisForfaitDetail.php");
		$nbJustificatifs =$pdo->getNbjustificatifs($idVisiteur, $idMois);
		$DetailFicheHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur,$idMois);
		$sommeMontantHF = 0;
		foreach($DetailFicheHorsForfait as $uneLigneHF)
		{
			if(substr($uneLigneHF['libelle'], 0, 6) != "REFUSE"){
				$sommeMontantHF += $uneLigneHF['montant'];
			}
			
		}
		$sommeTotale = $sommeMontant + $sommeMontantHF;
		include("vues/v_ficheFraisHorsForfaitDetail.php");
		include("vues/v_totalFrais.php");
		include("vues/v_valideDetailFicheFrais.php");
		break;
	}
}
?>