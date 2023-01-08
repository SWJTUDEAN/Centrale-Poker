<?php
    $status = session_status();
    if($status == PHP_SESSION_NONE){
    	session_start();
    }else if($status == PHP_SESSION_DISABLED){
    }else
    if($status == PHP_SESSION_ACTIVE){
    	session_destroy();
    	session_start();
    }

    include_once "libs/maLibUtils.php";
    include_once "libs/maLibSecurisation.php";

	$view = valider("view"); 

    if(!$view){
        $view = "accueil"; 
    }
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>CentralePoker</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <style>
    	#footer{
    		background-color: gainsboro;
    		position:fixed;
    		bottom:0%;
    		left:0%;
    		width:100%;
    	}
        #room{
            background-color: transparent;
            height: 100px;
        }


    	
    </style>
</head>

<body style="background: linear-gradient(#e546ff 0%, #ff9900 100%);">
    <div class="container-fluid flex-fill justify-content-center align-items-center align-content-center">
        <div class="row">
            <?php
            include("templates/menu.php");
            ?>
            <div class="col d-inline-block" style="height: auto;background: transparent;width: auto;max-height: auto;padding-right: 0px;padding-left: 0px;">
            <?php 
                switch($view)
	            {		

	        	case "accueil" : 
			        include("templates/accueil.php");
		        break;

	            	case "connexion" : 
		        	include("templates/login.php");
		            break;

		            default : // si le template correspondant à l'argument existe, on l'affiche
			        if (file_exists("templates/$view.php"))
				       include("templates/$view.php");
	            }
            ?>
            </div>
        </div>
    </div><!-- End: 1 Row 2 Columns -->
    <!-- Start: 1 Row 3 Columns -->

    <?php
    include("templates/footer.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

