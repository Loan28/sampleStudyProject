<?php
	//Inclusion du fichier me permettant de me connecter à ma BDD.
	include 'connect_PDO.inc.php';
	
	//Variable contenant la date d'aujoud'hui
	$date = date("Y-m-d");
	
	//Test si l'on appuie sur le bouton connexion
	if(isset($_POST['connexion']))
	{
		//Redirige sur la page de connexion
		header('Location: connexion.php');
	}
	
	//Requête récupérant les informations concernant: Les nom,prenom des membres ainsi que leur consommations d'aujourd'hui.
	$query =	'SELECT nomMembre,prenomMembre,quantite,dateConso,prixAchat,nomArticle
					FROM tblmembres
					INNER JOIN tblmembresarticles
					ON idMembre = fkmembres
					INNER JOIN tblarticles
					ON tblmembresarticles.fkarticles = tblarticles.idArticle 					
					WHERE DateFacturation = 0
					ORDER BY id DESC';
	$prep = $connexion->prepare($query);
	$prep->setFetchMode(PDO::FETCH_OBJ);
	$prep->execute();		

?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/index.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
	<body>	
		<form id="form1" method="post" action="">
				<div class="Montableau">
				<div class="tbl-header">
					<table>
							<tr>
								<th class="texttitre">Nom/Prénom</th>
								<th class="texttitre">Quantité</th>
								<th class="texttitre">Article</th>
								<th class="texttitre">Prix unitaire</th>
								<th class="texttitre">Prix total</th>
							</tr>
					</table>
				</div>
					<div class="tbl-content">
						<table>
							<tbody>
							<?php
								while($ligne = $prep->fetch())
								{
									//Toutes ses variables sont destinées à l'affichage.
									$nomArticle = $ligne->nomArticle;
									$quantite = $ligne->quantite;
									$prix = $ligne->prixAchat;
									$dateConso = $ligne->dateConso;
									$NomPrenom = $ligne->nomMembre.' '.$ligne->prenomMembre;
									$prixtotal = $prix * $quantite;	
									if($dateConso == $date)
									{
										?>
											<tr>
												<td>					
													<?php echo $NomPrenom ;?>												
												</td>
												<td>
												<?php echo $quantite; ?>
												</td>	
												<td>						
													<?php echo $nomArticle; ?>
												</td>
												<td>
													<?php echo $prix.'.-' ;?>
												</td>
												<td>
													<?php echo $prixtotal.'.-' ;?>
												</td>
											</tr>	
										<?php
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<br>
				<input type="submit" name="connexion" value="Connexion" class="btn btn-primary"/>
				<div class="label">Club nautique du Landeron</div>
		</form>
	</body>
</html>