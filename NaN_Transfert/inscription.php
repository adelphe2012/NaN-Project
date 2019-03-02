<?php

require "database.php";

// echo "<pre>";
// var_dump($data);
// echo "</pre>";
//die(Database::disconnect());

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
		if ($data[$i]["email"] === $value) {
			$a = true;
			break;
		}elseif ($data[$i]["username"] === $value) {
			$a = true;
			break;
		}else{
			$a = false;
		}
	}
	return $a;
}


// $data['mail'] 		= "adelphe2012@gmail.com";
// $data['username']	=  "adelphe";

$nomErreur = $prenomErreur = $emailErreur = $depotErreur = $usernamErreur = $codeErreur = $mdpErreur = $mdp2Erreur = "" ;

if (!empty($_POST)) {

	$name		= verifier($_POST['name']); 
	$lastname	= verifier($_POST['lastname']);
	$mail 		= verifier($_POST['mail']);  	//veri ok
	$montant	= verifier($_POST['montant']); 	//veri ok
	$username 	= verifier($_POST['username']); //veri ok
	$code 		= verifier($_POST['code']);     //veri ok
	$password  	= verifier($_POST['password']); //veri ok
	$password2	= verifier($_POST['password2']); 

	if (!empty($name) && !empty($lastname) && !empty($mail) && ($montant >= 0) && !empty($username) && !empty($code) && !empty($password) && !empty($password2)) {
		if (!verValue($mail)) {
			if (!verValue($username)) {

				//var_dump(is_numeric($montant) === true);
				
				if (is_numeric($montant) === true) {
					if ($montant >= 1 && $montant <= 1000000) {
						if (strlen(strval($code)) === 5) {
							if ($password === $password2) {
								//cripté le mot de passe
								$password = sha1($password);
								
								$dataValue = array($name,$lastname,$mail,$montant,$username,$code,$password);

								$db = Database::connect();
								$stmt = $db->Prepare("INSERT INTO users ( nom, prenom, email, depot, username, codes, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
								$stmt->execute($dataValue);
								Database::disconnect();

								$msg = 'Votre compte a été créé avec succes <b class="float-right"> <a class="btn btn-info btn-xl" href="index.php">Se connecter</a> </b>';
							}else{
								$mdpErreur = $mdp2Erreur = "Les mots de passes sont differents";
							}
						}else{
							$codeErreur = "Votre code doit être composé de 5 chiffres";
						}
					}else{
						$depotErreur = "Le montant doit être compris entre:<br>1 et 1 000 000 fcfa";
					}
				}else{
					$depotErreur = "Valeur pas prise en charge";
				}
			}else{
				$usernamErreur = "Ce nom d'utilisateur existe déjà";
			}
		}else{
			$emailErreur = "Ce mail existe déjà";
		}
	}else{
		$nomErreur = $prenomErreur = $emailErreur = $depotErreur = $usernamErreur = $codeErreur = $mdpErreur = $mdp2Erreur = "Remplicez tous les champs SVP" ;
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
	<script src="js/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
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
		        <div class="card wizard-card ins">
		            <form method="post" role="form" action="">

		            	<div class="text-success">
		            		<?php if (isset($msg)) {
								die($msg);
							}; ?>
		            	</div>

		            	<div class="row">
			            	<div class="col-md-6">
				            	<div class="form-group">
				            		<label for="name">Nom <span class="text-danger"> *</span></label>
				            		<input class="form-control" type="text" name="name" id="name" required>
				            		<small class="text-danger"><span class="help-inline"> <?php echo $nomErreur; ?> </span></small>
				            	</div>
				            	<div class="form-group">
				            		<label for="lastname">Prénoms <span class="text-danger"> *</span></label>
				            		<input class="form-control" type="text" name="lastname" id="lastname" required>
				            		<small class="text-danger"><span class="help-inline"> <?php echo $prenomErreur; ?> </span></small>
				            	</div>
				            	<div class="form-group">
				            		<label for="mail">Email <span class="text-danger"> *</span></label>
				            		<input class="form-control" type="email" name="mail" id="mail" required>
				            		<small class="text-danger"><span class="help-inline"> <?php echo $emailErreur; ?> </span></small>
				            	</div>
				            	<div class="form-group">
				            		<label for="montant">Dépôt en FCFA: <span class="text-danger"> *</span><br> </label>
				            		<small>min:  1 , max: 1 000 000</small>
				            		<input class="form-control" type="number" name="montant" id="montant" required>
				            		<small class="text-danger"><span class="help-inline"> <?php echo $depotErreur; ?> </span></small>
				            	</div>
			            	</div>
			            	<div class="col-md-6">
			            		<div class="form-group">
				            		<label for="username">Nom d'utilisateur <span class="text-danger"> *</span></label>
				            		<input class="form-control" type="text" name="username" id="username" required>
				            		<small class="text-danger"><span class="help-inline"> <?php echo $usernamErreur; ?> </span></small>
				            	</div>
				            	<div class="form-group">
				            		<label for="code">Code de securité <span class="text-danger"> *</span></label>
				            		<input class="form-control" type="number" name="code" id="code" placeholder="ex: 13213" required>
				            		<small class="text-danger"><span class="help-inline"> <?php echo $codeErreur; ?> </span></small>
				            	</div>
				            	<div class="form-group">
				            		<label for="password">Mot de passe <span class="text-danger"> *</span></label>
				            		<input class="form-control" type="password" name="password" id="password" required>
				            		<small class="text-danger"><span class="help-inline"> <?php echo $mdpErreur; ?> </span></small>
				            	</div>
				            	<div class="form-group">
				            		<label for="password2">Confirmer le mot de passe <span class="text-danger"> *</span></label>
				            		<input class="form-control" type="password" name="password2" id="password2" required>
				            		<small class="text-danger"><span class="help-inline"> <?php echo $mdp2Erreur; ?> </span></small>
				            	</div>
			            	</div>
		            	</div>

		            	<button class="btn btn-danger col-12" type="submit">S'inscrire</button>
			           <div class="text-right">
			           		<a class="text-secondary" href="index.php">Se connecter</a>
			           </div> 
		            </form>
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