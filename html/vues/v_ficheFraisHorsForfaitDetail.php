  	   <br/>
	   <h2> Descriptif des éléments hors forfait - <?php echo $nbJustificatifs ?> justificatifs reçus </h2>
	   <table class="listeLegere" >
			<tr>
                <th class="datehf">Date</th>
                <th class="libellehf">Libellé</th>
				<th class='montanthf'>Montant</th> 
             </tr>
       <?php    
				foreach($DetailFicheHorsForfait as $unDetailFicheHorsForfait) 
				{
					$dateHF = $unDetailFicheHorsForfait['date'];
					$libelleHF = $unDetailFicheHorsForfait['libelle'];
					$montantHF = $unDetailFicheHorsForfait['montant'];
			?>		
            <tr>
				<td> <?php echo $dateHF ?></td>
                <td> <?php echo $libelleHF ?></td>
                <td><?php echo $montantHF ?> €</td>
             </tr>
	<?php		 
          }
	?>	
<tr>
				
                <td><strong> Montant Total</strong></td>
                <td></td>
				<td><strong><?php echo $sommeMontantHF ?> €</strong></td>
             </tr>
			</table>	