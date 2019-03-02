<?php
session_start();

/*		Cette fonction permet de retourner une propriete de l'utilisateur en fonction de son nom d'utilisateur	*/
require "../database.php";

function retPropriete($valueINT,$valueOUT){
	$db = Database::connect();
	$stmt = $db->query("SELECT * FROM users ");
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	Database::disconnect();
	$propriete = 0;
	for ($i=0; $i < sizeof($data) ; $i++) { 
		if ($data[$i]["username"] === $valueINT) {
			$propriete = $data[$i][$valueOUT];
			break;
		}
	}
	return $propriete;
}


/*		Cette fonction permet de recuperer toutes les adresse mail de nos utilisateurs	*/

function retAll_mail($valueINT,$valueOUT){
	$db = Database::connect();
	$stmt = $db->query("SELECT * FROM users ");
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	Database::disconnect();
	$j = 0;
	$propriete = array();
	for ($i=0; $i < sizeof($data) ; $i++) { 
		if ($data[$i]["email"] !== $valueINT) {
			$propriete[$j] = $data[$i][$valueOUT];
			$j++; 
		}
	}
	return $propriete;
}




if ($_SESSION['username']) {

function verifier($values){
	$values = trim($values);
	$values = stripslashes($values);
	$values = htmlspecialchars($values);

	return $values;
}

$_SESSION['email'] 		= retPropriete($_SESSION['username'],"email");
$_SESSION['code'] 		= retPropriete($_SESSION['username'],"codes");
$_SESSION['montant'] 	= retPropriete($_SESSION['username'],"depot");
$user_id			 	= retPropriete($_SESSION['username'],"id"); 
$db_mail 				= retAll_mail($_SESSION['email'],"email");

$emailErreur = $depotErreur = $codeErreur = "";

// var_dump(date("Y-m-d H:i:s")); exit();


if (!empty($_POST)) {

	$mail 		= verifier($_POST['mail']);  	//veri ok
	$montant	= verifier($_POST['montant']); 	//veri ok
	$code 		= verifier($_POST['code']);     //veri ok

	if (!empty($mail) && ($montant >= 0) && !empty($code)) {
		if ($mail !== $_SESSION['email']) {
			if (in_array($mail, $db_mail)) {

				if (is_numeric($montant) === true) {
					if ($montant >= 1 && $montant <= 100000){

						if ($code === $_SESSION['code']) {

							$frais_transf = ((((float)($montant))*1.2)/100);
							$mnt_plus_frai = $montant + $frais_transf;



							if ($mnt_plus_frai < $_SESSION['montant']) {

								$dataValue = array($user_id,$mail,$montant,date("Y-m-d H:i:s"));

								// echo "<pre>";
								// var_dump($dataValue);
								// echo "</pre>";
								// exit();

								$db = Database::connect();

								$montant_restant = $_SESSION['montant'] - $mnt_plus_frai;

								// var_dump($montant_restant); exit();
								
								$stmt = $db->Prepare("UPDATE users SET depot = ? WHERE id = ?");
								$stmt->execute(array($montant_restant,$user_id));

								$stmt = $db->Prepare("INSERT INTO transactions ( user, email, montant, datetr) VALUES (?, ?, ?, ?)");
								$stmt->execute($dataValue);

								// Faire une mise a jour du compte de l'utilisateur qui a recu le depot

								$remail 					= $db->query("SELECT * FROM users WHERE email = \"".$mail."\"");
								$pro_uti_recu_depot 		= $remail->fetch(PDO::FETCH_ASSOC);
								$mail_recu					= $pro_uti_recu_depot["email"];

								// Recuperer le montant de l'utilisateur qui a recu le depot
								$mnt_uti_recu 		= $pro_uti_recu_depot['depot'];
								$mnt_uti_recu	   += $montant;

								$upMontant = $db->Prepare("UPDATE users SET depot = ? WHERE email = ?");
								$upMontant->execute(array($mnt_uti_recu,$mail_recu));

								// Recuperer le compte admin pour ajouter les frais.

								$com 		= $db->query("SELECT * FROM admin WHERE id = 1");
								$acom 		= $com->fetch(PDO::FETCH_ASSOC);
								$compValu 	= $acom["compte_acn"];
								$compValu  += $frais_transf;

								$stmt = $db->Prepare("UPDATE admin SET compte_acn = ? WHERE id = 1");
								$stmt->execute(array($compValu));

								//recuperer l'id de transaction

								$tran 		= $db->query("SELECT * FROM transactions WHERE id = ".$user_id);
								$acom 		= $tran->fetch(PDO::FETCH_ASSOC);
								$tran_id 	= $acom["id"];

								// Generer un message pour le depot qui s'affichera chez le recepteur du depot
								
								$content = "Vous avez recu $montant fcfa de : ".$_SESSION['username']." (".$_SESSION['email'].")";
								$dataMsg 	= array($tran_id,$content,$_SESSION['username'],$mail,date("Y-m-d H:i:s"));

								$stmt = $db->Prepare("INSERT INTO messages ( msgtrans, content, msg_user_env, msg_user_recu, datemsg) VALUES (?, ?, ?, ?, ?)");
								$stmt->execute($dataMsg);

								Database::disconnect();
								
								$msg = "transfert effectué";

							}else{
								$msg2 = "Votre solde actuel est <b>".$_SESSION['montant']." fcfa</b> et ne vous permet pas de transferer <b>$montant</b> fcfa avec <b>$frais_transf</b> fcfa de frais de transfert.";
							}
						}else{
							$codeErreur = "Votre code de securité est incorrect";
						}
					}else{
						$depotErreur = "Le montant doit être compris entre:<br>1 et 100 000 fcfa";
					}
				}else{
					$depotErreur = "Valeur pas prise en charge";
				}
			}else{
				$emailErreur = "Désolé cet utilisateur <b>$mail</b> n'est pas inscrit sur notre plateforme";
			}
		}else{
			$emailErreur = "Désolé mais vous ne pouvez pas transferer <br> vous même de l'argent sur votre compte";
		}
	}else{
		$nomErreur = $prenomErreur = $emailErreur = $depotErreur = $usernamErreur = $codeErreur = $mdpErreur = $mdp2Erreur = "Remplicez tous les champs SVP" ;
	}
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
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <script src="../js/code.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/material-bootstrap-wizard.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<title>ACN | Transfert</title>
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
		
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="card card_member_trans">
						<form class="transfert" method="post" role="form" action="">

			            	<div class="text-success">
			            		<?php if (isset($msg)) {
									die($msg);
								}; ?>
			            	</div>

			            	<div class="text-info">
			            		<?php if (isset($msg2)) {
									die($msg2);
								}; ?>
			            	</div>

			            	<div class="row">
				            	<div class="float-right text-info">
				            		<span class="frais"></span>
				            	</div>
			            	</div>


			            	<div class="row" id="transfert">
				            	<div class="col-md-4">
					            	<div class="form-group">
					            		<label for="mail">Email de destination<span class="text-danger"> *</span></label>
					            		<input class="form-control" type="email" name="mail" id="mail" required>
					            		<small class="text-danger"><span class="help-inline"> <?php echo $emailErreur; ?> </span></small>
					            	</div>
				            	</div>
				            	<div class="col-md-4">
					            	<div class="form-group">
					            		<label for="montant">Montant: <span class="text-danger"> *</span></label>
					            		<small class="float-right"><small><b>min:</b>1 ,<b>max:</b> 100 000<b> Frais:</b> 1.2%</small></small>
					            		<input class="form-control" type="number" name="montant" id="montant" placeholder="1 000 fcfa" required>
					            		<small class="text-danger"><span class="help-inline"> <?php echo $depotErreur; ?> </span></small>
					            	</div>
				            	</div>
				            	<div class="col-md-4">
					            	<div class="form-group">
					            		<label for="code">Code de securité <span class="text-danger"> *</span></label>
					            		<input class="form-control" type="number" name="code" id="code" placeholder="ex: 13213" required>
					            		<small class="text-danger"><span class="help-inline"> <?php echo $codeErreur; ?> </span></small>
					            	</div>
				            	</div>
			            	</div>
			            	<div class="row">
				            	<div class="col-md-6">
				            		<button class="btn btn-success col-12" type="submit">Valider</button>
				            	</div>
				            	<div class="col-md-6">
				            		<a class="btn btn-danger col-12" href="index.php">Annuler</a>
				            	</div>
			            	</div>

			            </form>



			            <script type="text/javascript">

			            	inp = $('input[name=montant]')
			            	inp.on("keyup",function(){
			            		cal = (inp.val() * 1.2 / 100)
				            	$(".frais").text("Frais: "+cal+" fcfa")
			            	})
							            
			            </script>



					</div>
				</div>
			</div>
		</div>



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