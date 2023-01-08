<?php
	//Librairie des fonctions SQL.
	include_once("libs/modele.php");
	
	//Librairie permettant de gérer les requêtes ajax.
	include_once("libs/maLibData.php");
	/*
	Pour chaque requête ajax effectuée, la clé 'fonction' est passé dans le tableau data.
	La valeur associée à cette clé permet d'utiliser le bon morceau de code.
	maLibData n'est donc pas une librairie de fonctions mais plutôt une libraire de morceaux de code...
	*/

/***********************************************
Ce fichier gère les tournois en cours dans le site. 
Il fait appel a de nombreuses requêtes Ajax, puisque la base de données peut être amenée à changer. 
Il y a une partie visible par tous les utilisateurs du site, même ceux non connectés, et 
une interface qui n'est visible que par le croupier.
C'est sur cette interface que le croupier va pouvoir ajouter ou supprimer des joueurs 
du tournoi, ou bien changer le stack d'un joueur.

L'intégralité du fichier a été écrit par Victor SOULIE
- à l'exception de certaines fonctions qui sont issues des 
différents TPs ou CTPs. 
***********************************************/
?>

<html>
<body onload="init();">

	<!--******************************-->
	<!--
	Ce bouton est visible par tous les utilisateurs (croupier, joueur, admin). 
	Il permet de choisir la table du tournoi.
	-->
	<div id='choixTable'>
		<select name='idTable' id='selectionTables'>
			<option value=1>Table 1</option>
			<!--
			Une seule table d'afficher : on va mettre à jour
			ce menu déroulant par la suite avec des fonctions ajax.
			Ainsi, si une table est supprimé au cours du jeu, elle n'apparaîtra plus
			dans le menu déroulant.
			!-->
		</select>
		<input type='button' value='changer_table' onclick='ajaxChangerTable();'>
	</div>
	<!--******************************-->
		
	<br />
	
	<!--******************************-->
	<!--
	Ces entrées textes sont visibles par tous les utilisateurs (croupier, joueur, admin). 
	Elles permettent de saisir le nom et le prénom d'un joueur afin d'obtenir sa position
	dans le tournoi (numéro de table et posiiton à cette table).
	-->
	<div id='trouverJoueur'>
		<input id='entreeTexteNomTrouverJoueur' type='text' value='Nom'>
		<input id='entreeTextePrenomTrouverJoueur' type='text' value='Prenom'>
		
		<input type='button' value="Rechercher joueur" onclick='ajaxVerifierDonneesJoueur("trouver");'>
	</div>
	<!--******************************-->
		
	<br />
	
	<!--******************************-->
	<!--
	Espace reservé au croupier. Il pourra effectuer les opérations qui lui sont dédiées : 
	 - supprimer / ajouter un joueur 
	 - modifier le stack d'un joueur
	Pour pouvoir sélectionner un joueur, on récuperera sa position : 
	si je veux modifier le stack du joueur "Toto TITI", le programme récuperera la 
	position de ce dernier. C'est pour cela que les [name] des select sont "numeroPosition".
	-->
	<div id='espaceCroupier'>
		<div class='nbJoueurEffectif'>Nombre de joueur à table : </div>
		<div class='nbPlace'>Nombre de place à table : </div>
		<div class='stack'>Stack du joueur : </div>
		<div class='position'>Position du joueur : </div>
		<input type='button' value='supprimer_joueur' onclick='ajaxSupprimerJoueur();'>
		<br />
		
		<br />
		<input id='entreeTexteNomNouveauJoueur' value="Nom du nouveau joueur" type='textarea'>
		<input id='entreeTextePrenomNouveauJoueur' value="Prenom du nouveau joueur" type='textarea'>
		<br />
		<select name='numeroPosition' id='selectionNumeroPositionNouveauJoueur'>
			<option value=-1>Toutes les places sont occupees</option>
			<!--
			Même principe que pour le menu déroulant des tables :
			on le mettra à jour avec des requêtes Ajax.
			Ce menu déroulant affiche les places vacantes sur lesquelles il est
			possible d'insérer un joueur.
			!-->
		</select>
		<input id='entreeTexteStackNouveauJoueur' value="Stack du nouveau joueur" type='number'>
		<input type='button' value='ajouter_joueur' onclick='ajaxVerifierDonneesJoueur();'>
		<br />
		
		<br />
		<select name='numeroPosition' id='selectionJoueur'>
			<option value=1>Aucun joueur</option>
			<!--
			Même principe que pour les menus déroulants précédents :
			on le mettra à jour avec des requêtes Ajax.
			!-->
		</select>
		<input type='button' value='sélectionner_joueur' onclick='ajaxChangerJoueur();'>
		
		<br />
		<input id='entreeTexte' type='textarea'>
		<input type='button' value='changer_stack' onclick='ajaxChangerStack();'>
	</div>
	<!--******************************-->

	<br/><br/><br/><br/>
	

	<!--
	Espace où on va afficher les différentes données relatives aux joueurs.
	Pour l'instant, on ne crée que le conteneur de toutes les informations des joueurs. 
	Ce conteneur sera par la suite rempli avec des fonctions ajax.
	-->
	<div id='espaceJoueurs'>
	</div>
	<!--******************************-->
	
