<!DOCTYPEhtml>

<html lang = "fr">
	<head>
		<meta charset = "utf-8"/>
		<title>GSB</title>
		<link rel = "stylesheet" href = "<?php echo base_url('css/mainStyle.css'); ?>"/>
	</head>
	
	<body>
		<header>
			<h1>Page d'accueil et de connexion</h1>
		</header>

		<img src="<?php echo base_url("img/logo2.png");?>" alt="Logo GSB" width="30%" style="display: block;margin: 20px auto;"></img>
		
		<form action = <?php echo base_url("index.php");?> method = "post"><!-- formulaire de connexion -->
			<h2>Connexion</h2>
			
			<label for = "login">Login :</label>
			<input type = "text" id = "login" name = "connexion_login"/>
			<br/>
			
			<label for = "pswd">Mot de passe :</label>
			<input type = "password" id = "pswd" name = "connexion_password"/>
			<br/>
			
			<?php
				echo "<span class='error'>" . $_SESSION['error'] . "</span><br/>";
			?>
			
			<input type="submit" value="Se connecter"/>
		</form>
		
	</body>
</html>