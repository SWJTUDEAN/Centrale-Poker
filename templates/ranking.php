<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Ranking</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="text-white bg-primary border rounded border-0 border-primary d-flex flex-column justify-content-between flex-lg-row p-4 p-md-5" style="background: url(&quot;assets/img/20190808152953_highlight1.png&quot;), transparent;">
        <div class="pb-2 pb-lg-1">
            <h2 class="fw-bold mb-2" style="background: rgba(0,0,0,0.54);font-size: 56px;">Ranking</h2>
            <p class="mb-0" style="background: rgba(0,0,0,0.54);font-size: 28px;">Vous pouvez utiliser les filtres pour voir les différents classements.</p>
        </div>
    </div><!-- Start: 1 Row 4 Columns -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 text-center d-inline-flex d-xxl-flex flex-fill align-items-center align-content-center align-self-center justify-content-xxl-center">
                <p class="text-center d-inline-flex d-xxl-flex align-items-center justify-content-xxl-center align-items-xxl-center" style="font-size: 36px;"></p>
            </div>



        <form action="controleur.php" method="GET"> <!--Création du form pour choisir les filtres-->
<?php 
    include_once "libs/maLibFormsRanking.php"; // On inclue cette librairie qui permet de créer les tableaux
    
    // On écrie les différentes nationalités dans un champ de selection
    echo "
    <div class='col-md-3 d-inline-flex'><select class='d-flex d-xxl-flex flex-fill align-items-center' style='font-size: 36px;' name='nationalite'>
    <optgroup label='Nationalité : '>
    ";
    $liste_nationalite = getNationalites();     // On récupère la liste de toutes les nationalités
    foreach ($liste_nationalite as $ligne_nationalites){
        $ligne_nationalite = $ligne_nationalites['nationalite'];
        echo "<option value='$ligne_nationalite'>$ligne_nationalite</option>";
    }
?>
                        <option value="all" selected>Pas de filtres</option>
                    </optgroup>
                </select></div>

                <!-- Création d'un champ de sélection pour selectionner le genre-->
            <div class="col-md-3 d-inline-flex"><select class="d-flex d-xxl-flex flex-fill align-items-center" style="font-size: 36px;" name='genre'>
                    <optgroup label="Genre : ">
                        <option value="homme" selected="">Homme</option>
                        <option value="femme">Femme</option>
                        <option value="both" selected>Pas de filtres</option>
                </select></div>
            <input type="submit" name="action" value="Appliquer les filtres" />
                </form>         <!--Fin du form pour choisir les filtres-->
        </div>
    </div><!-- End: 1 Row 4 Columns -->
    <?php
    include_once "libs/modele.php";
    include_once "libs/maLibForms.php";

    




$tab = getRanking();        // Récuperation du tableau contenant tous les joueurs tries par gain

if ($fnationalite = valider("fnationalite")){
    if ($fgenre = valider("fgenre")){
        mkTableRanking($tab, $fnationalite, $fgenre);       // Affichage du tableau filtré
    }
}else{
    $fnationalite = "all";
    $fgenre = "both";
    mkTableRanking($tab, $fnationalite, $fgenre);
}

    ?>
    <h2>Voir un joueur</h2>
    <form action="controleur.php" method="GET">             <!--Création du form pour choisir le joueur à afficher-->
        Nom du joueur : <input type="text" name="nom_joueur" /><br />
        Prénom du joueur: <input type="text" name="prenom_joueur" /><br />
        <input type="submit" name="action" value="Voir ce joueur" />
    </form>

<?php 
    if ($nom_joueur = valider("nom_joueur")){
        if ($prenom_joueur = valider("prenom_joueur")){
            if (verifUniciteBdd($nom_joueur, $prenom_joueur)){          // On verifie que ce joueur existe
                mkTableRankingJoueur($tab, $prenom_joueur, $nom_joueur);    // Affichage du tableau contenant ce joueur
            }else {
                echo "<p>Ce joueur n existe pas</p>";
            }
            
        }
    }
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>