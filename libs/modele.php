<?php

/***********************************************
Ce fichier gère les fonctions pour envoyer des requêtes SQL.

La majorité du fichier a été écrit par Victor SOULIE. 
Une bonne partie a été écrite par Florian BOULOGNE.
***********************************************/

include_once("maLibSQL.pdo.php");

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL = "SELECT id FROM utilisateur WHERE login='$login' AND password='$passe'";
	return SQLGetChamp($SQL);

}

function statusUser($idUser)
{
	// renvoit le status de l'utilisateur (joueur, croupier ou admin)
	$SQL = "SELECT status FROM utilisateur WHERE id='$idUser'"; 
	return SQLGetChamp($SQL);
}

function getAllUtilisateurs($status = 'joueur')
{
	//sélection de tous les utilisateurs selon leur statut
	$SQL = "SELECT * FROM utilisateur WHERE status = '$status'";
	return parcoursRs(SQLSelect($SQL));
}

function getDataUtilisateur($idUtilisateur)
{
	//sélection de toutes les données du joueur d'id [idUtilisateur]
	$SQL = "SELECT * FROM utilisateur WHERE id = '$idUtilisateur'";
	return parcoursRs(SQLSelect($SQL));
}

function uptDataUtilisateur($ep_nomUtilisateur, $ep_prenomUtilisateur, $ep_dateNaissanceUtilisateur, $ep_genreUtilisateur, $ep_mailUtilisateur, $ep_paysUtilisateur, $ep_loginUtilisateur, $ep_passwordUtilisateur, $idUtilisateur)
{
	//Mise à jour des données de l'utilisateur d'id [idUtilisateur];
	$SQL = "UPDATE utilisateur SET nomUtilisateur = '$ep_nomUtilisateur', prenomUtilisateur = '$ep_prenomUtilisateur', dateNaissance = '$ep_dateNaissanceUtilisateur', genre = '$ep_genreUtilisateur', mail = '$ep_mailUtilisateur', nationalite = '$ep_paysUtilisateur', login = '$ep_loginUtilisateur', password = '$ep_passwordUtilisateur' WHERE id = '$idUtilisateur'";
	SQLUpdate($SQL);
}

function getJoueurTournoi($nomTournoi)
{
	//sélection de tous les joueurs du tournoi [nomTournoi]
	$SQL = "SELECT nomUtilisateur FROM utilisateur WHERE id IN (SELECT idUtilisateur FROM archivage WHERE idTournoi =  (SELECT id FROM tournoi WHERE nomTournoi = '$nomTournoi'))";
	return parcoursRs(SQLSelect($SQL));
}

function getTournoiJoueur($prenom, $nom)
{
	//sélection de tous les tournois auxquels le jour [prenom],[nom] a participé
	$SQL = "SELECT nomTournoi FROM tournoi WHERE id IN (SELECT idTournoi FROM archivage WHERE idUtilisateur = (SELECT id FROM utilisateur WHERE prenomUtilisateur = '$prenom' AND nomUtilisateur = '$nom'))";
	return parcoursRs(SQLSelect($SQL));
}

function getDataTournoiJoueur($prenom, $nom)
{
	//sélection des tables et des tournois en cours auxquels participe le joueur [prenom], [nom]
	$SQL = "SELECT numeroTableTournoi, nomTournoi FROM tournoi JOIN tableTournoi ON tournoi.id = tableTournoi.idTournoi JOIN donneesJoueur ON tableTournoi.id = donneesJoueur.idTableTournoi JOIN utilisateur ON utilisateur.id = donneesJoueur.idUtilisateur WHERE tournoi.status = 'en_cours' AND prenomUtilisateur = '$prenom' AND nomUtilisateur = '$nom'";
	return parcoursRS(SQLSelect($SQL));
}

function getTableJoueur($prenom, $nom, $nomTournoi)
{
	//sélection de la table, de la position à cette table et du stack du joueur [prenom], [nom] au tournoi [nomTournoi]
	$SQL = "SELECT numeroTableTournoi, numeroPosition, stack FROM donneesJoueur JOIN tableTournoi ON tableTournoi.id = donneesJoueur.idTableTournoi JOIN tournoi on tournoi.id = tableTournoi.idTournoi WHERE nomTournoi = '$nomTournoi' AND donneesJoueur.idUtilisateur = (SELECT id from utilisateur WHERE prenomUtilisateur = '$prenom' AND nomUtilisateur = '$nom')";
	return parcoursRs(SQLSelect($SQL));
	
}

