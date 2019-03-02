<?php

session_start();


if ($_SESSION['username']) {

require "../database.php";


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
	<title>ACN | Transactions</title>
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
	  				<a class="text-dark" href="administration.php">accueil</a>
	  			</li>
		    	<li class="nav-link">
	  				<a class="text-dark" href="listuser.php">utilisateurs</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="transaction.php">voir les transactions</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="bonus.php">faire des bonus</a>
	  			</li>
		    </ul>
		    <div class="ml-auto">
	  			<a class="btn btn-outline-dark" href="../member/logout.php"><span class="fa fa-sign-out"></span></a>
		    </div>
		  </div>
		</nav>

	</header>
	<div class="image-container set-full-height" style="background: url(../img/admin_img.jpg) top center; height: auto; overflow: hidden;">
		
		
		<div class="container-fluid">
		  <div class="col-sm-12">
		    <div class="card card_member">
		      <div class="card-body">
		        <h4 class="card-title">Les transactions</h4>
		        <input class="form-control col-md-4 offset-md-4" type="search" name="recherche" placeholder="recherche">
		        <!-- <h4 class="float-right d-inline">
		        	<form class="form-inline">
		        		<button class="btn btn-warning" type="submit"><span class="fa fa-search"></span></button>
		        	</form>
		        </h4> -->
		        <p class="card-text">
		        	<table class="table table-striped">
					  <thead>
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Destinateurs</th>
					      <th scope="col">Destinataires</th>
					      <th class="cacher" scope="col">Montant</th>
					      <th class="cacher" scope="col">Date</th>
					    </tr>
					  </thead>
					  
					  

					   <?php 
						  		$db 			= Database::connect();
						  		$res 			= $db->query("SELECT u.username, t.email, t.montant, t.datetr FROM transactions t INNER JOIN users u ON t.user = u.id ORDER BY t.datetr DESC");
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
											      <td class="key">'.$resultats[$i]["username"].'</td>
											      <td class="key">'.$resultats[$i]["email"].'</td>
											      <td class="cacher">'.$resultats[$i]["montant"].' fcfa</td>
											      <td class="cacher">'.$resultats[$i]["datetr"].'</td>
											    </tr>
							  				';
							  	}
							  	echo "</tbody>";

						?>

					</table>
		        </p>
		        

		        <script type="text/javascript">
    				// recherche dans le tableau
				    $("input").keyup(function(){
				        _this = this;
				        $.each($("table tbody tr"), function() {
				            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
				               $(this).hide();
				            else
				               $(this).show();                
				        });
				    }); 
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