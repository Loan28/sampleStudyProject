<?php
	session_start();
	
	//Inclusion du fichier me permettant de me connecter à ma BDD.
	include 'connect_PDO.inc.php';
	
	//Variable contenant la date du jour
	$date = date("Y-m-d");
	
	//Test si l'utilisateur appuie sur le bouton Historique, si oui le redirige sur la page historique.php
	if(isset($_POST['Historique']))
	{
		header('Location: historique.php');
	}
	
	//Test si l'utilisateur appuie sur le bouton facturation, si oui le redirige sur la page facturation.php
	if(isset($_POST['facturation']))
	{
		header('Location: facturation.php');
	}
	
	//Test si l'utilisateur appuie sur le bouton membre, si oui le redirige sur la page gerermembre.php
	if(isset($_POST['membre']))
	{
		header('Location: gerermembre.php');
	}
	
	//Test si l'utilisateur appuie sur le bouton article, si oui le redirige sur la page gererarticle.php
	if(isset($_POST['article']))
	{
		header('Location: gererarticle.php');
	}
	
	//Test si l'utilisateur appuie sur le bouton sauvegarde, si oui le redirige sur la page backup.php
	if(isset($_POST['sauvegarde']))
	{
		header('Location: backup.php');
	}
	//Requête récuperant le nom,prénom du membre ainsi que ses consomations journalière
	$query =	'SELECT nomMembre,prenomMembre,quantite,dateConso,fkarticles
					FROM tblmembres
					INNER JOIN tblmembresarticles
					ON idMembre = fkmembres
					INNER JOIN tblarticles
					ON tblmembresarticles.fkarticles = tblarticles.idArticle
					WHERE Numbadge = '.$_SESSION['NBadge'].' AND DateFacturation = 0';
	$prep = $connexion->prepare($query);
	$prep->setFetchMode(PDO::FETCH_OBJ);
	$prep->execute();
	$i = 0;
	$tabIdArticleConso = array();
	while($ligne = $prep->fetch())
	{
		// Test si la date de consommation correspond à aujoud'hui.
		if($ligne->dateConso == $date)
		{	
			//Tableau contenant les quantités consommées
			$tabQuantite[$i] = $ligne->quantite; 
			
			//Tableau contenant les article consommés
			$tabIdArticleConso[$i] = $ligne->fkarticles;
			$i++;
		}
	}
	
	//Requête récuperant le nom des articles
	$query2 = 'SELECT idArticle,nomArticle
				FROM tblarticles
				WHERE Activite = "0"';
	$prep2 = $connexion->prepare($query2);
	$prep2->setFetchMode(PDO::FETCH_OBJ);
	$prep2->execute();
	$i = 0;
	while($ligne = $prep2->fetch())
	{	
		//Tableau contenant le nom des articles
		$tabNomArticle[$i] = $ligne->nomArticle;
		
		//Tableau contenant l'id des articles
		$tabIdArticle[$i] = $ligne->idArticle;
		$i++;
	}	
	
	
	/* Variable qui va permettre de savoir si l'on doit update 
	ou ajouter lorsque l'on consomme plus d'un élément à un article pas consommé aujourd'hui */
	$testnul = "pasajout";
	
	//Test si l'utilisateur a appuyé sur le bonton "ok"
	if(isset($_POST['ok']))
	{
		//Requête récuperant l'id des articles en vente
		$querytest = 'SELECT prixArticle,idArticle FROM tblarticles';
		$preptest = $connexion->prepare($querytest);
		$preptest->setFetchMode(PDO::FETCH_OBJ);
		$preptest->execute();
		while($ligne = $preptest->fetch())
		{	
			//Variable contenant l'id des articles en vente
			$id = $ligne->idArticle;
			$prix = $ligne->prixArticle;
			//Variable contenant la quantité de boisson consommé
			$qte = $_POST[''.$id.''];
			
			//Test si la variable action que la fonction javascript AddDim renvoit "update" 
			if($_POST['action'.''.$id.''] == 'update')
			{
				//Requête pour savoir si l'article a déjà été consommé
				$queryAddOrModif = 'SELECT id FROM tblmembresarticles WHERE fkarticles = "'.$id.'" AND fkmembres = "'.$idMembreCo.'" ';
				$prepupAddOrModif = $connexion->prepare($queryAddOrModif);
				$prepupAddOrModif->execute();
				$ligne = $prepupAddOrModif->fetch();
				
				if($ligne == NULL)
				{
					//Requête pour ajouter une consommation dans notre BDD
					$queryAjout ='INSERT INTO tblmembresarticles SET fkmembres = :fkmembres, fkarticles = :fkarticles, dateConso = :dateConso, quantite = :quantite, DateFacturation = :DateFacturation, prixAchat = :prixAchat';
					$prepAjout = $connexion->prepare($queryAjout);
					$prepAjout->setFetchMode(PDO::FETCH_OBJ);
					$prepAjout->bindValue(':fkmembres',$idMembreCo);
					$prepAjout->bindValue(':fkarticles',$id);
					$prepAjout->bindValue(':dateConso',$date);
					$prepAjout->bindValue(':quantite',$qte);
					$prepAjout->bindValue(':DateFacturation','0');
					$prepAjout->bindValue(':prixAchat',$prix);
					$prepAjout->execute();
					$testnul = "pasajout";
				}
				else
				{
					//Requête qui modifie le nombre d'article consommé dans notre BDD
					$queryUpdate = 'UPDATE tblmembresarticles SET quantite = "'.$qte.'" WHERE fkarticles = "'.$id.'" AND fkmembres = "'.$idMembreCo.'"';
					$prepupdate = $connexion->prepare($queryUpdate);
					$prepupdate->execute();
				}
			}
			else
			{
				//Test si la variable action que la fonction javascript AddDim renvoit "add" 
				if($_POST['action'.''.$id.''] == 'add')
				{
					//Requête pour ajouter une consommation dans notre BDD
					$queryAjout ='INSERT INTO tblmembresarticles SET fkmembres = :fkmembres, fkarticles = :fkarticles, dateConso = :dateConso, quantite = :quantite, DateFacturation = :DateFacturation, prixAchat = :prixAchat';
					$prepAjout = $connexion->prepare($queryAjout);
					$prepAjout->setFetchMode(PDO::FETCH_OBJ);
					$prepAjout->bindValue(':fkmembres',$idMembreCo);
					$prepAjout->bindValue(':fkarticles',$id);
					$prepAjout->bindValue(':dateConso',$date);
					$prepAjout->bindValue(':quantite',$qte);
					$prepAjout->bindValue(':DateFacturation','0');
					$prepAjout->bindValue(':prixAchat',$prix);
					$prepAjout->execute();
					$testnul = "pasajout";
				}
				
				//Test si la variable action que la fonction javascript AddDim renvoit "drop" 
				elseif($_POST['action'.''.$id.''] == 'drop')
				{
					$querydrop = 'DELETE FROM tblmembresarticles WHERE fkarticles = "'.$id.'" AND fkmembres = "'.$idMembreCo.'" ';
					$prepdrop = $connexion->prepare($querydrop);
					$prepdrop->execute();
				}
			}
		}
		header('Location: index.php');
	}	
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/accueil.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
   <link rel="stylesheet" type="text/css" href="css/font-awesome-4.6.2/css/font-awesome.min.css"/>
