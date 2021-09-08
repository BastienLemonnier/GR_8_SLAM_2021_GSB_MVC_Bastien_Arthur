<?php
	include("fonctions/openSession.php");
	
	include("fonctions/recupMoisCourant.php");
?>
<!DOCTYPEhtml>
<html lang = "fr">
	<head>
		<meta charset="utf-8">
		<title>GSB</title>
		<link rel = "stylesheet" href = "<?php echo base_url('public/css/mainStyle.css'); ?>"/>
	</head>
	
	<body>
		<header>
			<h1>Page de saisie des frais</h1>
		</header>
		
		<nav>
			<a href="fonctions/seDeconnecter.php">Se déconnecter</a> / 
			<a href="consulterFrais.php">Consultation frais</a>
		</nav>
		
		<form action="fonctions/envoyerFrais.php" method="post" >
			<h2>Frais forfaitaires du mois de <?php echo $moisCourant; ?> :</h2>
			
			<label for="etapes">Nombre d'étapes :</label>
			<input type="number" id="etapes" name="nombre_etapes" value="<?php echo $Etapes;?>"/><br/>
			
			<label for="km">Nombre kilomètres :</label>
			<input type="number" id="km" name="nombre_km" value="<?php echo $Km;?>"/> Km<br/>
			
			<label for="nuitee">Nombre nuitées hors étapes :</label>
			<input type="number" id="nuitee" name="nombre_nuitee" value="<?php echo $Nuitee;?>"/><br/>
			
			<label for="repas">Nombre repas hors étapes :</label>
			<input type="number" id="repas" name="nombre_repas" value="<?php echo $Repas;?>"/><br/>
			
			<input type="submit" value="Envoyer"/>
		</form>
		
		<form action="fonctions/envoyerAutreFrais.php" method="post" >
			<h2>Autres frais :</h2>
			
			<label for="libelle">Libellé :</label>
			<input type="text" id="libelle" name="libelle_frais"/><br/>
			
			<label for="date">Date :</label>
			<input type="date" id="date" name="date_frais"/><br/>
			
			<label for="prix">Prix :</label>
			<input type="number" id="prix" name="prix_frais" value="0"/> €<br/>
			
			<input type="submit" value="Envoyer"/>
		</form>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
		<script>
			$("#etapes").change(function() {
				$.post( "fonctions/changeNbEtapes.php", { 'nombre_etapes': $("#etapes").val() } );
			});
			$("#km").change(function() {
				$.post( "fonctions/changeNbKm.php", { 'nombre_km': $("#km").val() } );
			});
			$("#nuitee").change(function() {
				$.post( "fonctions/changeNbNuitee.php", { 'nombre_nuitee': $("#nuitee").val() } );
			});
			$("#repas").change(function() {
				$.post( "fonctions/changeNbRepas.php", { 'nombre_repas': $("#repas").val() } );
			});
		</script>
	</body>
</html>