<style>
	.joueur {display:inline-block;
		 padding:5px;
		 margin:5px;}
</style>

<script src="ajax.js"></script>
<script src="jquery-3.6.0.min.js"></script>
<script>
/*
On insère le script ajax.js qui recense des fonctions simplifiant l'emploi de requêtes asynchrones : 
CE FICHIER EST ISSU DES DIFFERENTS TP DE TWE (SUGGEST PAR EXEMPLE).
*/
</script>

<script>
<?php
	echo "var idTournoi = " . json_encode(getTournoiEnCours()) . ";";
	/*
	Variable globale que l'on va utiliser en javascript.
	Dans la majorité des fonctions qui vont suivre, 
	connaître l'id du tournoi est nécessaire.
	ATTENTION : il ne peut y avoir qu'un seul tournoi en_cours à la fois.
	*/
?>

/*
Cette fonction prépare la page lors du premier lancement. 
On vérifie le status de l'utilisateur : si c'est un croupier, on ajoute le
div d'id "espaceCroupier".
Une fois cela fait, on lance l'affichage des tables.
*/
function init()
{
	<?php
		echo "var status = 'non_connecte';";
		
		if(isset($_SESSION["status"]))
		{
			echo "status = '" . $_SESSION["status"] . "';";
			/*
			On rajoute ' ' autour de $_SESSION["status"] pour bien convertir $_SESSION["status"] 
			en chaine de caractère.
			*/
		}
	?>
	
	/*
	la variable status est forcément définie même si aucun utilisateur 
	n'est connecte. Elle veut par défaut "non_connecte".
	*/
	if(status != 'croupier')
	{
		/*
		Le joueur n'est pas un croupier : on masque le conteneur associé.
		*/
		$("#espaceCroupier").css({"display":"none"});
		
		/*
		REMARQUE : ce n'est pas optimal du point de vue sécurité. N'importe qui peut afficher 
		à nouveau le conteneur à l'aide de l'inspecteur et avoir accès à toutes les 
		fonctionnalités initialement réservés au croupier.
		Pour améliorer la sécurité, on pourrait mettre status en variable globale 
		et vérifier à chaque appel de fonction réservée au croupier si le statut est bel
		et bien 'croupier'. Je n'ai pas eu le temps de l'implémenter.
		*/
	
	}
	
	//On lance l'affichage des tables
	ajaxChangerTable();

}//fin fonction init

/*
Cette fonction va créer la structure du conteneur affichant les données des différents joueurs :
on va créer autant de conteneurs de joueurs dans ce conteneur. Ainsi, si la table a un nombre X
de place, la fonction suivante va créer X places pour les joueurs dans le conteneur dédié.
*/
function creerNbDivJoueurs(nombrePlace)
{
	console.log("fonction creerNbDivJoueurs");
	console.log("nombreDePlace : " + nombrePlace);
		
	$("#espaceJoueurs").html("");
	//on enlève tous les joueurs potentiellement déjà affichés.
	
	for(var i=1;i<=nombrePlace;i++)
	{
		var idJoueur = "joueur" + i;
		$("#espaceJoueurs").html(
			$("#espaceJoueurs").html() +
			"<div id=" + idJoueur + " class='joueur'>" +
				"<div class='nom'></div>" +
				"<div class='prenom'></div>" +
				"<div class='stack'></div>" +
				"<div class='position'></div>" +
			"</div>"
			);
			/*
			On ajoute un conteneur avec les différentes informations à afficher.
			Chaque conteneur a pour id "joueurX" avec X un entier allant de 1 au nombre de place.
			Ainsi, si on veut sélectionner le joueur de position 3, il suffit de sélectionner le 
			conteneur d'id "joueur3".
			*/
			
	}
	
}//fin fonction creerNbDivJoueurs