</head>
	<body>	
		<form id="form1" method="post" action="">
		<div class="gauche">
			<strong class="texttitre">Club nautique du Landeron</strong>	
			<div class="membre">
				<?php
					//Affichage du prénom/nom du membre en haut à droite
				echo 'Bienvenue<br> <strong>'.$_SESSION['Membre'].'!</strong> ';
				?>
			</div>
			<div class ="boutoncentre">
				
				<br>
				<br>					
				<?php
					//Si le membre connecté est le caissier ou le superviseur le bouton facturation est activé
					if($_SESSION['type'] == 'Caissier')
					{
						echo '<input class="btn historique" type="submit" name="Historique" value="Historique de consommation"/>
						<br><br><input class="btn historique" type="submit" name="facturation" value="Facturation" />';
						echo "<br>";
						echo "<br>";
					}
					elseif($_SESSION['type'] == 'Superviseur')
					{
						echo '<input class="btn historiqueAdmin" type="submit" name="Historique" value="Historique de consommation"/>';
						echo '<br><br><div class="btnAdmin"><input class="btn btnsecondaire" type="submit" name="facturation" value="Facturation" />&nbsp;';
						echo '<input class="btn btnsecondaire" type="submit" name="membre" value="Gérer membre" />&nbsp;';		
						echo '<br><br><input class="btn btnsave" type="submit" name="sauvegarde" value="Sauvegarde" />&nbsp;';
						echo '<input class="btn btnsave" type="submit" name="article" value="Gérer article" />&nbsp;</div>';
					}
					else
					{

						echo "<input class=\"btn historique\" type=\"submit\" name=\"Historique\" value=\"Historique de consommation\"/><br>";
						echo "<br>";
						echo "<br>";
					}
				?>
			</div>
		</div>
			<?php
				if($_SESSION['type'] == 'Superviseur')
				{
					echo '<div class="tableau3">';
				}
				else
				{
					echo '<div class="tableau">';
				}
			?>
			<i class="titretableau">Consommations</i>
				<table>		
					<tr>
						<th>Article</th>
						<th></th>
						<th>Quantité</th>
					</tr>			
				</table>
				<div class="tableau2">
					<table class="">
						<?php 
						$j = 0;
						foreach($tabNomArticle as $nomArticle)
						{
							$estconsommer = false;
						?>			
							<tr>
								<td><?php echo $nomArticle;?></td>			
								<?php 
									$i = 0;
									
									//Boucle pour chercher les articles consommé
									foreach($tabIdArticleConso as $idArticle)
									{
										//Test si l'article a été consommé
										if($idArticle == $tabIdArticle[$j] )
										{
											//Variable contenant le nombre de fois que l'article a été consommé
											$quantite[$j] = $tabQuantite[$i];											
											$estconsommer = true;
										}
										$i++;	
									}
									//Test si l'article n'a pas été consommer
									if($estconsommer == false)
									{
										$quantite[$j] = 0;
									}								
								?>
									<td><span class="text"><button class="btn btnplusmoin" type="button" id="-" value="-" onclick="AddDim('-','<?php echo 'article'.$tabIdArticle[$j]; ?>','<?php echo $tabIdArticle[$j]; ?>');"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></button></td></span>
									<td>
										<input name="<?php echo $tabIdArticle[$j] ?>" type="text" readonly="true" class="borderless" id="<?php echo 'article'.$tabIdArticle[$j]; ?>" value="<?php echo $quantite[$j]; ?>"/>
										<input name="<?php echo 'action'.$tabIdArticle[$j] ?>" type="hidden" id="<?php echo 'action'.$tabIdArticle[$j] ;?>" value="" />
										<input name="<?php echo 'testnul'.$tabIdArticle[$j]; ?>" type="hidden" id="<?php echo 'testnul'.$tabIdArticle[$j] ;?>" value="<?php echo $testnul ?>"/>
									</td>
									<td><span class="text"><button class="btn btnplusmoin" type="button" id="+" value="+" onclick="AddDim('+','<?php echo 'article'.$tabIdArticle[$j]; ?>','<?php echo $tabIdArticle[$j]; ?>');" ><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></button></span></td>
							</tr>	
								<?php
										$j++;
						}
								?>
					</table>
				</div>
			</div>		
			<div class="ok"><input class="btn btnsecondaire" type="submit" name="ok" value="OK!"/></div>				

	</form>
	</body>
