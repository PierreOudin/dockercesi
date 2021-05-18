<h2>Nombre de justificatifs du <?php echo $MoisSelect."/".$AnneeSelect;?> pour <?php echo $NomPrenomVisiteur;?></h2>     
	 
	<form method="POST"  action="index.php?uc=valideFrais&action=voirFicheFrais&pm=MiseAJourNbJustificatifs">
	<div class="corpsForm"> 
      <p>
			<label for="NbJustificatifs">Nombre de Justificatifs : </label>
			<input type="number" id="NbJustificatifs" name="NbJustificatifs" value="<?php echo $NbJustificatifs;?>" min="0">
		</p>
		</div>
			<input type="hidden" id="lstVisiteurs" name="lstVisiteurs" value="<?php echo $idVisiteur?>">
			<input type="hidden" id="lstMois" name="lstMois" value="<?php echo $idMois?>">
		<div class="piedForm">
      <p>
        <input id="Valider" name="Valider" type="submit" value="Valider" size="20" />
		<input id="Réinitialiser" type="reset" value="Réinitialiser" size="20" />
      </p> 
      </div>
	</form>
