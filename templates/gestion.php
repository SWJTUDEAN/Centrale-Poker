<?php

include_once "libs/modele.php";
include_once "libs/maLibForms.php";

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=login");
	die("");
}

// Affichage d'un message d'information en haut de page
$info ="";
if ($msg = valider("msg")) {
    $info = "<h3 style=\"color:red;\">$msg</h3>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gestion</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <!-- Start: 1 Row 1 Column -->
    <div class="container" id="corps">
        <div class="row">
            <div class="col-md-12">
                <p class="text-center" style="font-size: 36px;background: rgba(255,255,255,0.5);">Connexion</p>
            </div>
        </div>
    </div><!-- End: 1 Row 1 Column -->
    <?=$info?> <!--Affichage du message-->
    <!-- Start: 1 Row 1 Column -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="text-start" style="font-size: 36px;background: rgba(255,255,255,0.5);">Créer un Tournoi:&nbsp;</p>
            </div>
        </div>
    </div><!-- End: 1 Row 1 Column -->
    <!-- Start: 1 Row 2 Columns -->


    <form action="controleur.php" method="GET">         <!--Création d'un form pour créer un tournoi-->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Nom :</p>
            </div>
            <div class="col-md-6"><input type="text" style="font-size: 24px;" name="nom"></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 2 Columns -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Nombre de tables :</p>
            </div>
            <div class="col-md-6"><input type="number" style="font-size: 24px;"  name="nbr_tables"></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 2 Columns -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Nombre de participants par tables :</p>
            </div>
            <div class="col-md-6"><input type="number" style="font-size: 24px;" name="nbr_paticipants"></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 2 Columns -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Lieu :</p>
            </div>
            <div class="col-md-6"><input type="text" style="font-size: 24px;" name="lieu" ></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 2 Columns -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Date de début :</p>
            </div>
            <div class="col-md-6"><input type="date" style="font-size: 24px;" name="dateDebut" value="2022-06-24"></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 2 Columns -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Date de fin :</p>
            </div>
            <div class="col-md-6"><input type="date" style="font-size: 24px;" name="dateFin" value="2022-06-24"></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 2 Columns -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Buy-in :</p>
            </div>
            <div class="col-md-6"><input type="number" style="font-size: 24px;" name="buyin"></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 2 Columns -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Cashprize :</p>
            </div>
            <div class="col-md-6"><input type="number" style="font-size: 24px;" name="cashprize"></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 1 Column -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-lg-flex justify-content-lg-center"><input type="submit" name="action" value="CreerTournoi" /></div>
        </div>
    </div><!-- End: 1 Row 1 Column -->
    </form>                                                     <!--Fin du form pour créer un tournoi-->
    <!-- Start: 1 Row 1 Column -->


    <div class="container" id="formChoisirTournoiModifier">     
        <div class="row">
            <div class="col-md-12">
                <p class="text-start" style="font-size: 36px;background: rgba(255,255,255,0.5);">Modifier un tournoi:&nbsp;</p>
            </div>
        </div>
    </div><!-- End: 1 Row 1 Column -->
    <!-- Start: 1 Row 3 Columns -->
    <div class="container">
        <form action="controleur.php" method="GET">         <!--Création d'un form pour choisir un tournoi parmi ceux existant-->
        <div class="row">
            <div class="col-md-4">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Tournoi :</p>
            </div>
            <div class="col-md-4 flex-fill"><select name="nomTournoiChoisi" class="d-inline-flex float-start flex-fill justify-content-center align-items-center align-content-center align-self-center" style="font-size: 26px;">
            
            <?php

                    // On vérifie que si un tournoi est reçu en GET, il existe sinon on change la variable tournoichoisi par ""
                if(!($tournoichoisi = valider("tournoichoisi"))){
                    $tournoichoisi = "";
                }

                if((verifNomTournoi($tournoichoisi)) == '0' ){
                    $tournoichoisi = "";
                }

                    // On liste tous les tournois qui n'ont pas encore commencé (seul les tournois non commencé peuvent être modifiés)
                $listetournois = getNomTournoi('non_commence');
                    // On écrit tous les tournois dans un champ de selection
                foreach ($listetournois as $nTournoi){
                $strnomTournoi = $nTournoi["nomTournoi"];
                echo"<option value='$strnomTournoi'";
                    // On garde selectionner le tournoi passé en GET (c'est le tournoi choisi quand on appuie sur le bouton de choix du tournoi)
                if ($strnomTournoi==$tournoichoisi){
                    echo" selected";
                }
                echo">$strnomTournoi</option>";
                }

                ?>


            </select></div>
            <div class="col-md-4"><input type="submit" name="action" value="ChoisirTournoiModifier" /></div>
        </div>
        </form>                     <!--Fin du form pour choisir un tournoi parmi ceux existant-->
        
        
        <?php                       // Création d'un form pour modifier le tournoi choisi

        if (!($tournoichoisi=="")){         //Si le tournoi est choisi
            // Récupération des informations du tournoi
            $dataTournoi = getDataTournoi($tournoichoisi)[0];
            $lieuTournoi = $dataTournoi["lieu"];
            $dateDebut = $dataTournoi["dateDebut"];
            $dateFin = $dataTournoi["dateFin"];
            $buyin = $dataTournoi["buyIn"];
            $cashprize = $dataTournoi["cashPrize"];

            // Création d'un champ de formulaire pour modifier les informations
            // Ce champ de formulaire ne s'affiche quand aucun tournoi à modifier n'est selectionné
            // Les informations du tournoi s'affiche avec l'attribut value dans les champs du formulaire
        echo "
        <div id='formModifierTournoi' style='display:block'>
        <form action='controleur.php' method='GET'>
        <!-- Start: 1 Row 2 Columns -->
            <div class='container'>
                <div class='row'>
                    <div class='col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center'>
                    <p class='text-end justify-content-center align-items-center align-content-center align-self-center' style='font-size: 18px;''>Nom :</p>
                    </div>
                    <div class='col-md-6'><input type='text' style='font-size: 18px;' name='nomTournoi' value='$tournoichoisi' style='display: none!important;'></div>
                </div>
            </div>
        <!-- End: 1 Row 2 Columns -->
        <!-- Start: 1 Row 2 Columns -->
            <div class='container'>
                <div class='row'>
                    <div class='col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center'>
                    <p class='text-end justify-content-center align-items-center align-content-center align-self-center' style='font-size: 18px;''>Lieu :</p>
                    </div>
                    <div class='col-md-6'><input type='text' style='font-size: 18px;' name='lieu' value='$lieuTournoi' style='display: none!important;'></div>
                </div>
            </div>
        <!-- End: 1 Row 2 Columns -->
        <!-- Start: 1 Row 2 Columns -->
            <div class='container'>
                <div class='row'>
                    <div class='col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center'>
                    <p class='text-end justify-content-center align-items-center align-content-center align-self-center' style='font-size: 18px;''>Date de début :</p>
                    </div>
                    <div class='col-md-6'><input type='date' style='font-size: 18px;' name='dateDebut' value='$dateDebut' style='display: none!important;'></div>
                </div>
            </div>
        <!-- End: 1 Row 2 Columns -->   
        <!-- Start: 1 Row 2 Columns -->
        <div class='container'>
            <div class='row'>
                <div class='col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center'>
                <p class='text-end justify-content-center align-items-center align-content-center align-self-center' style='font-size: 18px;''>Date de fin :</p>
                </div>
                <div class='col-md-6'><input type='date' style='font-size: 18px;' name='dateFin' value='$dateFin' style='display: none!important;'></div>
            </div>
        </div>
        <!-- End: 1 Row 2 Columns -->   
        <!-- Start: 1 Row 2 Columns -->
        <div class='container'>
            <div class='row'>
                <div class='col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center'>
                <p class='text-end justify-content-center align-items-center align-content-center align-self-center' style='font-size: 18px;''>Buy-in :</p>
                </div>
                <div class='col-md-6'><input type='number' style='font-size: 18px;' name='buyin' value='$buyin' style='display: none!important;'></div>
            </div>
        </div>
        <!-- End: 1 Row 2 Columns -->  
        <!-- Start: 1 Row 2 Columns -->
        <div class='container'>
            <div class='row'>
                <div class='col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center'>
                <p class='text-end justify-content-center align-items-center align-content-center align-self-center' style='font-size: 18px;''>Cashprize :</p>
                </div>
                <div class='col-md-6'><input type='number' style='font-size: 18px;' name='cashprize' value='$cashprize' style='display: none!important;'></div>
            </div>
        </div>
        <!-- End: 1 Row 2 Columns --> 
        <!-- Start: 1 Row 2 Columns -->
        <div class='container'>
            <div class='row'>
                <div class='col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center'>
                <p class='text-end justify-content-center align-items-center align-content-center align-self-center' style='font-size: 18px;''>Participants :</p>
                </div>
                <div class='col-md-6'><!--<input type='number' style='font-size: 18px;' name='cashprize' value='$cashprize' style='display: none!important;'>--></div>
            </div>
        </div>
        <!-- End: 1 Row 2 Columns --> 
        <!-- Start: 1 Row 1 Column -->
        <div class='container'>
            <div class='row'>
                <div class='col-md-12 d-lg-flex justify-content-lg-center'><!--<button class='btn btn-primary' type='button'>Créer Tournoi</button>--><input type='submit' name='action' value='ModifierTournoi' /></div>
            </div>
        </div>
        <!-- End: 1 Row 1 Column --> 
        </form>
        </div>";
        }               // Fin du formulaire de modification du tournoi
        ?>


    </div><!-- End: 1 Row 3 Columns -->
    <!-- Start: 1 Row 1 Column -->
    <div class="container" id="formModifierTournoi">
        <div class="row">
            <div class="col-md-12">
                <p class="text-start" style="font-size: 36px;background: rgba(255,255,255,0.5);">Modification du status du tournoi:&nbsp;</p>
            </div>
        </div>
    </div><!-- End: 1 Row 1 Column -->
        <!-- Start: 1 Row 3 Columns -->
        <div class="container">


        <form action="controleur.php" method="GET">             <!--Création d'un formulaire pour choisir le tournoi dont on veut modifier le status-->
        <div class="row">
            <div class="col-md-4">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Tournoi :</p>
            </div>
            <div class="col-md-4 flex-fill"><select name="nomTournoiChoisiStatus" class="d-inline-flex float-start flex-fill justify-content-center align-items-center align-content-center align-self-center" style="font-size: 26px;">
            
            
            <?php
                // On liste dans un champ de selection les tournois en cours ou non commence pour pouvoir changer leurs status 
                $listetournois = getNomTournoi('en_cours');
                foreach ($listetournois as $nTournoi){
                $strnomTournoi = $nTournoi["nomTournoi"];
                echo"<option value='$strnomTournoi'";
                if ($strnomTournoi==$tournoichoisi){
                    echo" selected";
                }
                echo">$strnomTournoi</option>";
                }
                $listetournois = getNomTournoi('non_commence');
                foreach ($listetournois as $nTournoi){
                $strnomTournoi = $nTournoi["nomTournoi"];
                echo"<option value='$strnomTournoi'";
                if ($strnomTournoi==$tournoichoisi){
                    echo" selected";
                }
                echo">$strnomTournoi</option>";
                }

                ?>
            </select></div>
            <div class="col-md-4"><input type="submit" name="action" value="Choisir le Tournoi" /></div>
        </div>
        </form>         <!--Fin du formulaire pour choisir le tournoi dont on veut modifier le status-->


        <?php
        // Si le tournoi est choisi
        if($nomTournoiStatus = valider("nomTournoiStatus"))
        // On récupère son status
        if($statusTournoi = valider("statusTournoi")){
            echo "Status du tournoi $nomTournoiStatus : $statusTournoi </br>";
            if($statusTournoi == "en_cours"){               // Si le tournoi est en_cours on peut le terminer
                                                            // On affiche donc un champ de formulaire contenant un bouton submit
                                                            // et le nom du tournoi dans un champ caché qu'on va passer au controlleur
                echo 
                "<form action='controleur.php' method='GET'>
                <div class='container'>
                    <div class='row text-center d-lg-flex justify-content-lg-center'>
                        <div class='col-md-2'>
                            <input type='text' name='nomTournoi' value='$nomTournoiStatus' style='display:none'/>
                            <input type='submit' name='action' value='Terminer le Tournoi' /></div>
                    </div>
                </div>
                </form>";
            }else if($statusTournoi == "non_commence"){     // Si le tournoi n'est pas commencé
                                                            // On peut le passer en en cours si aucun autre tournoi n'est en cours (on suppose qu'il ne peut y avoir qu'un seul tournoi à la fois)
                if(getCompteTournoiEncours()){              // On vérifie qu'aucun tournoi ne soit en cours
                    echo "Il y a déjà un tournoi en cours";
                } else{
                    echo                                    // On crée alors un form pour changer le status du tournoi
                "<form action='controleur.php' method='GET'>        
                <div class='container'>
                    <div class='row text-center d-lg-flex justify-content-lg-center'>
                        <div class='col-md-2'>
                            <input type='text' name='nomTournoi' value='$nomTournoiStatus' style='display:none'/>
                            <input type='submit' name='action' value='Commencer le Tournoi' /></div>
                    </div>
                </div>
                </form>";
                }
            }else echo "Le tournoi est déjà terminé";       // Si le tournoi n'est ni non commencé ni en cours
        }
        
        ?>
    </div><!-- End: 1 Row 3 Columns -->

    
    <!-- Start: 1 Row 1 Column -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="text-start" style="font-size: 36px;background: rgba(255,255,255,0.5);">Modification du status des utilisateurs:&nbsp;</p>
            </div>
        </div>
    </div><!-- End: 1 Row 1 Column -->
    <!-- Start: 1 Row 2 Columns -->


    <form action="controleur.php" method="GET">                 <!--Création d'un form pour modifier le status des utilisateurs (admin, croupier ou joueur)-->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Nom :</p>
            </div>
            <div class="col-md-6"><input type="text" style="font-size: 24px;" name="nom" ></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 2 Columns -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-inline-block flex-fill justify-content-center align-items-center align-content-center align-self-center">
                <p class="text-end justify-content-center align-items-center align-content-center align-self-center" style="font-size: 24px;">Prénom :</p>
            </div>
            <div class="col-md-6"><input type="text" style="font-size: 24px;" name="prenom"></div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 3 Columns -->
    <div class="container">
        <div class="row text-center d-lg-flex justify-content-lg-center">
            <div class="col-md-2"><input type="submit" name="action" value="PasserAdmin" /></div>
            <div class="col-md-2"><input type="submit" name="action" value="PasserCroupier" /></div>
            <div class="col-md-2"><input type="submit" name="action" value="PasserJoueur" /></div>
        </div>
    </div>
    </form><!-- End: 1 Row 3 Columns -->                        <!--Fin du form pour modifier le status des utilisateurs (admin, croupier ou joueur)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
