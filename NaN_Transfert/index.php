<?php
require 'database.php';
// $a = "00333";
// echo "$a";
// die();

session_start();

/**
	Cette fonction verifie si le email ou l'username existe deja
*/
function verValue($value){
	$db = Database::connect();
	$stmt = $db->query("SELECT * FROM users ");
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	Database::disconnect();
	$a = false;
	for ($i=0; $i < sizeof($data) ; $i++) { 
		if ($data[$i]["username"] === $value) {
			$a = true;
			break;
		}elseif ($data[$i]["password"] === $value) {
			$a = true;
			break;
		}else{
			$a = false;
		}
	}
	return $a;
}

/* 			Rectourner le Solde de l'utilisateur	*/

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


$usernamErreur = $mdpErreur = "" ;

if (!empty($_POST)) {

	$username 	= verifier($_POST['username']); //veri ok
	$password  	= sha1(verifier($_POST['password'])); //veri ok

	if (!empty($username) && !empty($password)) {
		if (verValue($username)) {
			//var_dump(is_numeric($montant) === true);
			if (verValue($password)) {
				
				$_SESSION['username'] = $username;
				$_SESSION['montant'] = retSold($username);
				header("location: member/index.php");

			}else{
				$mdpErreur = $mdp2Erreur = "Mot de passe incorrect";
			}
		}else{
			$usernamErreur = "Ce nom d'utilisateur n'existe pas";
		}
	}else{
		$usernamErreur = $mdpErreur = "Remplicez tous les champs SVP" ;
	}
}

function verifier($values){
	$values = trim($values);
	$values = stripslashes($values);
	$values = htmlspecialchars($values);

	return $values;
}

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
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
    <script src="js/code.js"></script>
	<link rel="stylesheet" type="text/css" href="css/material-bootstrap-wizard.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<title>ACN | Transfert d'argent</title>
</head>
<body>

	<div class="image-container set-full-height" style="background: url(img/wallet.jpg) top center; height: auto; overflow: hidden;">

		<section>
			<div class="container">
				<div class="row">
					<div class="Header1 text-light text-center">
						<h3>Transférer et recevoir de l'argent partout dans le monde avec<br> <b>ACN</b> | <b>Transfert</b></h3>
						<p>
							Cette plateforme de transaction a pour but de faciliter votre vie. 
						</p>
					</div>
				</div>
			</div>
		</section>

	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">
		        <div class="card wizard-card cnx_ins">
		            <form class="col-12" method="post" action="#">
		            	<div class="form-group">
		            		<label for="username">Nom d'utilisateur</label>
		            		<input class="form-control" type="text" name="username" id="username" required>
		            		<small class="text-danger"><span class="help-inline"> <?php echo $usernamErreur; ?> </span></small>
		            	</div>
		            	<div class="form-group">
		            		<label for="password">Mot de passe</label>
		            		<input class="form-control" type="password" name="password" id="password" required>
		            		<small class="text-danger"><span class="help-inline"> <?php echo $mdpErreur; ?> </span></small>
		            	</div>
		            	<button class="btn btn-primary col-12" type="submit">Connexion</button>
		            </form>
		           	<div class="text-right">
		           		<a class="text-secondary" href="inscription.php">Ouvrir un compte maintenant</a>
		           	</div> 
		        </div>
	        </div> <!-- row -->
	    </div> <!--  big container -->
		
		<footer class="text-center text-light">
			<p>
				<b>ACN</b> | <b>Transfert d'Argernt</b> Copyright 2019
			</p>
		</footer>
	</div>






</body>
</html>