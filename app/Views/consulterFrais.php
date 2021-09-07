<?php
	include("fonctions/openSession.php");
?>
<!DOCTYPEhtml>
<html lang = "fr">
	<head>
		<meta charset = "utf-8"/>
		<title>GSB</title>
		<link rel = "stylesheet" href = "mainStyle.css"/>
	</head>
	
	<body>
		<header>
			<h1>Page de consultation des frais</h1>
			<?php
				echo "<p>".$_SESSION['nom']." ".$_SESSION['prenom']."</p>";
			?>
		</header>
		
		<nav>
			<a href="fonctions/seDeconnecter.php">Se déconnecter</a>
		</nav>
		
		<form action = "consulterFrais.php" method = "post"><!-- formulaire de choix de mois -->
			<h2>Changer mois de consultation</h2>
			
			<label for = "month_select">Mois :</label>
			<select id = "month" name = "month_select" id = "month_select" >
				<?php
					
					$mois = [ 1 => "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];
					
					if( isset($_SESSION['mois']) ) {
						$moisChoisi = $_SESSION['mois'];
					} else {
						$moisChoisi = (int)date('m');
					}
					
					for( $i = 1; $i <= 12; $i ++ ) {
						if($i == $moisChoisi) {
							echo "<option value = '".$i."' selected >".$mois[$i]."</option>";
						} else {
							echo "<option value = '".$i."' >".$mois[$i]."</option>";
						}
					}
				
				?>
			</select>
			
			<input type = "submit" value = "Valider"/><br/>
			<a href="SaisirFrais.php">Saisie frais</a>
		</form>
		
		<div id="affichageFraisMois">
			
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
		<script>
			$( document ).ready(function(){
				loadAffichage();
			});
			
			$("#month").change(function(){
				loadAffichage();
			});
			
			function loadAffichage () {
				var mois = $("#month").val();
				
				$("#affichageFraisMois").load("data/getAllFrais.php?month=" + mois);
			}
		</script>
		
	</body>
</html>