/*
Cette fonction modifie le stack d'un joueur. 
Elle est appelée lorsque le croupier effectue des modifications.
*/
function integrerStack(donnees)
{
	console.log("fonction integrerStack");
	console.log("recu integrerStack: " + donnees);
	
	var oRep = JSON.parse(donnees); 
	//les donnees recues sont au format JSON.
	
	var positionJoueur = oRep.numeroPosition;
	var selecteurStackJoueur = "#joueur" + positionJoueur +" .stack";
	//on sélectionne les éléments du conteneur "joueurX", X étant la position du joueur, possèdant la classe "stack".
	
	$(selecteurStackJoueur).html("Stack : " + oRep.stack);
	$("#espaceCroupier .stack").html("Stack : " + oRep.stack);
	//On met à jour le stack dans l'espace joueur et dans l'espace croupier.

}//fin fonction integrerStack

/*
Cette fonction modifie le corps de la page : lorsque l'utilisateur sélectionne une table, 
cette fonction est appelée et va afficher les joueurs de la table en questions ainsi que leurs informations relatives.
Cette fonction fait donc appel à la fonction integrerJoueur : il se peut que la table choisi ait un nombre de place 
différent que sur la table anciemment affichée.
*/
function integrerTable(donnees)
{
	console.log("fonction integrerTable");
	console.log('recu integrerTable : ' + donnees);
	
	var oRep = JSON.parse(donnees); 
	/*
	LES DONNEES SONT TRIEES PAR POSITIONS CROISSANTES.
	*/
	
	var nombreJoueur = oRep.nombreJoueur;
	var nombrePlace = oRep.nombrePlace;
	/*
	C'est compliqué de récupérer la taille de l'objet json : 
	on préfère regarder combien de joueur sont à la table en question en effectuant une requête SQL.
	La variable nombreJoueur stocke le nombre de place occupée à la table, 
	tandis que la variable nombreJoueur stocke le nombre de place à la table.
	Par exemple : si on a une table de 7 joueurs avec 2 joueurs présent (donc 5 places vacantes)
	on aura nombreJoueur = 2 et nombrePlace = 7.
	*/
	
	var nomUtilisateur;
	var prenomUtilisateur;
	var stack;
	var numeroPosition;
	
	var listeJoueurs = new Array();
	var temp;
	
	for(var i=0;i<nombreJoueur;i++)
	/*
	les tableaux sont indexés par rapport à 0...
	On remplit ce tableau pour pouvoir positionner les joueurs aux bons emplacements.
	On a alors un tableau contenant la position de tous les joueurs.
	Cela va être important pour remplir les bons conteneurs : on veut 
	que les informations du joueur position X soit stockés dans le conteneur d'id joueurX.
	*/
	{
		listeJoueurs.push(oRep.donneesJoueur[i].numeroPosition);
	}
					
	$(".nbJoueurEffectif").html("Nombre de joueur à table : " + oRep.nombreJoueur);
	$(".nbPlace").html("Nombre de place : " + oRep.nombrePlace);
	//mise à jour dans l'espace croupier.
	
	//menu déroulant partie croupier : 
	$("#selectionJoueur").html("<option value=-1 selected>Sélection du joueur</option>");
	$("#selectionNumeroPositionNouveauJoueur").html("<option value=-1 selected>Sélection de la position du joueur</option>");
	/*
	On met par défaut un champ "Sélection de ..." dans chaque menu déroulant.
	Le premier permet de sélectionner un joueur parmi ceux à table, le second 
	affiche les places vacantes.
	Ainsi, si il n'y a par exemple aucune place de libre, 
	on affichera quand même une option dans le menu déroulant.
	*/
	
	creerNbDivJoueurs(nombrePlace);
	/*
	on créer le nombre exact d'emplacement pour les joueurs. On va remplir 
	les différents conteneurs avec la boucle suivante.
	*/
	
	var temp = 0;
	/*
	variable 'temporaire' : index permet de savoir sur quel position on est. 
	Cependant, on a aussi besoin de savoir sur quel joueur on se trouve dans le tableau oRep. 
	C'est à cela que sert la variable temp.
	Les données sont triées par positions croissantes.
	*/
		
	$(".joueur").each(function(index){
		$(this).css({"background-color":"yellow"});
		//permet de vérifier que le bon nombre de conteneurs est généré.	
		
		//console.log("index : " + (index + 1));
		//console.log("inArray : " + inArray(listeJoueurs, (index + 1)));
		//DEBUGAGE
		
		if(inArray(listeJoueurs, (index + 1)))
		/*
		On cherche à savoir si le joueur sur lequel on est dans le tableau "donnees"
		a une position qui correspond avec le conteneur sélectionnée.
		index commence à 0, les positions commencent à 1. 
		Par exemple : si on est sur le deuxieme conteneur (d'id joueur2 donc index = 1)
		mais que le 2eme joueur dans le tableau "donnees" est à la position 3, cela veut 
		dire qu'il n'y a pas de joueur à la position 2, le tableau étant triée par 
		positions croissantes.	 
		REMARQUE : la fonction inArray à été codée et est disponible plus bas.
		En javascript, on peut effectuer (var test in tableau). Cependant, 
		cela n'avait pas le comportement attendu. En effet, cela va vérifier si la clé test 
		est dans le tableau, ce qui n'est pas facile à manipuler dans notre cas.
		*/
		{
			/*
			On est sur le conteneur du joueur à la position X. Le tableau "donnees" contient 
			un joueur à la position X. On remplit alors le conteneur d'id "joueurX" avec 
			les données de ce joueur.
			*/
			
			//intégration de la partie visible par tous : conteneur de tous les joueurs
			nomUtilisateur = oRep.donneesJoueur[temp].nomUtilisateur;
			prenomUtilisateur = oRep.donneesJoueur[temp].prenomUtilisateur;
			stack = oRep.donneesJoueur[temp].stack;
			numeroPosition = oRep.donneesJoueur[temp].numeroPosition;
								
			$(this).children(".nom").html("Nom : " + nomUtilisateur);
			$(this).children(".prenom").html("Prenom : " + prenomUtilisateur);
			$(this).children(".stack").html("Stack : " + stack);
			$(this).children(".position").html("Position : " + numeroPosition);
						
			//intégration de la partie croupier
			$("#selectionJoueur").html(
				$("#selectionJoueur").html() + 
				"<option value=" + (index + 1) + ">" + 
				nomUtilisateur + " " +
				prenomUtilisateur +
				"</option>"
			);
			/*
			On écrit les noms des différents joueurs dans le menu déroulant.
			Le croupier pourra alors sélectionner les joueurs qui 
			sont présent dans la table.
			*/
			//ATTENTION : value est égal à la position du joueur !							
		
			temp = temp + 1;
			//on incrémente temp : on passe à la case de tableau suivante.
		}else{
			/*
			On est sur le conteneur du joueur à la position X. Le tableau "donnees" ne contient 
			pas de joueur à la position X. On laisse alors le conteneur d'id "joueurX" vide.
			*/
			
			//réinitialisation de la partie visible par tous : conteneur de tous les joueurs
			$(this).children(".nom").html("");
			$(this).children(".prenom").html("");
			$(this).children(".stack").html("");
			$(this).children(".position").html("");
			
			//intégration de la partie croupier
			$("#selectionNumeroPositionNouveauJoueur").html(
				$("#selectionNumeroPositionNouveauJoueur").html() + 
				"<option value=" + (index + 1) + ">" +
				(index + 1) + 
				"</option>"
			);
			/*
			On affiche dans un menu déroulant les places vacantes. 
			Le croupier choisira parmi ces places lorsqu'il voudra ajouter un joueur.
			*/
		
		}//fin if(inArray(listeJoueurs, (index + 1)))
		
		
	});//fin foreach
	
	var resetDonneesCroupier = new Array();
	
	resetDonneesCroupier = {
		stack: "",
		numeroPosition: ""
	}
	/*
	Ce tableau est un tableau javascript que l'on va convertir en JSON.
	*/
	
	integrerJoueur(JSON.stringify(resetDonneesCroupier, null, '\t'));
	/*
	On utilise JSON.stringify pour convertir le tableau en données JSON : je n'ai 
	pas réussi à faire autrement.
	*/
	/*
	Ici, on vient de changer de table (ou de supprimer un joueur...) :
	il faut donc enlever l'affichage de ce dernier sur l'écran du croupier. 
	On le fait en intégrant un joueur qui n'as pas de position ni de stack. 
	REMARQUE : on aurait pu utiliser de simples sélecteurs jQuery. Cela permet 
	néanmoins de bien comprendre ce qui est modifié. 
	*/
	
	ajaxAfficherTables();
	/*
	Finalement, on met à jour le menu déroulant des tables. On passe par une requête Ajax car
	une table peut être supprimée entre temps.
	*/
	
}//fin fonction integrerTable

