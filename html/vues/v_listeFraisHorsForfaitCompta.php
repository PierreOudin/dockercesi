<table class="listeLegere">
     <h2>Descriptif des éléments hors forfait du <?php echo $MoisSelect."/".$AnneeSelect;?> pour <?php echo $NomPrenomVisiteur;?></h2>     
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant</th> 
				<th class='action'>Action</th> 

             </tr>
        <?php      
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
		  {
			$idHF = $unFraisHorsForfait['id'];
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
			$montant = $unFraisHorsForfait['montant'];
		?>
		      <form method="POST"  action="index.php?uc=valideFrais&action=voirFicheFrais&pm=MiseAJourFicheFraisHorsForfait">

             <tr>
			 <?php if(substr($libelle, 0, 6) == "REFUSE"){
				 ?>
				 <td> <input type="text" id="date" name="date" value="<?php echo $date ?>" disabled></td>
                <td> <input type="text" id="libelle" name="libelle" value="<?php echo $libelle ?>" size="30" disabled></td>
                <td> <input type="text" id="montant" name="montant" value="<?php echo $montant ?>" disabled></td>
				<td>
					<input id="Corriger" name="Commande" type="submit" value="Corriger" size="20" disabled="disabled"/>
					<input id="Réinitialiser" type="reset" value="Réinitialiser" size="20" disabled="disabled"/>	
					<input id="Refuser" name="Commande" type="submit" value="Refuser" size="20" disabled="disabled"/>
					<input id="Reporter" name="Commande" type="submit" value="Reporter" size="20" disabled="disabled" />
				</td>
			 <?php }else{ ?>
				<input type="hidden" id="idHF" name="idHF" value="<?php echo $idHF?>">
                <td> <input type="text" id="date" name="date" value="<?php echo $date ?>"></td>
                <td> <input type="text" id="libelle" name="libelle" value="<?php echo $libelle ?>" size="30"></td>
                <td> <input type="text" id="montant" name="montant" value="<?php echo $montant ?>"></td>
				<input type="hidden" id="lstVisiteurs" name="lstVisiteurs" value="<?php echo $idVisiteur?>">
				<input type="hidden" id="lstMois" name="lstMois" value="<?php echo $idMois?>">
				<td>
					<input id="Corriger" name="Commande" type="submit" value="Corriger" size="20" />
					<input id="Réinitialiser" type="reset" value="Réinitialiser" size="20" />	
					<input id="Refuser" name="Commande" type="submit" value="Refuser" size="20" />
					<input id="Reporter" name="Commande" type="submit" value="Reporter" size="20" />

				</td>
			 <?php } ?>
             </tr>
			 </form>
        <?php 
          }
		?>
    </table>