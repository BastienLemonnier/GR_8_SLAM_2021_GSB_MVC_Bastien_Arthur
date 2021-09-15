<!DOCTYPEhtml>
<html lang = "fr">
	<head>
		<meta charset="utf-8">
		<title>GSB</title>
		<link rel = "stylesheet" href = "<?php echo base_url('css/mainStyle.css'); ?>"/>
	</head>
	
	<body>
		<header>
			<h1>Page de saisie des frais</h1>
		</header>
		
		<nav>
			<a href="<?php echo base_url ("index.php?action=deconnexion");?>">Se déconnecter</a>
			<a href="<?php echo base_url ("index.php?action=consulterFrais");?>">Consultation frais</a>
		</nav>
		
		<form action="<?php echo base_url ("index.php");?>" method="post" >
			<h2>Frais forfaitaires du mois de <?php echo $_SESSION['mois']['libelle']; ?> :</h2>
			
			<label for="etapes">Nombre d'étapes :</label>
			<input type="number" id="etapes" name="nombre_etapes" value="<?php echo $_SESSION['FraisForfait']['ETP'];?>"/><br/>
			
			<label for="km">Nombre kilomètres :</label>
			<input type="number" id="km" name="nombre_km" value="<?php echo $_SESSION['FraisForfait']['KM'];?>"/> Km<br/>
			
			<label for="nuitee">Nombre nuitées hors étapes :</label>
			<input type="number" id="nuitee" name="nombre_nuitee" value="<?php echo $_SESSION['FraisForfait']['NUI'];?>"/><br/>
			
			<label for="repas">Nombre repas hors étapes :</label>
			<input type="number" id="repas" name="nombre_repas" value="<?php echo $_SESSION['FraisForfait']['REP'];?>"/><br/>
			
			<input type="submit" value="Envoyer"/>
		</form>
		
		<form action="<?php echo base_url ("index.php");?>" method="post" >
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
				$.post( "<?php echo base_url ("index.php?mode=ajax");?>", { 'nombre_etapes': $("#etapes").val() } );
			});
			$("#km").change(function() {
				$.post( "<?php echo base_url ("index.php?mode=ajax");?>", { 'nombre_km': $("#km").val() } );
			});
			$("#nuitee").change(function() {
				$.post( "<?php echo base_url ("index.php?mode=ajax");?>", { 'nombre_nuitee': $("#nuitee").val() } );
			});
			$("#repas").change(function() {
				$.post( "<?php echo base_url ("index.php?mode=ajax");?>", { 'nombre_repas': $("#repas").val() } );
			});
		</script>
	</body>
</html>