/*
Cette fonction modifie les données du joueur dans l'espace croupier 
par celles du joueur sélectionné.
*/
function integrerJoueur(donnees)
{
	console.log("fonction integrerJoueur");
	console.log("recu integrerJoueur : " + donnees);
	
	var oRep = JSON.parse(donnees); 
		
	var stack = oRep.stack;
	var numeroPosition = oRep.numeroPosition;
	
	$("#espaceCroupier .stack").html("Stack : " + stack);
	$("#espaceCroupier .position").html("Position : " + numeroPosition);
	/*
	Mise à jour des conteneurs correspondants.
	*/

}//fin fonction integrerJoueur

/*
Cette fonction modifie le menu déroulant auquel tout le monde a accès.
On y affiche les différentes tables du tournoi.
*/
function affichageTables(donnees)
{
	console.log("fonction affichageTables");
	console.log("recu affichageTables : " + donnees);
	
	var oRep = JSON.parse(donnees);
	
	$("#selectionTables").html("");
	//on commence par clear le menu déroulant des tables. 
	
	for(var i=0;i<oRep.numeros.length;i++)
	/*
	on parcourt le fichier ayant renvoyé les tables : 
	pour chacune d'entre elles, ont crée une option dans le menu déroulant.
	*/
	{
		if(oRep.numeros[i].numeroTableTournoi == oRep.tableSelectionnee)
		/*
		Cette fonction étant appelée à chaque changement de table, 
		on fais en sorte que l'option sélectionnée soit celle de la dernière table cliquée.
		*/
		{
			$("#selectionTables").html(
				$("#selectionTables").html() +
				"<option value=" + oRep.numeros[i].numeroTableTournoi + " selected>" +
				"Table " + oRep.numeros[i].numeroTableTournoi + 
				"</option>"
				);
		}else{
			$("#selectionTables").html(
				$("#selectionTables").html() +
				"<option value=" + oRep.numeros[i].numeroTableTournoi + ">" +
				"Table " + oRep.numeros[i].numeroTableTournoi + 
				"</option>"
				);
		}
		/*
		Remarque : on peut avoir un menu déroulant avec des numéros de table avec une différence supérieure à 1.
		Par exemple : "Table 1", "Table 2", "Table 4", "Table 7"...
		*/
		
	}

}//fin fonction affichageTable