function getStackJoueur($prenom, $nom, $nomTournoi)
{
	//sélection de la du stack du joueur [prenom], [nom] au tournoi [nomTournoi]
	$SQL = "SELECT stack FROM donneesJoueur JOIN tableTournoi ON tableTournoi.id = donneesJoueur.idTableTournoi JOIN tournoi on tournoi.id = tableTournoi.idTournoi WHERE nomTournoi = '$nomTournoi' AND donneesJoueur.idUtilisateur = (SELECT id from utilisateur WHERE prenomUtilisateur = '$prenom' AND nomUtilisateur = '$nom')";
	return SQLGetChamp($SQL);
}

function createTournoi($nomTournoi, $buyIn, $lieu, $cashPrize, $dateDebut, $dateFin, $status)
{
	//création d'un tournoi : [nomTournoi], [buyIn], [cashPrize], [dateDebut], [dateFin], [status]
	$SQL = "INSERT INTO tournoi (nomTournoi, buyIn, lieu, cashPrize, dateDebut, dateFin, status) VALUES ('$nomTournoi', '$buyIn', '$lieu', '$cashPrize', '$dateDebut', '$dateFin', '$status')";
	SQLInsert($SQL);
}

function deleteTournoi($nomTournoi)
{
	//suppression du tournoi [nomTournoi]
	$SQL = "DELETE FROM tournoi WHERE nomTournoi = '$nomTournoi'"; 
	SQLDelete($SQL);
}

function getDataTable($numeroTable, $idTournoi)
{
	//sélection des noms, prenoms, stack et positions des joueurs de la table [numeroTable] dans le tournoi [idTournoi]. 
	$SQL = "SELECT numeroPosition, stack, nomUtilisateur, prenomUtilisateur FROM donneesJoueur JOIN tableTournoi ON tableTournoi.id = donneesJoueur.idTableTournoi JOIN utilisateur ON utilisateur.id = donneesJoueur.idUtilisateur WHERE numeroTableTournoi = '$numeroTable' AND idTournoi = '$idTournoi' ORDER BY numeroPosition";
	return parcoursRs(SQLSelect($SQL));
	//le "ORDER BY numeroPosition" est très important : il garantit la bonne récupération des données pour les tournois en live.
}

function getDataTableJoueur($numeroTable, $idTournoi, $numeroPosition)
{
	//sélection du stack et de la position du joueur de la table [numeroTable] dans le tournoi [idTournoi], à la position [numeroPosition]. 
	$SQL = "SELECT numeroPosition, stack, nomUtilisateur FROM donneesJoueur JOIN tableTournoi ON tableTournoi.id = donneesJoueur.idTableTournoi JOIN utilisateur ON utilisateur.id = donneesJoueur.idUtilisateur WHERE numeroTableTournoi = '$numeroTable' AND idTournoi = '$idTournoi' AND numeroPosition = '$numeroPosition'";
	return parcoursRs(SQLSelect($SQL));
}

function uptStack($numeroTable, $idTournoi, $numeroPosition, $nouveauStack)
{
	//modification du stack du joueur dans le tournoi [idTournoi], à la table [$numeroTable] et à la position [numeroPosition]. Le stack est remplacé par [nouveauStack].
	$SQL = "UPDATE donneesJoueur JOIN tableTournoi ON tableTournoi.id = donneesJoueur.idTableTournoi JOIN utilisateur ON utilisateur.id = donneesJoueur.idUtilisateur SET stack='$nouveauStack' WHERE numeroTableTournoi = '$numeroTable' AND idTournoi = '$idTournoi' AND numeroPosition = '$numeroPosition'";
	SQLUpdate($SQL);
	
	$SQLIdJoueur = "SELECT utilisateur.id FROM utilisateur JOIN donneesJoueur ON utilisateur.id = donneesJoueur.idUtilisateur JOIN tableTournoi ON tableTournoi.id = donneesJoueur.idTableTournoi WHERE numeroTableTournoi = '$numeroTable' AND idTournoi = '$idTournoi' AND numeroPosition = '$numeroPosition'";
	$IdJoueur = SQLGetChamp($SQLIdJoueur);
	
	//modification du gain du joueur d'id [idJoueur], dans le tournoi [idTournoi] par [nouveauStack].
	$SQLArchivageStack = "UPDATE archivage SET gainJoueur = '$nouveauStack' WHERE idUtilisateur = '$IdJoueur' AND idTournoi = '$idTournoi'";
	SQLUpdate($SQLArchivageStack);
}

