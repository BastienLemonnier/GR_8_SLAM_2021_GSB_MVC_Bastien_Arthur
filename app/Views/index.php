<?php session_start(); ?>
<!DOCTYPEhtml>

<?php
	if( isset($_SESSION['connected']) ) {
		if($_SESSION['connected']) {
			header ('Location: consulterFrais.php');
			exit();
		}
	} else {
		unset($_SESSION['mois']);
	}
?>

<html lang = "fr">
	<head>
		<meta charset = "utf-8"/>
		<title>GSB</title>
		<link rel = "stylesheet" href = "mainStyle.css"/>
	</head>
	
	<body>
		<header>
			<h1>Page d'accueil et de connexion</h1>
		</header>
		
		<form action = "fonctions/seConnecter.php" method = "post"><!-- formulaire de connexion -->
			<h2>Connexion</h2>
			
			<label for = "login">Login :</label>
			<input type = "text" id = "login" name = "user_login"/>
			<br/>
			
			<label for = "pswd">Mot de passe :</label>
			<input type = "password" id = "pswd" name = "user_password"/>
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