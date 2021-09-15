<!DOCTYPEhtml>
<html lang = "fr">
	<head>
		<meta charset = "utf-8"/>
		<title>GSB</title>
		<link rel = "stylesheet" href = "<?php echo base_url('css/mainStyle.css'); ?>"/>
	</head>
	
	<body>
		<header>
			<h1>Page de consultation des frais</h1>
			<?php
				//affichage nom et prénom de l'utilisateur

				echo "<p>".$_SESSION['nom']." ".$_SESSION['prenom']."</p>";
			?>
		</header>
		
		<nav>
			<a href="<?php echo base_url ("index.php?action=deconnexion");?>">Se déconnecter</a>
		</nav>
		
		<form action = "<?php echo base_url ("index.php");?>" method = "post"><!-- formulaire de choix de mois -->
			<h2>Changer mois de consultation</h2>
			
			<label for = "month_select">Mois :</label>
			<select id = "month" name = "month_select" id = "month_select" >
				<?php
					$Modele = new \App\Models\Modele();
					for( $i = 1; $i <= 12; $i ++ ) {
						if($i == $_SESSION['mois']['num']) {
							echo "<option value = '".$i."' selected >".$Modele::LISTEMOIS[$i]."</option>";
						} else {
							echo "<option value = '".$i."' >".$Modele::LISTEMOIS[$i]."</option>";
						}
					}
				
				?>
			</select>
			
			<input type = "submit" value = "Valider"/><br/>
			<a href="<?php echo base_url ("index.php?action=saisirFrais");?>">Saisie frais</a>
		</form>
		
		<div id="affichageFraisMois">
			<?php include("sectionFraisMois.php"); ?>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
		<script>
			$("#month").change(function(){
				loadFraisMois();
			});
			
			function loadFraisMois () {
				var mois = $("#month").val();

				$("#affichageFraisMois").load("<?php echo base_url("index.php?action=getFraisMois&mode=ajax&mois="); ?>" + mois);
			}
		</script>
		
	</body>
</html>