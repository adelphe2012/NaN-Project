<?php

session_start();

require "../database.php";

function retSold($value){
	$db = Database::connect();
	$stmt = $db->query("SELECT * FROM users ");
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	Database::disconnect();
	$Solde = 0;
	for ($i=0; $i < sizeof($data) ; $i++) { 
		if ($data[$i]["username"] === $value) {
			$Solde = $data[$i]["depot"];
			break;
		}
	}
	return $Solde;
}

if ($_SESSION['username']) {

$_SESSION['montant'] = retSold($_SESSION['username']);
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
    <script src="../js/code.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/material-bootstrap-wizard.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<title>ACN | Accueil</title>
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
	  				<a class="text-dark active" href="#">Accueil</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="transfert.php">Transfert</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="retrait.php">Retrait</a>
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
			        <h5 class="card-title">Soldes Disponibles</h5>
			        <p class="card-text"><b><?php echo $_SESSION['montant']; ?></b> FCFA</p>
			        <!-- Button trigger modal -->
			        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Faire une transaction</a>
			      </div>
			    </div>
			  </div>
			  <div class="col-sm-8">
			    <div class="card">
			      <div class="card-body">
			        <h4 class="card-title">Activité recente</h4>
			        <p class="card-text">
			        	<table class="table table-striped">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Email</th>
						      <th scope="col">Montant Transferé</th>
						      <th class="cacher" scope="col">Date</th>
						    </tr>
						  </thead>

						  <?php 
						  		$db 			= Database::connect();

						  		$req 			= $db->query("SELECT * FROM users WHERE username = \"".$_SESSION['username']."\"");
						  		$re_id			= $req->fetch(PDO::FETCH_ASSOC);
						  		$user_id		= $re_id['id'];

						  		$res 			= $db->query("SELECT * FROM transactions WHERE user = ".$user_id." ORDER BY datetr DESC");
						  		$resultats		= $res->fetchAll(PDO::FETCH_ASSOC);
						  		Database::disconnect();
						   
						  		// echo "<pre>";
						  		// var_dump($resultats);
						  		// echo "</pre>";
						  		// exit();


						  	$j = 0;

						  	echo "<tbody>";
						  	for ($i=0; $i < sizeof($resultats) ; $i++) { 
						  		$j = $i + 1;
						  		echo 	'
										    <tr>
										      <th scope="row">'.$j.'</th>
										      <td>'.$resultats[$i]["email"].'</td>
										      <td>'.$resultats[$i]["montant"].' fcfa</td>
										      <td class="cacher">'.$resultats[$i]["datetr"].'</td>
										    </tr>
						  				';

						  			$i++;

						  			if ($i == 4) {
						  				break;
						  			}
						  	}
						  	echo "</tbody>";
						   ?>


						</table>
			        </p>
			        
			      </div>
			    </div>
			  </div>
			</div>

		</div>

		<!-- MODAL trans -->

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Transactions</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      		<div class="row">
				       		<div class="col-md-6">
				       			<a class="btn btn-info col-12	" href="transfert.php">Transfert</a>
				       		</div>
				       		<div class="col-md-6">
				       			<a class="btn btn-danger col-12	" href="retrait.php">Retrait</a>
				       		</div>
			      		</div>
			      </div>
			    </div>
			  </div>
			</div>

		<!-- END MODAL Transaction-->

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