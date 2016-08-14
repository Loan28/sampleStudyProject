<?php
	
	//Inclusion du fichier me permettant de me connecter à ma BDD.
	include 'connect_PDO.inc.php';
	
	//Variable contenant la date d'aujoud'hui
	$date = date("d.m.Y");
	
	//Requête récupérant les articles de la BDD qui sont actifs
	$query =	'SELECT idArticle,nomArticle,prixArticle
					FROM tblarticles 
					WHERE Activite = "0"';
	$prep = $connexion->prepare($query);
	$prep->setFetchMode(PDO::FETCH_OBJ);
	$prep->execute();

	//Test si l'utilisateur appuie sur le bouton retour
	if(isset($_POST['retour']))
	{
		header('Location: Accueil.php');
	}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/gerer.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome-4.6.2/css/font-awesome.min.css"/>
</head>
	<?php


	?>
	<body>	
	<form method = "POST" action="">
	<form id="form1" method="GET" action="">
	<div class="Montableau">
	<div class="tbl-header">
		<table>
		<table>
			<tr>
				<th>Nom article</th>
				<th>Prix</th>
				<th>Gérer</th>
			</tr>
					</table>
	</div>
	<div class="tbl-content">
		<table>
		<?php
			while($ligne = $prep->fetch())
			{
				$Article = $ligne->nomArticle;
				$prix = $ligne->prixArticle;
					?>
						<tr>
							<td>					
								<input name="Membre" type="text" readonly="true" class="borderless" value="<?php echo $Article ;?>"/>	
							</td>
							<td>
								<input name="Nbadge" type="text" readonly="true" class="borderless" value="<?php echo $prix; ?>"/>
							</td>
								<div class="modificone">							
							<td>				
								<a href="modifarticle.php?idarticle=<?php echo $ligne->idArticle; ?>&action=modif"><i class="fa fa-pencil-square fa-3x" aria-hidden="true"></i></a>
								&nbsp;
								<a href="modifarticle.php?idarticle=<?php echo $ligne->idArticle; ?>&action=del"><i class="fa fa-times-circle fa-3x" aria-hidden="true"></i></a>
							</td>
							</div>
						</tr>	
					<?php
				
			}
			
		?>
		</table>

	</div>
			<br>
			
			<input type="button" class="btn btn-primary" name="lien1" value="Ajouter un article" onclick="self.location.href='modifarticle.php?action=add'"> 
			<span class="retour"><input type="submit" class="btn btn-primary" name="retour" value="Retour"/>	</span>
	</form>
	</form>
	</body>
</html>