function getNbJoueurTable($numeroTable, $idTournoi)
{
	//sélection du nombre de joueur dans le tournoi [idTournoi] à la table [$numeroTable].
	$SQL = "SELECT nombrePlace FROM tableTournoi WHERE numeroTableTournoi = '$numeroTable' AND idTournoi = '$idTournoi'";
	return SQLGetChamp($SQL);
}

function getNbJoueurTablePresent($numeroTable, $idTournoi)
{
	//sélection du nombre de joueur EFFECTIF (ie vraiment en train de jouer : on ne ocmpte pas les places vacantes) dans le tournoi [idTournoi] à la table [$numeroTable].
	$SQL = "SELECT COUNT(idTableTournoi) FROM donneesJoueur JOIN tableTournoi ON tableTournoi.id =donneesJoueur.idTableTournoi WHERE numeroTableTournoi = '$numeroTable' AND idTournoi = '$idTournoi'";
	return SQLGetChamp($SQL);
}

function delJoueurTable($numeroTable, $idTournoi, $numeroPosition, $stackFinal)
{
	//le joueur est supprimé de la table par le croupier : on l'enleve de la table donneesJoueur
	$SQL = "DELETE donneesJoueur.* FROM donneesJoueur JOIN tableTournoi ON tableTournoi.id = donneesJoueur.idTableTournoi WHERE numeroTableTournoi = '$numeroTable' AND idTournoi = '$idTournoi' AND numeroPosition = '$numeroPosition'";
	SQLDelete($SQL);
	
	$SQLIdJoueur = "SELECT utilisateur.id FROM utilisateur JOIN donneesJoueur ON utilisateur.id = donneesJoueur.idUtilisateur JOIN tableTournoi ON tableTournoi.id = donneesJoueur.idTableTournoi WHERE numeroTableTournoi = '$numeroTable' AND idTournoi = '$idTournoi' AND numeroPosition = '$numeroPosition'";
	$IdJoueur = SQLGetChamp($SQLIdJoueur);
	
	//modification du gain du joueur d'id [idJoueur], dans le tournoi [idTournoi] par [nouveauStack].
	$SQLArchivageStack = "UPDATE archivage SET gainJoueur = '$stackFinal' WHERE idUtilisateur = '$IdJoueur' AND idTournoi = '$idTournoi'";
	SQLUpdate($SQLArchivageStack);
	
}

function getListePositions($numeroTable, $idTournoi)
{
	//sélection des positions des joueurs de la table [numeroTable] dans le tournoi [idTournoi]. 
	$SQL = "SELECT numeroPosition FROM donneesJoueur JOIN tableTournoi ON tableTournoi.id = donneesJoueur.idTableTournoi JOIN utilisateur ON utilisateur.id = donneesJoueur.idUtilisateur WHERE numeroTableTournoi = '$numeroTable' AND idTournoi = '$idTournoi'";
	return parcoursRs(SQLSelect($SQL));
}

function getNbTablesTournoi($idTournoi)
{
	//sélection des numéros des tables du tournoi [idTournoi].
	$SQL = "SELECT numeroTableTournoi FROM tableTournoi WHERE idTournoi = '$idTournoi'";
	return parcoursRs(SQLSelect($SQL)); 
}

function getNomPrenomStatus($nom, $prenom)
{
	//récupération du nom, prenom et status de l'utilisateur s'appelant [nom] [prenom]. Cette fonction sert à vérifier la présence d'un utilisateur aux [nom] [prenom] dans la base de données.
	$SQL = "SELECT nomUtilisateur, prenomUtilisateur, status FROM utilisateur WHERE nomUtilisateur = '$nom' AND prenomUtilisateur = '$prenom'";
	return parcoursRs(SQLSelect($SQL));
}

function uptTournoi($nomTournoi, $buyIn, $lieu, $cashPrize, $dateDebut, $dateFin, $status)
{
	//ajout d'un nouveau tournoi.
	$SQL = "INSERT INTO `tournoi` (`nomTournoi`, `buyIn`, `lieu`, `cashPrize`, `dateDebut`, `dateFin`, `status`) VALUES
('$nomTournoi', '$buyIn', '$lieu', '$cashPrize', '$dateDebut', '$dateFin', '$status')";
	//renvoi l'id du tournoi ainsi inséré.
	return SQLInsert($SQL);
}

