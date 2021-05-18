<form method="POST"  action="index.php?uc=valideFrais&action=selectionVisiteurMois&pm=ValidationFicheFrais">
	<div class="corpsForm"> 
			<input type="hidden" id="lstVisiteurs" name="lstVisiteurs" value="<?php echo $idVisiteur?>">
			<input type="hidden" id="lstMois" name="lstMois" value="<?php echo $idMois?>">
      <p>
        <input id="Valider" name="Valider" type="submit" value="Valider la fiche de frais" size="20" />
      </p> 
	</form>