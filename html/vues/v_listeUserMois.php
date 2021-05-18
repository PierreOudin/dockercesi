 <div id="contenu">
      <h2>Validation des fiches de frais</h2>
      <h3>Utilisateur et Mois à sélectionner : </h3>
      <form action="index.php?uc=valideFrais&action=voirFicheFrais" method="post">
      <div class="corpsForm">
         
      <p>
	 
        <label for="lstVisiteurs" accesskey="v">Visiteur : </label>
        <select id="lstVisiteurs" name="lstVisiteurs">
            <?php
			foreach ($lesVisiteurs as $unVisiteur)
			{
			    $id = $unVisiteur['id'];
				$nom =  $unVisiteur['nom'];
				$prenom =  $unVisiteur['prenom'];
				if($id == $VisiteurASelectionner){
				?>
				<option selected value="<?php echo $id ?>"><?php echo  $nom." ".$prenom ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $id ?>"><?php echo  $nom." ".$prenom ?> </option>
				<?php 
				}
			
			}
           
		   ?>    
            
        </select>
      </p>
	  <p>
	 
        <label for="lstMois" accesskey="m">Mois : </label>
        <select id="lstMois" name="lstMois">
            <?php
			foreach ($lesMois as $unMois)
			{
			    $mois = $unMois['mois'];
				$numAnnee =  $unMois['numAnnee'];
				$numMois =  $unMois['numMois'];
				if($mois == $moisASelectionner){
				?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
			
			}
           
		   ?>    
            
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>