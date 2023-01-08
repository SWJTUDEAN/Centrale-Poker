<!DOCTYPE html>
<?php
	include_once("libs/modele.php");

/***********************************************
Ce fichier gère l'espace personnel de l'utilisateur.

L'intégralité du backend de ce fichier a été écrit par Victor SOULIE.
- y compris les parties du controleur qui y font référence.
***********************************************/

?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>espacePerso</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<!--
Chaque zones d'entrée texte possède un identifiant du type "ep_variableARecuperer". 
Le "ep_" en début de nom permet de s'assurer qu'on ne retrouvera pas une variable de même nom issu 
d'un autre script. Pour un maximum de robustesse, on aurait pu réaliser des fermetures : je n'ai pas 
eu le temps d'implémenter cela.
-->
<body style="background: var(--bs-gray-200);margin: 30px;width: auto;height: auto;color: var(--bs-gray-dark);">
    <p style="font-size: 26px;color: var(--bs-gray-dark);">Bonjour ! </p>
    <p class="d-xxl-flex align-items-xxl-center" style="font-size: 24px;color: var(--bs-gray-dark);">Mes informations :&nbsp;</p>
    <form>
        <!-- Start: 1 Row 2 Columns -->
        <div class="container-fluid">
            <div class="row d-xxl-flex align-items-xxl-center">
                <div class="col-md-4 d-flex d-xxl-flex align-content-center align-self-center justify-content-xxl-start align-items-xxl-center">
                    <p class="d-xxl-flex align-items-xxl-center" style="color: var(--bs-gray-dark);font-size: 26px;">Nom</p>
                </div>
                <div class="col-md-8 d-xxl-flex justify-content-xxl-center"><input id="ep_nomUtilisateur" class="form-control d-inline-flex d-xxl-flex flex-fill justify-content-center align-items-center align-content-center align-self-center justify-content-xxl-start align-items-xxl-start" type="text" style="font-size: 26px;"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p style="color: var(--bs-gray-dark);font-size: 26px;">Prénom</p>
                </div>
                <div class="col-md-8 d-xxl-flex justify-content-xxl-center"><input id="ep_prenomUtilisateur" class="form-control d-inline-flex d-xxl-flex flex-fill justify-content-center align-items-center align-content-center align-self-center justify-content-xxl-start align-items-xxl-start" type="text" style="font-size: 26px;"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p style="color: var(--bs-gray-dark);font-size: 26px;">Date de Naissance</p>
                </div>
                <div class="col-md-8 d-xxl-flex justify-content-xxl-center"><input id="ep_dateNaissanceUtilisateur" class="form-control d-inline-flex d-xxl-flex flex-fill justify-content-center align-items-center align-content-center align-self-center justify-content-xxl-start align-items-xxl-start" type="date" style="font-size: 26px;"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p style="color: var(--bs-gray-dark);font-size: 26px;">Genre</p>
                </div>
                <div class="col-md-8 d-xxl-flex justify-content-xxl-center"><input id="ep_genreUtilisateur" class="form-control d-inline-flex d-xxl-flex flex-fill justify-content-center align-items-center align-content-center align-self-center justify-content-xxl-start align-items-xxl-start" type="text" style="font-size: 26px;"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p style="color: var(--bs-gray-dark);font-size: 26px;">E-mail</p>
                </div>
                <div class="col-md-8 d-xxl-flex justify-content-xxl-center"><input id="ep_mailUtilisateur" class="form-control d-inline-flex d-xxl-flex flex-fill justify-content-center align-items-center align-content-center align-self-center justify-content-xxl-start align-items-xxl-start" type="text" style="font-size: 26px;"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p style="color: var(--bs-gray-dark);font-size: 26px;">Nationalité</p>
                </div>
                <div class="col-md-8 d-xxl-flex justify-content-xxl-center"><input id="ep_paysUtilisateur" class="form-control d-inline-flex d-xxl-flex flex-fill justify-content-center align-items-center align-content-center align-self-center justify-content-xxl-start align-items-xxl-start" type="text" style="font-size: 26px;"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p style="color: var(--bs-gray-dark);font-size: 26px;">Identifiant</p>
                </div>
                <div class="col-md-8 d-xxl-flex justify-content-xxl-center"><input id="ep_loginUtilisateur" class="form-control d-inline-flex d-xxl-flex flex-fill justify-content-center align-items-center align-content-center align-self-center justify-content-xxl-start align-items-xxl-start" type="text" style="font-size: 26px;"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p style="color: var(--bs-gray-dark);font-size: 26px;">Mot de Passe</p>
                </div>
                <div class="col-md-8 d-xxl-flex justify-content-xxl-center"><input id="ep_passwordUtilisateur" class="form-control d-inline-flex d-xxl-flex flex-fill justify-content-center align-items-center align-content-center align-self-center justify-content-xxl-start align-items-xxl-start" type="password" style="font-size: 26px;"></div>
            </div>
        </div><!-- End: 1 Row 2 Columns -->
    </form>
    
    <form action="controleur.php" method="GET">
    	<button class="btn btn-primary float-end d-xxl-flex justify-content-xxl-end" type="submit" name="action" value="Logout" style="background: var(--bs-orange);font-size: 26px;margin: 42px;">Déconnexion</button>
    	<button class="btn btn-primary float-end d-xxl-flex justify-content-xxl-end" type="button" onclick="ajaxModifierDonneesUtilisateur();" style="background: var(--bs-orange);font-size: 26px;margin: 42px;">Modifier</button>
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>


