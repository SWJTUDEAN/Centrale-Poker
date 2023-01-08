<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>

<div class="col-8 col-lg-2 d-lg-flex align-self-start" style="width: 250px;">
            <div class="btn-group-vertical flex-fill" role="group">
                    <button class="btn btn-primary fs-4 flex-fill" type="button" style="background: var(--bs-orange);" onclick="window.location.href='index.php?view=accueil'">Accueil</button>
                    <button class="btn btn-primary fs-4 flex-fill" type="button" style="background: var(--bs-danger);" onclick="window.location.href='index.php?view=ranking'">Ranking</button>
                    <button class="btn btn-primary fs-4 flex-fill" type="button" style="background: var(--bs-orange);" onclick="window.location.href='index.php?view=encours'">Tournoi en cours</button>
                    <button class="btn btn-primary fs-4 flex-fill" type="button" style="background: var(--bs-danger);" onclick="window.location.href='index.php?view=historique'">Historique des tournois</button>
                    <?php
                      	if (!valider("connecte","SESSION"))
                    	/*
                    	Si on n'est pas connecté, on va proposer le bouton pour se connecter ou s'inscrire. En revanche, 
                    	si on est connecté, alors on affiche les boutons de l'espace personnel et
                    	de l'inscription sur les tournois à venir.
                    	*/
                    	{
                    		echo "<button class='btn btn-primary fs-4 flex-fill' type='button' style='background: var(--bs-orange);' onclick=\"window.location.href='index.php?view=seconnecter'\">Se connnecter/ S'inscrire</button>";
                    	}else if(valider("status","SESSION")){
                    		if($_SESSION["status"] == 'joueur'){
		            		echo "<button class='btn btn-primary fs-4 flex-fill' type='button' style='background: var(--bs-orange);' onclick=\"window.location.href='index.php?view=espacePerso'\">Espace personnel</button>";
		            		echo "<button class='btn btn-primary fs-4 flex-fill' type='button' style='background: var(--bs-danger);' onclick=\"window.location.href='index.php?view=inscription'\">Inscription tournoi à venir</button>";
                    		}else if($_SESSION["status"] == 'admin'){
                    			echo "<button class='btn btn-primary fs-4 flex-fill' type='button' style='background: var(--bs-orange);' onclick=\"window.location.href='index.php?view=gestion'\">Gestion du site</button>";
                    		}//on n'affiche rien pour les croupiers.
                    	}
                    ?>
                    
                </div>
            </div>

</body>
</html>
