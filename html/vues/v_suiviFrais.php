 <div id="contenu">
	<p><?php echo $message;?> </p>
      <h2>Suivi du paiement des fiches de frais</h2>
	  <table class="listeLegere" >
			<tr>
                <th class="visiteur">Visiteur</th>
                <th class="mois">Mois (aaaa-mm)</th>
                <th class='montant'>Montant</th> 
				<th class='dateModification'>Date de modification</th> 
				<th class='Etat'>Etat Fiche</th>
				<th class='Action'>Action</th>
             </tr>
			 <?php    
				foreach($lesFicheFrais as $uneFicheFrais) 
				{

					$idVisiteur = $uneFicheFrais['idVisiteur'];
					$NomPrenom = $uneFicheFrais['NomPrenom'];
					$mois = $uneFicheFrais['mois'];
					$numAnnee =$uneFicheFrais['numAnnee'];
					$numMois =$uneFicheFrais['numMois'];
					$montantValide = $uneFicheFrais['montantValide'];
					$dateModif = $uneFicheFrais['dateModif'];
					$libelleEtat = $uneFicheFrais['libelleEtat'];
					$idEtat = $uneFicheFrais['idEtat'];
			?>		
            <tr>
			<form method="POST"  action="index.php?uc=suiviFrais&action=affichageDetailFicheFrais">
				<input type="hidden" id="idVisiteur" name="idVisiteur" value="<?php echo $idVisiteur; ?>" >
				<input type="hidden" id="mois" name="mois" value="<?php echo $mois; ?>" >
				<input type="hidden" id="idEtat" name="idEtat" value="<?php echo $idEtat; ?>" >
				
                <td> <?php echo $NomPrenom ?></td>
                <td><?php echo $numMois."/".$numAnnee ?></td>
                <td><?php echo $montantValide ?></td>
				<td><?php echo dateAnglaisVersFrancais($dateModif); ?></td>
                <td><?php echo $libelleEtat ?></td>
                <td>
				<input id="Consulter" name="Consulter" type="submit" value="Consulter" size="20" />
				</td>
			</form>
             </tr>
	<?php		 
          }
	?>	  
			</table>