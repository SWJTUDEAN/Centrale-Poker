<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
?>

<div id="room" class="container-fluid" style="background: transparent;">
</div>


<div id="footer" class="container-fluid" style="background: #e0e0e0;">
        <div class="row" style="background: var(--bs-gray-500);">
            <div class="col-md-4 align-self-center">
                <?php
                if (valider("connecte","SESSION")){

                    $login = $_SESSION["login"];
                    $status = $_SESSION["status"];
                    echo "<p class='fs-2 d-xxl-flex justify-content-start align-items-center align-items-xxl-start'>Bonjour, $login</p>";
                }
                ?>
            </div>
            <div class="col-md-4 flex-fill align-content-center align-self-center">
                <?php
                if (valider("connecte","SESSION")){
                    echo "<p class='fs-2 d-xxl-flex justify-content-center align-items-xxl-start'>Statut : $status</p>";
                    echo "<form action='controleur.php' method='GET'>
                    <input type='submit' name='action' value='Logout' />
                    </form>";
                }
                ?>
            </div>
            <div class="col-md-4"><img class="float-end" src="assets/img/logo.png"></div>
        </div>
    </div><!-- End: 1 Row 3 Columns -->

</body>
</html>