function uptTableTournoi($nombrePlace, $numeroTableTournoi, $idTournoi)
{
	//ajout d'une table au tournoi [idTournoi].
	//ATTENTION : $numeroTableTournoi n'est pas auto-incrémenté. Il faut le faire 'manuellement'.
	$SQL = "INSERT INTO `tableTournoi` (`nombrePlace`, `numeroTableTournoi`, `idTournoi`) VALUES
('$nombrePlace', '$numeroTableTournoi', '$idTournoi')";
	//renvoi l'id de la table ainsi insérée.
	return SQLInsert($SQL);
}

function uptJoueurTableTournoi($nom, $prenom, $numeroTable, $idTournoi, $numeroPosition, $stack)
{
	//ajout d'un joueur de [nom] [prenom] à la table [numeroTable] au tournoi [idTournoi].
	
	//récupération de l'id du joueur à partir des [nom] [prenom] de ce dernier.
	$SQLIdJoueur = "SELECT id FROM utilisateur WHERE nomUtilisateur = '$nom' AND prenomUtilisateur = '$prenom'";
	$idJoueur = SQLGetChamp($SQLIdJoueur);
	
	//récupération de l'id de la table à partir de [idTournoi] et [numeroTableTournoi]
	$SQLIdTableTournoi = "SELECT id FROM tableTournoi WHERE idTournoi = '$idTournoi' AND numeroTableTournoi = '$numeroTable'";
	$idTableTournoi = SQLGetChamp($SQLIdTableTournoi);
	
	//insertion avec toutes les données récupérées précédemment ou passées en paramètres.
	$SQL = "INSERT INTO `donneesJoueur` (`numeroPosition`, `stack`, `idUtilisateur`, `idTableTournoi`) VALUES ('$numeroPosition', '$stack', '$idJoueur', '$idTableTournoi')";
	SQLInsert($SQL);
}

function createUtilisateur($nomNouvelUtilisateur, $prenomNouvelUtilisateur, $dateNaissanceNouvelUtilisateur, $genreNouvelUtilisateur, $mailNouvelUtilisateur, $nationaliteNouvelUtilisateur, $loginNouvelUtilisateur, $passwordNouvelUtilisateur)
{
	//création d'un nouveau joueur.
	//On ne renseigne pas le gain ni le status : par défaut, le gain d'un nouveau joueur est nul. L'utilisateur qui s'inscrit est forcement un joueur.
	$SQL = "INSERT INTO utilisateur (nomUtilisateur, prenomUtilisateur, dateNaissance, genre, mail, nationalite, login, password, gain, status) VALUES ('$nomNouvelUtilisateur', '$prenomNouvelUtilisateur', '$dateNaissanceNouvelUtilisateur', '$genreNouvelUtilisateur', '$mailNouvelUtilisateur', '$nationaliteNouvelUtilisateur', '$loginNouvelUtilisateur', '$passwordNouvelUtilisateur', 0, 'joueur')";
	SQLInsert($SQL);
}

function getStatusUtilisateur($idUser)
{
	//récupérer le status du joueur d'id [idUser]
	$SQL = "SELECT status FROM utilisateur WHERE id = '$idUser'";
	return SQLGetChamp($SQL);
}

function passerJoueur($prenom, $nom)
{	
	// change le statut de l'utilisateur passé en en paramètre en 'joueur'
	$SQL = "UPDATE `utilisateur` SET `status`='joueur' WHERE `prenomUtilisateur`='$prenom' AND `nomUtilisateur`='$nom'";
	return SQLUpdate($SQL);
}

function passerCroupier($prenom, $nom)
{
	// change le statut de l'utilisateur passé en en paramètre en 'croupier'
	$SQL = "UPDATE `utilisateur` SET `status`='croupier' WHERE `prenomUtilisateur`='$prenom' AND `nomUtilisateur`='$nom'";
	return SQLUpdate($SQL);
}

function passerAdmin($prenom, $nom)
{
	// change le statut de l'utilisateur passé en en paramètre en 'admin'
	$SQL = "UPDATE `utilisateur` SET `status`='admin' WHERE `prenomUtilisateur`='$prenom' AND `nomUtilisateur`='$nom'";
	return SQLUpdate($SQL);
}

