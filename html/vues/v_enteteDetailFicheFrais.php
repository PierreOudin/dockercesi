<div id="contenu">
<fieldset>
<?php    
		foreach($DetailFicheFrais as $unDetailFicheFrais) 
				{

					$idVisiteur = $unDetailFicheFrais['idVisiteur'];
					$NomPrenom = $unDetailFicheFrais['NomPrenom'];
					$mois = $unDetailFicheFrais['mois'];
					$numAnnee =$unDetailFicheFrais['numAnnee'];
					$numMois =$unDetailFicheFrais['numMois'];
					$montantValide = $unDetailFicheFrais['montantValide'];
					$dateModif = $unDetailFicheFrais['dateModif'];
					$libelleEtat = $unDetailFicheFrais['libelleEtat'];
					$idEtat = $unDetailFicheFrais['idEtat'];
				}
			?>		 
<legend> Fiche de frais du mois <?php echo $numMois."/".$numAnnee; ?></legend>
<p> <strong> Visiteur : </strong> <?php echo $NomPrenom;?> </p>
<p> <strong> Etat : </strong> <?php echo $libelleEtat." depuis le ".dateAnglaisVersFrancais($dateModif);?> </p>
<p> <strong> Montant Validé : </strong> <?php echo $montantValide;?> </p>
</fieldset>