<script src="ajax.js"></script>
<script src="jquery-3.6.0.min.js">
//inclusion de ajax et jquery
</script>

<?php	
	$idUtilisateur =  $_SESSION["idUser"];
	/*
	La variable de session existe forcément : la vue n'est accessible que 
	si un joueur est connecté. On pourrait tout de même améliorer la robustesse 
	de cette partie de code.
	*/
	
	$data = getDataUtilisateur($idUtilisateur);
	
	echo "<script>";
	echo "var donnees = " . json_encode($data);
	echo "</script>";
	/*
	On écrit la valeur de la variable de Session de telle 
	sort qu'on puisse la manipuler en javascript.
	*/
?>

<script>

console.log("recu : " + donnees[0].nomUtilisateur);

/*
On sélectionne chacun des attributs du tableau et on les affiche dans les bonnes zones de textes.
*/
$("#ep_nomUtilisateur").val(donnees[0].nomUtilisateur);
$("#ep_prenomUtilisateur").val(donnees[0].prenomUtilisateur);
$("#ep_dateNaissanceUtilisateur").val(donnees[0].dateNaissance);
$("#ep_genreUtilisateur").val(donnees[0].genre);
$("#ep_mailUtilisateur").val(donnees[0].mail);
$("#ep_paysUtilisateur").val(donnees[0].nationalite);
$("#ep_loginUtilisateur").val(donnees[0].login);
$("#ep_passwordUtilisateur").val(donnees[0].password);

/*
Cette fonction modifie les données de l'utilisateur : on récupère les données présentes 
dans les zones d'entrée textes.
REMARQUE : on peux modifier les données en envoyant les données déjà saisies. Cela n'est pas 
optimal mais je n'ai pas eu le temps de faire mieux.
*/
function ajaxModifierDonneesUtilisateur()
{
	console.log("fonction ajaxModifierDonneesUtilisateur");
	
	ajax({	data:{  'fonction':'ajaxModifierDonneesUtilisateur',
			'ep_nomUtilisateur':$('#ep_nomUtilisateur').val(),
			'ep_prenomUtilisateur':$('#ep_prenomUtilisateur').val(),
			'ep_dateNaissanceUtilisateur':$('#ep_dateNaissanceUtilisateur').val(),
			'ep_genreUtilisateur':$('#ep_genreUtilisateur').val(),
			'ep_mailUtilisateur':$('#ep_mailUtilisateur').val(),
			'ep_paysUtilisateur':$('#ep_paysUtilisateur').val(),
			'ep_loginUtilisateur':$('#ep_loginUtilisateur').val(),
			'ep_passwordUtilisateur':$('#ep_passwordUtilisateur').val(),
			},
		//type:,
		url:'libs/maLibData.php', 				
		callback:modifierDonneesUtilisateur
		});
}

/*
Fonction de callback à la fonction à la fonction ajaxModifierDonneesUtilisateur.
Informe simplement que les données ont été modifiées avec succès. 
*/
function modifierDonneesUtilisateur(donnees)
{
	console.log("fonction modifierDonneesUtilisateur");
	console.log("recu modifierDonnesUtilisateur : " + donnees);
	
	alert("Vos donnees ont été modifiées avec succès.");

}//fin fonction modifierDonneesUtilisateur
</script>

</html>