/*
Cette fonction réinitialise les zones d'entrées textes
pour l'ajout d'un joueur dans l'espace croupier. 
*/
function integrerNouveauJoueur()
{
	console.log("fonction integrerNouveauJoueur");
	//pas de donnees passé en paramètre : le côté serveur ne renvoie rien. 
	
	$("#entreeTextePrenomNouveauJoueur").val("Prenom du joueur");
	$("#entreeTexteNomNouveauJoueur").val("Nom du joueur");
	$("#entreeTexteStackNouveauJoueur").val("Stack du joueur");
	//on reinitialise le contenu des zones d'entrée texte pour l'ajout d'un joueur.
	
	ajaxChangerTable();
	/*
	on remet à jour tout le conteneur des joueurs : en effet,
	on vient d'ajouter un joueur. Il y a donc un conteneur enfant qui ne sera plus vide.
	*/

}//fin fonction integrerNouveauJoueur

/*
Cette fonction permet de s'assurer que les données fournies par le croupier 
lors de l'ajout d'un nouveau joueur sont correctes.
*/
function verifierDonneesJoueur(donnees)
{
	console.log("fonction verifierDonneesJoueur");
	console.log("recu verifierDonneesJoueur : " + donnees);
		
	var oRep = JSON.parse(donnees);
	
	var appel = oRep.appel
		
	if(oRep[0] == undefined)
	{
		alert("Le nom ou le prenom saisis n'existent pas");
		/*
		L'utilisateur s'appelant [nom] [prenom] n'est pas dans la 
		base de données.
		*/
	}else if(oRep[0].nomUtilisateur != undefined){
	/*
	Si le tableau "donnees" renvoyé possède un champ nomUtilisateur, 
	cela signifie qu'il y a au moins un utilisateur s'appelant [nom] [prenom].
	IMPORTANT : LA CONSTRUCTION DE CES FONCTIONS IMPLIQUE QU'IL Y A UNICITE DES COUPLES
	(NOM, PRENOM). EN EFFET, ON TRAVAILLE AVEC CE COUPLE PLUTOT QU'AVEC LES ID.
	*/
				
		switch(appel)
		{
			case 'ajout' :
				if(oRep[0].status != 'joueur')
				/*
				On cherche à savoir si le joueur est bien un joueur.
				*/
				{
					alert("Cet utilisateur n'est pas un joueur. Il ne peut pas être ajouté.");
					/*
					Le joueur n'est pas un joueur, on ne peut pas l'insérer.
					*/
				}else{
					ajaxAjouterJoueur();
					/*
					Le joueur est bien un joueur et est présent dans la base de données :
					on peut lancer la fonction pour l'ajouter.
					On se trouve dans le cas ou la fonction à été appelée pour ajouter un joueur.
					*/
				}
			break;
			case 'trouver' :
				ajaxTrouverJoueur();
				/*
				Le joueur est bien un joueur et est présent dans la base de données :
				on peut lancer la fonction pour le trouver.
				On se trouve dans le cas ou la fonction à été appelée pour trouver un joueur.
				*/
			break;
		}//fin switch(appel)	
	}	

}//fin fonction verifierDonneesJoueur