/*MODIFIE*/
function getNomTournoi($status = 'all')
{
	// récupération des noms de tous les tournois selon leur status.
	
	if($status == 'all')
	{
		$SQL = "SELECT `nomTournoi` FROM `tournoi` ORDER BY `dateDebut`";
	}else{
		$SQL = "SELECT `nomTournoi` FROM `tournoi` WHERE status = '$status' ORDER BY `dateDebut`";
	}	
	return parcoursRs(SQLSelect($SQL));
}

function getDataTournoi($nomTournoi)
{
	// sélection des date, lieu, buy-in et cashprize, nom des tournois pour le tournoi donné en argument
	$SQL = "SELECT nomTournoi, dateDebut, dateFin, lieu, buyIn, cashPrize, status FROM tournoi WHERE nomTournoi = '$nomTournoi'";
	return parcoursRs(SQLSelect($SQL));
}

function verifNomTournoi($nomTournoi){
	// vérifie l'existance du nom du tournoi et si celui-ci n'est pas encore commencé
	$SQL = "SELECT COUNT(*) FROM `tournoi` WHERE `nomTournoi` = '$nomTournoi' AND `status` = 'non_commence'";
	return SQLGetChamp($SQL);
}

function uptModifierTournoi($nomTournoi, $buyIn, $lieu, $cashPrize, $dateDebut, $dateFin){
	// modifie le lieu, le buyIn, le cashPrize, la date de Début et la date de Fin du tournoi fourni en premier argument
	$SQL = "UPDATE `tournoi` SET `buyIn`='$buyIn',`lieu`='$lieu',`cashPrize`='$cashPrize',`dateDebut`='$dateDebut',`dateFin`='$dateFin' WHERE `nomTournoi` = '$nomTournoi'";
	return SQLUpdate($SQL);
}

function getTournoiEnCours()
{	
	$SQL = "SELECT id FROM tournoi WHERE status = 'en_cours'";
	return SQLGetChamp($SQL);
}

function getTrouverJoueurTournoi($nom, $prenom, $idTournoi)
{
	$SQL = "SELECT numeroPosition, numeroTableTournoi FROM donneesJoueur JOIN tableTournoi ON donneesJoueur.idTableTournoi = tableTournoi.id JOIN utilisateur ON donneesJoueur.idUtilisateur = utilisateur.id WHERE idTournoi = '$idTournoi' AND nomUtilisateur = '$nom' AND prenomUtilisateur = '$prenom'";
	return parcoursRs(SQLSelect($SQL));
}

function verifUniciteBdd($nomUtilisateur, $prenomUtilisateur)
{
	// Vérifie si le nom et le prénom est déjà dans la base de donnée
	$SQL = "SELECT id FROM utilisateur WHERE nomUtilisateur = '$nomUtilisateur' AND prenomUtilisateur = '$prenomUtilisateur'";
	return SQLGetChamp($SQL);
}

function getRanking()
{
	// Renvoit le classement total des joueurs trié par gain
	$SQL = "SELECT `nomUtilisateur`, `prenomUtilisateur`, `gain`, `nationalite`, `genre` FROM `utilisateur` WHERE `status` = 'joueur' ORDER BY `gain` DESC";
	return parcoursRS(SQLSelect($SQL));
}

function getNationalites()
{
	// Renvoit la liste des nationalités de l'ensemble des utilisateurs
	$SQL = "SELECT DISTINCt `nationalite` FROM `utilisateur`";
	return parcoursRS(SQLSelect($SQL));
}

function getStatusTournoi($nomTournoi)
{
	// Renvoit le status d'un tournoi
	$SQL = "SELECT `status` FROM `tournoi` WHERE `nomTournoi` = '$nomTournoi'";
	return SQLGetChamp($SQL);
}

function getCompteTournoiEncours()
{
	// Compte le nombre de tournoi en cours (0 ou 1)
	$SQL = "SELECT COUNT(*) FROM `tournoi` WHERE `status` = 'en_cours'";
	return SQLGetChamp($SQL);
}

function uptTournoiStatus($nomTournoi, $status)
{
	// Change le status d'un tournoi
	$SQL = "UPDATE `tournoi` SET `status`='$status' WHERE `nomTournoi` = '$nomTournoi'";
	return SQLUpdate($SQL);
}
?>