</html>
		<script language=Javascript>
		//Fonction permettant d'ajouter/retirer un article
		function AddDim(idBut,idQte,idArticle) 
		{ 
			var action = document.getElementById(idBut).value;
			var qte = document.getElementById(idQte).value;
			var hiddenInput = "testnul"+idArticle;
			var hiddenInput2 = "action"+idArticle;
			var testaction = parseInt(qte);
			var testnul = document.getElementById(hiddenInput).value;
			
			if(action == '+')
			{
				if(parseInt(qte) < 99)
				{
					var qteFinal = parseInt(qte) + 1;
				}
				else
				{
					var qteFinal = 99;
				}
			}
			else
			{
				if(parseInt(qte) > 0)
				{
					var qteFinal = parseInt(qte) - 1;
				}
				else
				{
					var qteFinal = 0;
				}
			}
			if(testaction == 0)
			{
				var action = "add";			
				document.getElementById("form1").elements[hiddenInput].value = "ajout";
			}
			else
			{
				if(testnul == "ajout")
				{
					var action = "add";
				}
				else
				{
					var action = "update";
				}
			}
			if(qteFinal == 0)
			{
				var action = "drop";
			}
			document.getElementById("form1").elements[idQte].value = qteFinal;
			document.getElementById("form1").elements[hiddenInput2].value = action;
		} 
</script>
<script>
//Script pour déconnecter l'utilisateur après 5 minutes d'inactivité.
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