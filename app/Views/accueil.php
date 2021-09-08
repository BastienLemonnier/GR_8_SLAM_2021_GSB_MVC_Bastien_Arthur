<?php session_start(); ?>
<!DOCTYPEhtml>

<?php
	
	if( isset($_SESSION['connected']) ) {
		if($_SESSION['connected']) {
			
		}
	} else {
		unset($_SESSION['mois']);
	}
?>

<html lang = "fr">
	<head>
		<meta charset = "utf-8"/>
		<title>GSB</title>
		<link rel = "stylesheet" href = "<?php echo base_url('public/css/mainStyle.css'); ?>"/>
	</head>
	
	<body>
		<header>
			<h1>Page d'accueil et de connexion</h1>
		</header>
		
		<form action = <?php echo base_url("public/index.php");?> method = "post"><!-- formulaire de connexion -->
			<h2>Connexion</h2>
			
			<label for = "login">Login :</label>
			<input type = "text" id = "login" name = "connexion_login"/>
			<br/>
			
			<label for = "pswd">Mot de passe :</label>
			<input type = "password" id = "pswd" name = "connexion_password"/>
			<br/>
			
			<?php
				if( isset($_SESSION['error']) ) {
					switch($_SESSION['error']) {
						case 1 :
							echo "<span class='error'>Cet utilisateur n'existe pas.</span><br/>";
							break;
						case 2 :
							echo "<span class='error'>Mot de passe erroné.</span><br/>";
							break;
						case 3630 :
							echo "<span class='error'>Hého ! On ne joue pas avec les cookies !</span><br/>";
							break;
					}
				}
			?>
			
			<input type="submit" value="Se connecter"/>
		</form>
		
	</body>
</html>