<?php
	//Inclusion du fichier me permettant de me connecter à ma BDD.
	include 'connect_PDO.inc.php';
	
	//Test si l'on appuie sur le bouton retour
	if(isset($_POST['retour']))
	{
		//Redirige sur l'accueil
		header('Location: accueil.php');
	}
	
	//Test si l'on appuie sur le bouton deconnexion
	if(isset($_POST['deconnexion']))
	{
		//Redirige sur la page de connexion
		header('Location: connexion.php');
	}
	
	//Requête récuperant nom,prénom, du membre ainsi que toutes ses consommations depuis la dernière facture
	$query =	'SELECT quantite,dateConso,fkarticles,prixAchat,nomArticle
					FROM tblmembres
					INNER JOIN tblmembresarticles
					ON idMembre = fkmembres
					INNER JOIN tblarticles
					ON tblmembresarticles.fkarticles = tblarticles.idArticle
					WHERE Numbadge = '.$_SESSION['NBadge'].' AND DateFacturation = 0';
	$prep = $connexion->prepare($query);
	$prep->setFetchMode(PDO::FETCH_OBJ);
	$prep->execute();
	
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/historique.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" type="text/css" href="css/font-awesome-4.6.2/css/font-awesome.min.css"/>
</head>
	<?php


	?>
	<body>	
	
	<form id="form1" method="post" action="">
	<div class="class1">
		<div class="Montableau">
			<div class="tbl-header">
				<table>
					<tr>
						<th>Date</th>
						<th>Prix unitaire</th>
						<th>Qte</th>
						<th>Article</th>
						<th>Prix Total</th>
					</tr>
				</table>
				</div>
				<div class="tbl-content">
			<table>
			<tbody>
		<?php
		
			while($ligne = $prep->fetch())
			{
				$quantite = $ligne->quantite;
				$prix = $ligne->prixAchat;
				$dateConso = date("d.m.Y", strtotime($ligne->dateConso));
				$NomArticle = $ligne->nomArticle;
				$prixtotal = $prix * $quantite;	
				?>
							<tr>
								<td>					
									<?php echo $dateConso ;?>
								</td>
								<td>
									<?php echo $prix.'.-' ;?>
								</td>	
								<td>
									<?php echo $quantite; ?>
								</td>
								<td>					
									<?php echo $NomArticle; ?>
								</td>
								<td>
									<?php echo $prixtotal.'.-' ;?>
								</td>
							</tr>	
				<?php
			}
			
		?>
		</tbody>
		</table>
		</div>
</div>
	</div>
		<br>
	<div class="btnretour">
		<input type="submit" class="btn btn-primary" name="retour" value="Retour"/>		
		<input type="submit" class="btn btn-primary" name="deconnexion" value="Deconnexion"/>
	</div>
	</form>
	</body>
</html>
<script>
var timeout = 300; 
var time = 0;
document.onclick = function() {
    time = 0;
}
window.setInterval(timer, 1000);

function timer() {
    time++;
    if (time >= timeout) {
        document.location.href = "index.php";
    }
}
</script>