<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsb_frais';
      	private static $user='root' ;    		
      	private static $mdp='' ;	
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * Retourne les informations d'un visiteur
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
	public function getInfosVisiteur($login, $mdp){
		$req = "select utilisateur.id as id, utilisateur.nom as nom, utilisateur.prenom as prenom, utilisateur.typeutilisateur as type from utilisateur 
		where utilisateur.login='$login' and utilisateur.mdp='$mdp'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}


/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
		and lignefraishorsforfait.mois = '$mois' ";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}
/**
 * Retourne le nombre de justificatif d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return le nombre entier de justificatifs 
*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['nb'];
	}
	

/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, 
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' 
		order by lignefraisforfait.idfraisforfait";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
	
		public function getLesFraisForfaitCompta($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle,
		lignefraisforfait.quantite as quantite, lignefraisforfait.mois as mois 
		from lignefraisforfait inner join fraisforfait on fraisforfait.id = lignefraisforfait.idfraisforfait 
		inner join fichefrais on lignefraisforfait.idVisiteur = fichefrais.idVisiteur and lignefraisforfait.mois = fichefrais.mois
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' and fichefrais.idEtat='CL' 
		order by lignefraisforfait.idfraisforfait";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
/**
 * Retourne tous les id de la table FraisForfait
 
 * @return un tableau associatif 
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif 
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			PdoGsb::$monPdo->exec($req);
		}
		
	}
	
	public function majFraisHorsForfait($idVisiteur, $mois, $idHF, $libelle, $date, $montant){
			$req = "UPDATE lignefraishorsforfait SET libelle='$libelle',date='$date',montant='$montant' WHERE id ='$idHF' and idVisiteur ='$idVisiteur' and mois = '$mois'";
			PdoGsb::$monPdo->exec($req);
	}
/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = $nbJustificatifs 
		where fichefrais.idvisiteur = '$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);	
	}
	
	public function ValideFicheFrais($idVisiteur, $mois)
	{
		$req = "update fichefrais set dateModif=now(), idEtat = 'VA', montantValide = 0.00
		where fichefrais.idvisiteur = '$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoGsb::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values('$idVisiteur','$mois','$unIdFrais',0)";
			PdoGsb::$monPdo->exec($req);
		 }
	}
	
	public function creeNouvellesLignesFraisReport($idVisiteur,$mois){
		$reqExist = "SELECT COUNT(*) AS NbLigne FROM fichefrais WHERE idVisiteur = '$idVisiteur' and mois = '$mois'";
		$res = PdoGsb::$monPdo->query($reqExist);
		while($laLigne = $res->fetch()){
			$NbLigne = $laLigne["NbLigne"];
		}
		if($NbLigne == 0)
		{
			$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
			values('$idVisiteur','$mois',0,0,now(),'CR')";
			PdoGsb::$monPdo->exec($req);
			$lesIdFrais = $this->getLesIdFrais();
			foreach($lesIdFrais as $uneLigneIdFrais){
				$unIdFrais = $uneLigneIdFrais['idfrais'];
				$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
				values('$idVisiteur','$mois','$unIdFrais',0)";
				PdoGsb::$monPdo->exec($req);
			}
		}
	}
	
	public function ligneHFReport($idVisiteur, $mois, $idFraisHorsForfait)
	{
		$AnneeMoisReport = "";
		$AnneeReport = substr($mois, 0, 4);
		$moisReport = substr($mois,4, 2) + 1;
		if($moisReport == 13)
		{
			$AnneeReport += 1;
			$AnneeMoisReport .= $AnneeReport."01";
		}
		else
		{
			$AnneeMoisReport = $AnneeReport.$moisReport;
		}
		$this->creeNouvellesLignesFraisReport($idVisiteur, $AnneeMoisReport);	
		$req = "UPDATE lignefraishorsforfait SET mois ='$AnneeMoisReport' WHERE id ='$idFraisHorsForfait' and idVisiteur ='$idVisiteur' and mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}	
/**
 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
 * à partir des informations fournies en paramètre
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$mois','$libelle','$dateFr','$montant')";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Supprime le frais hors forfait dont l'id est passé en argument
 
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais
 
 * @param $idVisiteur 
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' 
		order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}
	
		public function getMois(){
		$req = "select fichefrais.mois as mois from  fichefrais order by fichefrais.mois desc";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}
	
	public function getVisiteur(){
		$req = "select utilisateur.id as id, utilisateur.nom as nom, utilisateur.prenom as prenom, utilisateur.typeutilisateur as type from utilisateur 
		where utilisateur.typeutilisateur='visiteur' order by utilisateur.nom ASC";
		$res = PdoGsb::$monPdo->query($req);
		$lesVisi =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$idVisiteur = $laLigne['id'];
			$nomVisiteur = $laLigne['nom'];
			$prenomVisiteur = $laLigne['prenom'];
			$lesVisi["$idVisiteur"]=array(
		     "id"=>"$idVisiteur",
		    "nom"  => "$nomVisiteur",
			"prenom"  => "$prenomVisiteur"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesVisi;
	}
	
	public function getNomPrenomVisiteur($idVisiteur)
	{
		$requete = "select CONCAT(utilisateur.nom, ' ',utilisateur.prenom) AS NomPrenom from utilisateur where utilisateur.id ='$idVisiteur'";
		$res = PdoGsb::$monPdo->query($requete);
		while($laLigne = $res->fetch()){
			$nomprenom = $laLigne["NomPrenom"];
		}
		return $nomprenom;
	}
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 

*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, ficheFrais.nbJustificatifs as nbJustificatifs, 
			ficheFrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}
/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}
	
	public function miseEnPaiementFicheFrais($idVisiteur, $mois, $montantValide) {
		$requete = "update fichefrais set idEtat = 'MP', dateModif = now(), montantValide='$montantValide' where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($requete);
	}
	
	public function miseEnRemboursementFicheFrais($idVisiteur, $mois) {
		$requete = "update fichefrais set idEtat = 'RB', dateModif = now() where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($requete);
	}
	
	public function getEtatFicheFrais($idVisiteur, $mois)
	{
		$req = "select fichefrais.idEtat from fichefrais where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}
	
	public function AfficheFicheFrais()
	{
		$requete = "SELECT utilisateur.id as idVisiteur, CONCAT(utilisateur.nom, ' ', utilisateur.prenom) As NomPrenom, fichefrais.mois as mois, fichefrais.montantValide as montantValide, 
					fichefrais.dateModif as dateModif, etat.libelle as libEtat, fichefrais.idEtat as idEtat FROM `fichefrais` 
					INNER JOIN utilisateur ON utilisateur.id = fichefrais.idVisiteur 
					INNER JOIN etat on etat.id = fichefrais.idEtat 
					where utilisateur.typeutilisateur='visiteur' AND (fichefrais.idEtat = 'VA' OR fichefrais.idEtat = 'MP' OR fichefrais.idEtat = 'RB') 
					ORDER BY NomPrenom ASC, libEtat DESC";
		$res = PdoGsb::$monPdo->query($requete);
		$lesFicheFrais =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$idVisiteur = $laLigne['idVisiteur'];
			$NomPrenom = $laLigne['NomPrenom'];
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$montantValide = $laLigne['montantValide'];
			$dateModif = $laLigne['dateModif'];
			$libelleEtat = $laLigne['libEtat'];
			$idEtat = $laLigne['idEtat'];
			$lesFicheFrais[]=array(
			"idVisiteur" => "$idVisiteur",
		     "NomPrenom"=>"$NomPrenom",
			"mois"  => "$mois",
			"numAnnee"  => "$numAnnee",
			"numMois" => "$numMois",
			"montantValide" => "$montantValide",
			"dateModif" => "$dateModif",
			"libelleEtat" => "$libelleEtat",
			"idEtat" => "$idEtat"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesFicheFrais;
	}
	
	public function AfficheFicheFraisDetail($idVisiteur, $mois)
	{
		$requete = "SELECT utilisateur.id as idVisiteur, CONCAT(utilisateur.nom, ' ', utilisateur.prenom) As NomPrenom, fichefrais.mois as mois, fichefrais.montantValide as montantValide, 
					fichefrais.dateModif as dateModif, etat.libelle as libEtat, fichefrais.idEtat as idEtat FROM `fichefrais` 
					INNER JOIN utilisateur ON utilisateur.id = fichefrais.idVisiteur 
					INNER JOIN etat on etat.id = fichefrais.idEtat 
					where fichefrais.idVisiteur = '$idVisiteur' and ficheFrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($requete);
		$lesFicheFrais =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$idVisiteur = $laLigne['idVisiteur'];
			$NomPrenom = $laLigne['NomPrenom'];
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$montantValide = $laLigne['montantValide'];
			$dateModif = $laLigne['dateModif'];
			$libelleEtat = $laLigne['libEtat'];
			$idEtat = $laLigne['idEtat'];
			$lesFicheFrais[]=array(
			"idVisiteur" => "$idVisiteur",
		     "NomPrenom"=>"$NomPrenom",
			"mois"  => "$mois",
			"numAnnee"  => "$numAnnee",
			"numMois" => "$numMois",
			"montantValide" => "$montantValide",
			"dateModif" => "$dateModif",
			"libelleEtat" => "$libelleEtat",
			"idEtat" => "$idEtat"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesFicheFrais;
	}
	
public function FraisForfaitDetail($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, fraisforfait.montant as montant,
		lignefraisforfait.quantite as quantite, (montant * quantite) as montantTotal from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' 
		order by lignefraisforfait.idfraisforfait";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
}
?>