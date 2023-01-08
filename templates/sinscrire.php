<!DOCTYPE html>

<?php
/***********************************************
Ce fichier gère l'inscription d'un nouvel utilisateur.

L'intégralité du backend de ce fichier a été écrit par Victor SOULIE.
- y compris les parties du controleur qui y font référence.
***********************************************/
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>sinscript</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>

<body style="background: transparent;">
    <!-- Start: Login Form Basic -->
    <section class="position-relative py-4 py-xl-5">
        <div class="container" style="background: transparent;">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>S'inscrire sur CentralePoker</h2>
                    <p class="w-lg-50">Inscrivez-vous et nous aurons un meilleur service et une superbe expérience de jeu !</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center">
                            <form class="text-center" action="controleur.php" method="GET">
                                <div class="mb-3">
                                    <p class="text-start d-xxl-flex justify-content-xxl-start">Votre Nom:</p><input class="form-control" type="text" name="nomNouvelUtilisateur" placeholder="Nom">
                                </div>
                                <div class="mb-3">
                                    <p class="text-start d-xxl-flex justify-content-xxl-start">Votre Prénom:</p><input class="form-control" type="text" name="prenomNouvelUtilisateur" placeholder="Prénom">
                                </div>
                                <div class="mb-3">
                                    <p class="text-start d-xxl-flex justify-content-xxl-start">Date de Naissance:</p><input class="form-control" type="date" name="dateNaissanceNouvelUtilisateur" placeholder="Date de Naissance">
                                </div>
                                <div class="mb-3">
                                    <p class="text-start d-xxl-flex justify-content-xxl-start">E-mail:</p><input class="form-control" type="email" name="mailNouvelUtilisateur" placeholder="E-mail">
                                </div>
                                 <div class="mb-3">
                                    <p class="text-start d-xxl-flex justify-content-xxl-start">Genre:</p><input class="form-control" type="text" name="genreNouvelUtilisateur" placeholder="Genre">
                                </div>
                                <div class="mb-3">
                                    <p class="text-start d-xxl-flex justify-content-xxl-start">Pays:</p><input class="form-control" type="text" name="nationaliteNouvelUtilisateur" placeholder="Pays">
                                </div>
                                <div class="mb-3">
                                    <p class="text-start d-xxl-flex justify-content-xxl-start">Identifiant:</p><input class="form-control" type="text" name="loginNouvelUtilisateur" placeholder="Identifiant">
                                </div>
                                <div class="mb-3">
                                    <p class="text-start d-xxl-flex justify-content-xxl-start">Mot de Passe:</p><input class="form-control" type="password" name="passwordNouvelUtilisateur" placeholder="Mot de Passe">
                                </div><button class="btn btn-primary d-block w-100" type="submit" name="action" value="Registration">Envoyer !</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End: Login Form Basic -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
	<?php
		if(isset($_GET["msg"]))
		{
			echo "alert('Cet utilisateur est déjà présent dans la base de données ! Veuillez choisir un autre nom ou un autre prenom.');";
		}	
	?>
</script>

</html>
