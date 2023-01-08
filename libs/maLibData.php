<?php
include_once("modele.php");
include_once("maLibUtils.php");

/***********************************************
Ce fichier gère les morceaux de code nécessaire à l'éxécution des requêtes ajax.

L'intégralité du fichier a été écrit par Victor SOULIE
***********************************************/


$fonction = valider("fonction");

sleep(1);

switch($fonction)
{

	case 'ajaxAjouterJoueur' :
		
		//data_ajouterNouveauJoueur
		
		$nomNouveauJoueur = valider("nomNouveauJoueur");
		$prenomNouveauJoueur = $_GET["prenomNouveauJoueur"];
		$numeroTable = $_GET["numeroTable"];
		$idTournoi = $_GET["idTournoi"];
		$numeroPosition = $_GET["numeroPosition"];
		$stack = $_GET["stack"];
			
		uptJoueurTableTournoi($nomNouveauJoueur, $prenomNouveauJoueur , $numeroTable, $idTournoi, $numeroPosition, $stack);
			
	break;	
	
	case 'ajaxChangerStack' :
		
		//data_changerStack
		
		$numeroTable = $_GET["numeroTable"]; 
		$idTournoi = $_GET["idTournoi"];
		$positionJoueur = $_GET["positionJoueurSelectionne"];
		$nouveauStack = $_GET["nouveauStack"];
		//Le stack et le gain peuvent être négatifs.
		
		uptStack($numeroTable, $idTournoi, $positionJoueur, $nouveauStack);
		//modification du stack du joueur d'id [idJoueur], dans le tournoi [idTournoi] à la table [numeroTable]. Le stack est remplacé par [nouveauStack].
		//Cette valeur de nouveau stack [nouveauStack] remplace la valeur du gain dans la table Archivage.
		
		$data = getDataTableJoueur($numeroTable, $idTournoi, $positionJoueur);
		//sélection du stack et de la position du joueurs d'id [idJoueur] de la table [numeroTable] dans le tournoi [idTournoi] : renvoie forcément un tableau à une ligne au plus car id unique.  
		
		echo json_encode($data[0]); 	
		
	break;
	
	case 'ajaxChangerTable' :
	
		//data_changerTable.php
	
		$numeroTable = $_GET["nouveauNumeroTable"];
		$idTournoi = $_GET["idTournoi"];
		
		$data["nombrePlace"] = getNbJoueurTable($numeroTable, $idTournoi);
		$data["nombreJoueur"] = getNbJoueurTablePresent($numeroTable, $idTournoi);
		$data["donneesJoueur"] = getDataTable($numeroTable, $idTournoi);
		//sélection des noms, prenoms, stack et positions des joueurs de la table [numeroTable] dans le tournoi [idTournoi]. 
		
		echo json_encode($data); 
	
	break;
	
	case 'ajaxChangerJoueur' :
		
		//data_selectionnerJoueur
		
		$numeroTable = $_GET["numeroTable"];
		$idTournoi = $_GET["idTournoi"];
		$positionJoueur = $_GET["positionJoueurSelectionne"];
		
		$data["stack"] = "";
		$data["numeroPosition"]	= "";
		
		$temp["donneesJoueur"] = getDataTable($numeroTable, $idTournoi);
		//sélection des noms, prenoms, stack et positions des joueurs de la table [numeroTable] dans le tournoi [idTournoi]. 
		
		foreach($temp["donneesJoueur"] as $ligneTemp)
		{		
			if($ligneTemp["numeroPosition"]==$positionJoueur)
			{
				$data["stack"] = $ligneTemp["stack"];
				$data["numeroPosition"] = $ligneTemp["numeroPosition"];
			}
			//on ne conserve que le stack et la position du joueur qui nous intéresse.
		}
	
		echo json_encode($data);
		
	break;
	
	case 'ajaxSupprimerJoueur' :
	
		//data_supprimerJoueur
		
		$numeroTable = $_GET["numeroTable"]; 
		$idTournoi = $_GET["idTournoi"];
		$positionJoueur = $_GET["positionJoueurSelectionne"];
		$stackFinal = $_GET["stackFinal"];
			
		delJoueurTable($numeroTable, $idTournoi, $positionJoueur, $stackFinal);
		//suppression du joueur de la table donneesJoueur.
		
	break;
	
	case 'ajaxAfficherTables' :
	
		//data_selectionnerNombreTables
		
		$idTournoi = $_GET["idTournoi"];
		$tableSelectionnee = $_GET["tableSelectionnee"];
		
		$data["tableSelectionnee"] = $tableSelectionnee;
		$data["numeros"] = getNbTablesTournoi($idTournoi);
		
		echo json_encode($data); 	
	
	break;
	
	case 'ajaxAjouterJoueur' :
	
		//data_ajouterNouveauJoueur
		
		$nomNouveauJoueur = valider("nomNouveauJoueur");
		$prenomNouveauJoueur = $_GET["prenomNouveauJoueur"];
		$numeroTable = $_GET["numeroTable"];
		$idTournoi = $_GET["idTournoi"];
		$numeroPosition = $_GET["numeroPosition"];
		$stack = $_GET["stack"];
			
		uptJoueurTableTournoi($nomNouveauJoueur, $prenomNouveauJoueur , $numeroTable, $idTournoi, $numeroPosition, $stack);
	
	break;
	
	case 'ajaxVerifierDonneesJoueur' :
	
		//data_verifierNomPrenom
		
		$nom = $_GET["nom"];
		$prenom = $_GET["prenom"];
		$appel = $_GET["appel"];
				
		$data = getNomPrenomStatus($nom, $prenom);
		$data["appel"] = $appel;
		
		echo json_encode($data);
	
	break;
	
	case 'ajaxTrouverJoueur' :
	
		//data_trouverJoueur
		
		$nom = $_GET["nom"];
		$prenom = $_GET["prenom"];
		$idTournoi = $_GET["idTournoi"];
				
		$data = getTrouverJoueurTournoi($nom, $prenom, $idTournoi);
			
		echo json_encode($data);
	
	break;
	
	case 'ajaxModifierDonneesUtilisateur' :
	
		//data_modifierDonneesUtilisateur
	
		$ep_nomUtilisateur = $_GET["ep_nomUtilisateur"]; 
		$ep_prenomUtilisateur = $_GET["ep_prenomUtilisateur"];
		$ep_dateNaissanceUtilisateur = $_GET["ep_dateNaissanceUtilisateur"];
		$ep_genreUtilisateur = $_GET["ep_genreUtilisateur"];
		$ep_mailUtilisateur = $_GET["ep_mailUtilisateur"];
		$ep_paysUtilisateur = $_GET["ep_paysUtilisateur"];
		$ep_loginUtilisateur = $_GET["ep_loginUtilisateur"];
		$ep_passwordUtilisateur = $_GET["ep_passwordUtilisateur"];
		//$idUtilisateur = $_SESSION["idUtilisateur"];
		$idUtilisateur = 1;
		
		//modification du stack du joueur d'id [idJoueur], dans le tournoi [idTournoi] à la table [$numeroTable]. Le stack est remplacé par [nouveauStack].
		$data = uptDataUtilisateur($ep_nomUtilisateur, $ep_prenomUtilisateur, $ep_dateNaissanceUtilisateur, $ep_genreUtilisateur, $ep_mailUtilisateur, $ep_paysUtilisateur, $ep_loginUtilisateur, $ep_passwordUtilisateur, $idUtilisateur);
		
		//sélection de toutes les données du joueur d'id [idUtilisateur]	
		$data = getDataUtilisateur($idUtilisateur);
	
		echo json_encode($data[0]); 
	
	break;
	
}
?>

