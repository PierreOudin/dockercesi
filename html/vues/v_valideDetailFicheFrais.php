<br/>
<form method="POST" action="index.php?uc=suiviFrais&action=listeFicheFrais&pm=MiseAJourFicheFrais">
	<input type="hidden" id="idVisiteur" name="idVisiteur" value="<?php echo $idVisiteur?>">
	<input type="hidden" id="mois" name="mois" value="<?php echo $idMois?>">
	<input type="hidden" id="montantValide" name="montantValide" value="<?php echo $sommeTotale?>">

	<?php if($etat == 'VA')
	{
		?>
	<input id="Commande" name="Commande" type="submit" value="Mise en Paiement" size="20" />
	<?php 
	}
	elseif ($etat == 'MP')
	{
		?>
	<input id="Commande" name="Commande" type="submit" value="Remboursement" size="20" />
	<?php 
	}
	?>
</form>
<form method="POST"  action="index.php?uc=suiviFrais">
	<input id="Retour" name="Retour" type="submit" value="Retour" size="20" />
</form>