function ajaxChangerStack()
{
	console.log("fonction ajaxChangerStack");
	
	var numeroTable = $('#selectionTables').attr('selected', true).val();
	var nouveauStack = $("#entreeTexte").val();
	var positionJoueurSelectionne = $('#selectionJoueur').attr('selected', true).val();
		
	if(nouveauStack === null || nouveauStack === "")
	/*
	On vérifie qu'une valeur a bien été sélectionné pour le stack.
	REMARQUE : je n'ai pas réussi à vérifier que la donnée saisi était bien un nombre. 
	J'ai essayé en considérant le type ou en convertissant la chaîne en entier mais ce fut peu
	concluant. 
	On utilise alors une zone d'entrée texte de type "number".
	*/
	 
	{
		alert("Le stack entrée est non défini : veuillez sélectionner une valeur acceptable pour le stack");
	}else if(positionJoueurSelectionne == -1){
		alert("Selectionnez un joueur valide");
		/*
		Aucun joueur n'est sélectionné.
		*/
	}else{
			
		ajax({	data:{	'fonction':'ajaxChangerStack',
				'numeroTable':numeroTable,
				'idTournoi':idTournoi,
				'positionJoueurSelectionne':positionJoueurSelectionne,
				'nouveauStack':nouveauStack
				},
			//type:,
			url:"libs/maLibData.php",
			callback:integrerStack
			});
	}//fin if(nouveauStack === null || nouveauStack === "")
	
}//fin fonction ajaxChangerStack

/*
Cette fonction permet de changer la table afficher à l'écran.
*/
function ajaxChangerTable()
{
	console.log("fonction ajaxChangerTable");
	
	ajax({	data:{	'fonction':'ajaxChangerTable',
			'nouveauNumeroTable':$('#selectionTables').attr('selected', true).val(),
			'idTournoi':idTournoi},
		//type:,
		url:"libs/maLibData.php", 				
		callback:integrerTable
		});

}//fin fonction ajaxChangerTable

/*
Cette fonction permet d'intégrer les données d'un joueur dans la zone croupier.
*/
function ajaxChangerJoueur()
{
	console.log("fonction ajaxChangerJoueur");
	
	ajax({	data:{	'fonction':'ajaxChangerJoueur',
			'positionJoueurSelectionne':$('#selectionJoueur').attr('selected', true).val(),
			'numeroTable':$('#selectionTables').attr('selected', true).val(),
			'idTournoi':idTournoi},
		//type:,
		url:"libs/maLibData.php",				
		callback:integrerJoueur
		});

}//fin fonction ajaxChangerJoueur

