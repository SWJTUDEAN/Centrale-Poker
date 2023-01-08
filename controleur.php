<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$qs = "";

	if ($action = valider("action"))
	{
		ob_start ();

		echo "Action = '$action' <br />";

		// ATTENTION : le codage des caractères peut poser PB 
		// si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		// Un paramètre action a été soumis, on fait le boulot...
				
		switch($action)
		{
			
			case 'Connexion' :
			
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				{
					
					
					if ($passe = valider("password"))
					{
						// On verifie l'utilisateur, et on crée des variables de session si tout est OK
						// Cf. maLibSecurisation
						$connect = verifUser($login,$passe);
												
						if($connect){

						}else{
							$qs = "?view=seconnecter&msg=" . urlencode("Nom d'utilisateur ou mot de passe incorrecte");
						} 	
					}else{
						$qs = "?view=seconnecter&msg=" . urlencode("Entrée de mot de passe incorrecte");
					}
				}else{
					$qs = "?view=seconnecter&msg=" . urlencode("Entrée de nom d'utilisateur incorrecte");
				}


				// On redirigera vers la page index automatiquement
			break;
			
			case 'Registration' :
												
				if($nomNouvelUtilisateur = valider("nomNouvelUtilisateur"))
				if($prenomNouvelUtilisateur = valider("prenomNouvelUtilisateur"))
				{
					if(verifUniciteBdd($nomNouvelUtilisateur, $prenomNouvelUtilisateur) == false)
					{
						if($dateNaissanceNouvelUtilisateur = valider("dateNaissanceNouvelUtilisateur"))
						if($genreNouvelUtilisateur = valider("genreNouvelUtilisateur"))
						if($mailNouvelUtilisateur = valider("mailNouvelUtilisateur"))
						if($nationaliteNouvelUtilisateur = valider("nationaliteNouvelUtilisateur"))
						if($loginNouvelUtilisateur = valider("loginNouvelUtilisateur"))
						if($passwordNouvelUtilisateur = valider("passwordNouvelUtilisateur"))
						{
							createUtilisateur($nomNouvelUtilisateur, $prenomNouvelUtilisateur, $dateNaissanceNouvelUtilisateur, $genreNouvelUtilisateur, $mailNouvelUtilisateur, $nationaliteNouvelUtilisateur, $loginNouvelUtilisateur, $passwordNouvelUtilisateur);
							
							$qs = "?view=seconnecter";
						}
					}else{
						$qs = "?view=sinscrire&msg=existe";
					}
				}								
			break;
			
			case 'Logout' :
				// On détruit la session
				session_destroy();
				$qs = "?view=seconnecter&msg=" . urlencode("A bientôt !");
			break;

			case 'CreerTournoi' :
				// Vérifiaction des entrées utilisateur
				if ($nom = valider("nom"))
				if ($nbr_tables = valider("nbr_tables"))
				if ($nbr_paticipants = valider("nbr_paticipants"))
				if ($lieu = valider("lieu"))
				if ($buyin = valider("buyin"))
				if ($dateDebut = valider("dateDebut"))
				if ($dateFin = valider("dateFin"))
				if ($cashPrize = valider("cashprize")){
					// On créé le tournoi dans la base de donnée
					$idTournoi = uptTournoi($nom,$buyin,$lieu,$cashPrize,$dateDebut,$dateFin,"non_commence");
					// Creation des tables du tournoi
					for($i=0;$i<$nbr_tables;$i++){
						uptTableTournoi($nbr_paticipants, $i+1, $idTournoi);
					}
					$qs = "?view=gestion&msg='Tournoi créé'";
					break;
				};
				$qs = "?view=gestion&msg='Entrée incorrecte'";
				break;
			
			case 'PasserAdmin' :
				// Vérifiaction des entrées utilisateur
				if ($nom = valider("nom")){
					if ($prenom = valider("prenom")){
						// Changement du status en Admin 
						$changement = passerAdmin($prenom, $nom);
						if($changement){
							$qs = "?view=gestion&msg='$nom $prenom est maintenant admin'";
						}else{
							$qs = "?view=gestion&msg='Ce joueur n'existe pas ou était déjà admin'";
						}
					}else{
						$qs = "?view=gestion&msg='Prenom non valide'";
					} 
				}else {
					$qs = "?view=gestion&msg='Nom non valide'";
				}
				break;

			case 'PasserCroupier' :
				// Vérifiaction des entrées utilisateur
				if ($nom = valider("nom")){
					if ($prenom = valider("prenom")){
						// Changement du status en Croupier 
						$changement = passerCroupier($prenom, $nom);
						if($changement){
							$qs = "?view=gestion&msg='$nom $prenom est maintenant croupier'";
						}else{
							$qs = "?view=gestion&msg='Ce joueur n'existe pas ou était déjà croupier'";
						}
					}else{
						$qs = "?view=gestion&msg='Prenom non valide'";
					} 
				}else {
					$qs = "?view=gestion&msg='Nom non valide'";
				}
				break;

			case 'PasserJoueur' :
				// Vérifiaction des entrées utilisateur
				if ($nom = valider("nom")){
					if ($prenom = valider("prenom")){
						// Changement du status en Joueur 
						$changement = passerJoueur($prenom, $nom);
						if($changement){
							$qs = "?view=gestion&msg='$nom $prenom est maintenant joueur'";
						}else{
							$qs = "?view=gestion&msg='Ce joueur n'existe pas ou était déjà joueur'";
						}
					}else{
						$qs = "?view=gestion&msg='Prenom non valide'";
					} 
				}else {
					$qs = "?view=gestion&msg='Nom non valide'";
				}
				break;

			case 'ChoisirTournoiModifier' :
				// Si on valide le choix du tournoi, on renvoit son nom à la page gestion.php en GET
				if ($nomTournoi = valider("nomTournoiChoisi")){
					$qs = "?view=gestion&msg='Modification du tournoi $nomTournoi'&tournoichoisi=$nomTournoi";
				}else{
					$qs = "?view=gestion";
				}
				break;

			case 'ModifierTournoi' :
				// Vérifiaction des entrées utilisateur
				if ($nom = valider("nomTournoi"))
				if ($lieu = valider("lieu"))
				if ($buyin = valider("buyin"))
				if ($dateDebut = valider("dateDebut"))
				if ($dateFin = valider("dateFin"))
				if ($cashPrize = valider("cashprize")){
					// On modifie le tournoi dans la base de donnée
					$modification = uptModifierTournoi($nom, $buyin, $lieu, $cashPrize, $dateDebut, $dateFin);
					if ($modification) {
						$qs = "?view=gestion&msg='Tournoi $nom modifié'&tournoichoisi=";
					}else{
						$qs = "?view=gestion&msg='Entrée incorrecte ou pas de modification apportée'&tournoichoisi=$nom";
					}
				}
				break;
			
			case 'Appliquer les filtres' :
				// on renvoit le choix des filtres à la page gestion.php en GET
				if ($nationalite = valider("nationalite"))
				if ($genre = valider("genre")){
					$qs = "?view=ranking&fnationalite=$nationalite&fgenre=$genre";
				}
				break;

			case 'Voir ce joueur' :
				// on renvoit le nom et le prénom du joueur choisi à la page gestion.php en GET
				if ($nom_joueur = valider("nom_joueur")){
					if ($prenom_joueur = valider("prenom_joueur")){
						$qs = "?view=ranking&nom_joueur=$nom_joueur&prenom_joueur=$prenom_joueur";
					}
				}else{
					$qs = "?view=ranking";
				}
				
				break;

				
			case 'Choisir le Tournoi' :
				// on renvoit le nom et le status du tournoi choisi à la page gestion.php en GET
				if ($nom_tournoi = valider("nomTournoiChoisiStatus")){
					// Recherche du status du tournoi dans la base de donnée
					$status = getStatusTournoi($nom_tournoi);
					$qs = "?view=gestion&nomTournoiStatus=$nom_tournoi&statusTournoi=$status";
				}else{
					$qs = "?view=gestion";
				}
				break;

			case 'Terminer le Tournoi' :
				if ($nom_tournoi = valider("nomTournoi")){
					// On update la base de donnée
					$upt = uptTournoiStatus($nom_tournoi, "termine");
					if($upt){
						$qs = "?view=gestion&msg='Tournoi $nom_tournoi terminé'";
					}
				}
				break;
			
			case 'Commencer le Tournoi' :
				if ($nom_tournoi = valider("nomTournoi")){
					// On update la base de donnée
					$upt = uptTournoiStatus($nom_tournoi, "en_cours");
					if($upt){
						$qs = "?view=gestion&msg='Tournoi $nom_tournoi en cours'";
					}
				}
				break;
		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments

	

	header("Location:" . $urlBase . $qs);
	//qs doit contenir le symbole '?'

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










