     <h2>Frais Forfaitisés du <?php echo $MoisSelect."/".$AnneeSelect;?> pour <?php echo $NomPrenomVisiteur;?></h2>     
      <form method="POST"  action="index.php?uc=valideFrais&action=voirFicheFrais&pm=MiseAJourFicheFraisForfait">
      <div class="corpsForm">
          
          <fieldset>
            <legend>Eléments forfaitisés
            </legend>
			<?php
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
			?>
					<p>
						<label for="idFrais"><?php echo $libelle ?></label>
						<input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" >
					</p>
			
			<?php
				}
			?>
			<input type="hidden" id="lstVisiteurs" name="lstVisiteurs" value="<?php echo $idVisiteur?>">
			<input type="hidden" id="lstMois" name="lstMois" value="<?php echo $idMois?>">

			
			
			
			
           <p> <?php echo $message;?> </p>
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" name="ok" type="submit" value="Modifier" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
  