/*
Cette fonction permet de supprimer un joueur de la table.
Typiquement, lorsqu'un joueur est perdu, on le supprime de la table.
On peut aussi supprimer un joueur de la table lorsqu'il quitte le tournoi.
On sauvegardera alors son stack dans la base de données.
*/
function ajaxSupprimerJoueur()
{
	console.log("fonction ajaxSupprimerJoueur");
	
	var positionJoueurSelectionne = $('#selectionJoueur').attr('selected', true).val();
	
	if(positionJoueurSelectionne == -1)
	{
		alert("Sélectionnez un joueur valide");
	}else{
				
		ajax({	data:{	'fonction':'ajaxSupprimerJoueur',
				'stackFinal':parseInt(($("#joueur" + positionJoueurSelectionne + " .stack").html()).substr(7)),
				'positionJoueurSelectionne':positionJoueurSelectionne,
				'numeroTable':$('#selectionTables').attr('selected', true).val(),
				'idTournoi':idTournoi
				},
			//type:,
			url:"libs/maLibData.php", 				
			callback:ajaxChangerTable
			/*
			On supprime le joueur : il faut alors remettre à jour l'interface du jeu.
			Pour cela, on a besoin de relancer une requête ajax pour récupérer les données.
			La fonction de callback appellée est alors celle de changement de table : mettre à jour 
			les données des joueurs revient à changer de table vers la même table...
			REMARQUE : le stack du joueur ne se met pas correctement à jour. 
			Je n'ai pas réussi à identifier la cause du problème. 
			*/
			});
	}

}//fin fonction ajaxSupprimerJoueur

/*
On affiche les informations de la bonne table.
*/
function ajaxAfficherTables()
{
	console.log("fonction ajaxAffichageTables");
	
	ajax({	data:{	'fonction':'ajaxAfficherTables',
			'idTournoi':idTournoi,
			'tableSelectionnee':$('#selectionTables').attr('selected',true).val()
			},
		//type:,
		url:"libs/maLibData.php",				
		callback:affichageTables
		});

}//fin fonction ajaxAfficherTables

/*
On ajoute un joueur à une table du tournoi.
*/
function ajaxAjouterJoueur()
{
	console.log("fonction ajaxAjouterJoueur");
	
	ajax({	data:{  'fonction':'ajaxAjouterJoueur',
			'nomNouveauJoueur':$('#entreeTexteNomNouveauJoueur').val(),
			'prenomNouveauJoueur':$('#entreeTextePrenomNouveauJoueur').val(),
			'idTournoi':idTournoi,
			'numeroTable':$('#selectionTables').attr('selected',true).val(),
			'numeroPosition':$('#selectionNumeroPositionNouveauJoueur').attr('selected', true).val(),
			'stack':$('#entreeTexteStackNouveauJoueur').val()
			},
		//type:,
		url:"libs/maLibData.php",				
		callback:integrerNouveauJoueur
		});

}//fin fonction ajaxAjouterJoueur

/*
On vérifie le nom et le prenom d'un joueur rentrés dans une zone texte. 
Cette fonction peut être appelée dans deux cas : 
lorsque l'on veut ajouter un joueur ou lorsque l'on veut trouver un joueur 
participant au tournoi.
*/
function ajaxVerifierDonneesJoueur(appel = 'ajout')
//par défaut, on vérifiera les données pour un ajout.
{
	console.log("fonction ajaxVerifierDonneesJoueur");
	console.log("appel : " + appel);
	
	var nom = "";
	var prenom = "";
	
	//if(appel == 'trouver')
	switch(appel)
	{
		case 'trouver' : 
		/*
		Si on souhaite trouver un joueur, alors on récupère simplement le nom et le prénom
		rentrés par l'utilisateur.
		*/
			nom = $('#entreeTexteNomTrouverJoueur').val();
			prenom = $('#entreeTextePrenomTrouverJoueur').val();
			
			ajax({	data:{  'fonction':'ajaxVerifierDonneesJoueur',
					'appel':'trouver',
					'nom':nom,
					'prenom':prenom
					},
				//type:,
				url:"libs/maLibData.php",				
				callback:verifierDonneesJoueur
				});
		break;
		case 'ajout' :
		/*
		Si on souhaite ajouter un joueur, alors on récupère le nom, le prénom ainsi que le stack
		et la position rentrés par le croupier.
		*/
	
			nom = $('#entreeTexteNomNouveauJoueur').val();
			prenom = $('#entreeTextePrenomNouveauJoueur').val();
			var stack = $('#entreeTexteStackNouveauJoueur').val();
			var positionJoueurSelectionne = $('#selectionNumeroPositionNouveauJoueur').attr('selected', true).val();
			var nomPrenomExistent = false;		
			
			$("[id^=joueur] .nom").each(function() {
			//on aurait aussi pu sélectionner les classes...
			/*
			On parcourt chacun des conteneurs de joueurs. On va vérifier si un 
			joueur à le même nom que le nom déjà rentré, puis si il a également
			le même prénom. Le cas échéant, cela signifie que le joueur est déjà
			présent sur la table.
			*/
				if($(this).html() == ("Nom : " + nom)){
					
					$("[id^=joueur] .prenom").each(function() {
						
						if($(this).html() == ("Prenom : " + prenom)){

							nomPrenomExistent = true;

						}
					});
				}
			});
			//CE N'EST PAS TRES ELEGANT : il y a sûrement une meilleure manière de faire...
		
			if(stack === null || stack === "")
			//on vérifie qu'une valeur a bien été sélectionné pour le stack.
			{
				alert("Le stack entrée est non défini : veuillez sélectionner une valeur acceptable pour le stack");
			}else if(positionJoueurSelectionne == -1){
				alert("Selectionnez une position pour le joueur");
			}else if(nomPrenomExistent){
				alert("Ce joueur est déjà positionné");
			}else{
				ajax({	data:{  'fonction':'ajaxVerifierDonneesJoueur',
						'appel':'ajout',
						'nom':nom,
						'prenom':prenom
						},
					//type:,
					url:"libs/maLibData.php",				
					callback:verifierDonneesJoueur
					});
			}
		break;
	}//fin switch(appel)

}//fin fonction ajaxVerifierDonneesJoueur(appel = 'ajout')

