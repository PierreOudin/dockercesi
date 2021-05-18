<br/>
<h2> Elements Forfaitisés </h2>
<table class="listeLegere" >
			<tr>
                <th class="Frais">Frais</th>
                <th class="MontantUnitaire">Montant Unitaire</th>
                <th class='Quantité'>Quantité</th> 
				<th class='MontantTotal'>Montant Total</th> 
             </tr>
			 <?php    
				foreach($DetailFicheForfait as $unDetailFicheForfait) 
				{

					$libelleFrais = $unDetailFicheForfait['libelle'];
					$montantUnitaire = $unDetailFicheForfait['montant'];
					$quantite = $unDetailFicheForfait['quantite'];
					$montantTotal =$unDetailFicheForfait['montantTotal'];
			?>		
            <tr>
				
                <td> <?php echo $libelleFrais ?></td>
                <td><?php echo $montantUnitaire?></td>
                <td><?php echo $quantite ?></td>
				<td><?php echo $montantTotal ?> €</td>
             </tr>
	<?php		 
          }
	?>	  <tr>
				
                <td><strong>Montant Total</strong></td>
                <td></td>
                <td></td>
				<td><strong><?php echo $sommeMontant?> €</strong></td>
             </tr>
			</table>