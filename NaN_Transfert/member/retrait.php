<?php

session_start();

if ($_SESSION['username']) {


?>		


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/material-bootstrap-wizard.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../js/code.js"></script>
	<title>ACN | Rétrait</title>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <a class="navbar-brand text-center" href="#">
		    Bienvenue <br>
		    <small><b><?php echo $_SESSION['username']; ?></b></small>
		  </a>
		  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav ml-auto">
		    	<li class="nav-link">
	  				<a class="text-dark active" href="index.php">Accueil</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="transfert.php">Transfert</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="#">Retrait</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="message.php">Réception</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="transaction.php">voir les transactions</a>
	  			</li>
		    </ul>
		    <div class="ml-auto">
	  			<a class="btn btn-outline-dark" href="logout.php"><span class="fa fa-sign-out"></span></a>
		    </div>
		  </div>
		</nav>

	</header>
	<div class="image-container set-full-height" style="background: url(../img/transfer.jpg) top center; height: auto; overflow: hidden;">
				
		<div class="container-fluid">
			<div class="row card_member">
			  <div class="col-sm-4">
			    <div class="card">
			      <div class="card-body text-center">
			        <h2 class="card-title">Orange Money</h2>
			        <img class="img rounded-circle" src="../img/orange.jpg" width="150">
			        <p class="card-text"><b>Frais:</b> 2.0% du montant à retirer</p>
			        <a class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm">Utiliser ce service</a>
			      </div>
			    </div>
			  </div>
			  <div class="col-sm-4">
			    <div class="card">
			      <div class="card-body text-center">
			        <h2 class="card-title">Flooz</h2>
			        <img class="img rounded-circle" src="../img/moov.png" width="150">
			        <p class="card-text"><b>Frais:</b> 1.5% du montant à retirer</p>
			        <a class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm">Utiliser ce service</a>
			      </div>
			    </div>
			  </div>
			  <div class="col-sm-4">
			    <div class="card">
			      <div class="card-body text-center">
			        <h2 class="card-title">MTN Money</h2>
			        <img class="img rounded-circle" src="../img/mtn.jpg" width="150">
			        <p class="card-text"><b>Frais:</b> 1.8% du montant à retirer</p>
			        <a class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm">Utiliser ce service</a>
			      </div>
			    </div>
			  </div>
			</div>
		</div>


			<!-- MODAL -->

			<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
			    <div class="modal-content modal_retrait text-center">
			    	<span class="fa fa-close"></span>
			       Désolé ce service sera bientôt disponible.
			    </div>
			  </div>
			</div>

			<!-- END MODAL -->



		<footer class="text-center text-light">
			<p>
				<b>ACN</b> | <b>Transfert d'Argernt</b> Copyright 2019
			</p>
		</footer>
	</div>



</body>
</html>

<?php 

}else{
	header("location:../404/index.php");
}


 ?>