/*
Cette fonction permet de trouver un joueur 
parmi les différentes tables du tournoi.
*/
function ajaxTrouverJoueur()
{
	console.log("fonction ajaxTrouverJoueur");
	
	var nom = $('#entreeTexteNomTrouverJoueur').val();
	var prenom = $('#entreeTextePrenomTrouverJoueur').val();
	
	ajax({	data:{  'fonction':'ajaxTrouverJoueur',
			'nom':nom,
			'prenom':prenom,
			'idTournoi':idTournoi
			},
		//type:,
		url:"libs/maLibData.php",			
		callback:trouverJoueur
		});
	
}//fin fonction ajaxTrouverJoueur

/*
Cette fonction permet de trouver un joueur 
parmi les différentes tables du tournoi.
*/
function trouverJoueur(donnees)
{
	console.log("fonction trouverJoueur");
	console.log("recu trouverJoueur : " + donnees);
	
	var oRep = JSON.parse(donnees);
	
	var nom = $("#entreeTexteNomTrouverJoueur").val();
	var prenom = $("#entreeTextePrenomTrouverJoueur").val();
	
	nom = nom.substr(0,1).toUpperCase() + nom.substr(1).toLowerCase();
	prenom = prenom.substr(0,1).toUpperCase() + prenom.substr(1).toLowerCase();
	/*
	On modifie la casse de l'entrée utilisateur pour que ce soit plus propre 
	(on ne veut pas afficher soULiE...)
	*/
	
	if(oRep.length != 0)
	/*
	Si la taille de l'objet reçu est non nul, cela signifie qu'on a trouvé
	un utilisateur s'appellant [prenom] [nom] participant au tournoi. 
	Sinon, cela signifie que l'utilisateur existe mais ne participe pas au tournoi
	(l'existence à été vérifiée dans la fonction verifierDonneesJoueur).
	*/
	{
		alert(	prenom + " " +
			nom + " est table " + 
			oRep[0].numeroTableTournoi + 
			", position " + 
			oRep[0].numeroPosition
			);
	}else{	
		alert(prenom + " " + nom + " ne participe pas à ce tournoi.");
	}	
	
	$("#entreeTexteNomTrouverJoueur").val("Nom");
	$("#entreeTextePrenomTrouverJoueur").val("Prenom");
	/*
	On réinitialise les valeurs des champs d'entrée textes. 
	*/

}//fin fonction trouverJoueur

/*
fonction pour chercher un nombre dans un tableau.
*/
function inArray(tab, targetNumber)
{
	for(var i=0;i<tab.length;i++)
	{
		if(tab[i] == targetNumber)
		{
			return true;
		}
	}
	return false;

}//fin fonction inArray(tab, targetNumber)

</script>

</body>
</html>



