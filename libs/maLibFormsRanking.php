<?php

/*
Ce fichier définit diverses fonctions permettant de faciliter la production de tableaux de l'onglet Ranking
*/

function mkLigneEnteteRanking($tabAsso)
{
	// Fonction appelée dans mkTable, produit une ligne d'entête
	// contenant les noms des champs à afficher dans mkTable
	// Les champs à afficher sont définis à partir de la liste listeChamps 
	// si elle est fournie ou du tableau tabAsso
    // tabAsso est un tableau associatif dont on affiche TOUTES LES CLES
	
	//On affiche aussi le nom de la première colonne qui est rang
    echo "\t<tr>\n";
    echo "\t\t<th>Rang</th>\n";
    foreach ($tabAsso as $cle => $val)	
    {
        echo "\t\t<th>$cle</th>\n";
    }
    echo "\t</tr>\n";
}

function mkLigneRanking($tabAsso,$classement)
{
	// Fonction appelée dans mkTable, produit une ligne 	
	// contenant les valeurs des champs à afficher dans mkTable
	// Les champs à afficher sont définis à partir de la liste listeChamps 
	// si elle est fournie ou du tableau tabAsso
	// tabAsso est un tableau associatif

	// On affiche aussi la variable $classement dans la première colonne qui correspond au rang
	echo "\t<tr>\n";
	echo "\t\t<td>$classement</td>\n";
	foreach ($tabAsso as $cle => $val)	
	{
		echo "\t\t<td>$val</td>\n";
	}
	echo "\t</tr>\n";
}

function mkTableRanking($tabData, $nationalite, $genre)
{

	// Attention : le tableau peut etre vide 
	// On produit un code ROBUSTE, donc on teste la taille du tableau
	if (count($tabData) == 0) return;

	echo "<table border=\"1\">\n";
	// afficher une ligne d'entete avec le nom des champs
	mkLigneEnteteRanking($tabData[0]);

	//tabData est un tableau indicé par des entier

	// On incrémente la variable $classement à chaque ligne pour connaitre le rang du joueur
	$classement = 1;
	// On incrément la variable $nbLigne jusqu'à 20 pour pouvoir afficher uniquement les 20 premières lignes
    $nbLigne = 0;
    $maxnbLigne = 20;


	foreach ($tabData as $data)	
	{
		// afficher une ligne de données avec les valeurs, à chaque itération

		// S'il n'y a pas de filtres on affiche tout
		if ($nationalite == "all" and $genre == "both" and $nbLigne<$maxnbLigne){
            mkLigneRanking($data,$classement);
            $nbLigne++;
        }else if ($nationalite == "all" and $nbLigne<$maxnbLigne){		// On filtre en fonction du genre
            if ($data["genre"] == $genre){
                mkLigneRanking($data,$classement);
                $nbLigne++;
            }
        }else if ($genre == "both"){									// On filtre en fonction de la nationalité
			
            if ($data["nationalite"] == $nationalite and $nbLigne<$maxnbLigne){
                mkLigneRanking($data,$classement);
                $nbLigne++;
            }

        }else{															// On filtre en fonction du genre et de la nationalité
            if ($data["genre"] == $genre and $data["nationalite"] == $nationalite and $nbLigne<$maxnbLigne){
                mkLigneRanking($data,$classement);
                $nbLigne++;
            }
        }
            
        $classement++;
	}
	echo "</table>\n";

	// Produit un tableau affichant les données passées en paramètre
	// Si listeChamps est vide, on affiche toutes les données de $tabData
	// S'il est défini, on affiche uniquement les champs listés dans ce tableau, 
	// dans l'ordre du tableau
	
}

function mkTableRankingJoueur($tabData, $prenom, $nom)
{

	// Attention : le tableau peut etre vide 
	// On produit un code ROBUSTE, donc on teste la taille du tableau
	if (count($tabData) == 0) return;

	echo "<table border=\"1\">\n";
	// afficher une ligne d'entete avec le nom des champs
	mkLigneEnteteRanking($tabData[0]);

	//tabData est un tableau indicé par des entier
	$classement = 1;
	foreach ($tabData as $data)	
	{
		// afficher une ligne de données avec les valeurs, à chaque itération

		// On affiche uniquement le joueur correspondant
        if ($data["prenomUtilisateur"] == $prenom and $data["nomUtilisateur"] == $nom){
            mkLigneRanking($data,$classement);
        }
        $classement++;
    }
            
        
	echo "</table>\n";

	// Produit un tableau affichant les données passées en paramètre
	// Si listeChamps est vide, on affiche toutes les données de $tabData
	// S'il est défini, on affiche uniquement les champs listés dans ce tableau, 
	// dans l'ordre du tableau
}

?>

















