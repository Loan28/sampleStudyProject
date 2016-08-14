<?php
	//Test si l'on appuie sur le bouton retour
	include 'connect_PDO.inc.php';
	$erreur = "";
	//Test si l'on appuie sur le bouton retour
	if(isset($_POST['retour']))
	{
		//Redirige sur l'accueil
		header('Location: gererarticle.php');
	}
	
	//Test si l'utilisateur appuie sur le bouton modifier
	if(isset($_POST['Modifier']))
	{
		//Test si le prix est plus éléver que 0.
		if($_POST['prixArticle'] < 0)
		{
			$erreur = "Le prix d'un article doit être positif.";
		}
		else
		{
			//Modifie l'article dans la BDD
			$queryModif ='UPDATE tblarticles SET 
						nomArticle = :nomArticle, 
						prixArticle = :prixArticle
						WHERE idArticle = "'.$_GET['idarticle'].'"';
			$prepModif = $connexion->prepare($queryModif);
			$prepModif->setFetchMode(PDO::FETCH_OBJ);
			$prepModif->bindValue(':nomArticle',$_POST['nomArticle']);
			$prepModif->bindValue(':prixArticle',$_POST['prixArticle']);
			$prepModif->execute();
			header('Location: gererarticle.php');
		}
	}
	
	//Test si l'utilisateur appuie sur le bouton Ajouter
	if(isset($_POST['Ajouter']))
	{
		//Test si le prix est plus éléver que 0.
		if($_POST['prixArticle'] < 0)
		{
			$erreur = "Le prix d'un article doit être positif.";
		}
		else
		{
			//Ajoute l'article dans la BDD
			$queryAjout ='INSERT INTO tblarticles SET 
						nomArticle = :nomArticle, 
						prixArticle = :prixArticle';
			$prepAjout = $connexion->prepare($queryAjout);
			$prepAjout->setFetchMode(PDO::FETCH_OBJ);
			$prepAjout->bindValue(':nomArticle',$_POST['nomArticle']);
			$prepAjout->bindValue(':prixArticle',$_POST['prixArticle']);
			$prepAjout->execute();
			header('Location: gererarticle.php');
		}
	}

?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" type="text/css" href="css/modifier.css" />

</head>
	
	<?php
	//
	//Test si l'on doit afficher la page pour une modification
	if($_GET['action'] == 'modif')
	{
		$affichage = 1;
		$query = 'SELECT nomArticle,prixArticle
			FROM tblarticles
			WHERE idArticle = "'.$_GET['idarticle'].'"';
		$prep = $connexion->prepare($query);
		$prep->setFetchMode(PDO::FETCH_OBJ);
		$prep->execute();
		$ligne = $prep->fetch();
		$Nom = $ligne->nomArticle;
		$Prix = $ligne->prixArticle;
		$readonly = 'readonly = "true"';
		$submit = 'Modifier';
	}
	//
	//Test si l'on doit afficher la page pour un ajout
	if($_GET['action'] == 'add')
	{
		$affichage = 1;
		$Nom ="";
		$Prix = "";
		$readonly = '';
		$submit = 'Ajouter';
	}
	//
	//Test si l'on doit afficher la page pour une suppression
	if($_GET['action'] == 'del')
	{
		$affichage = 2;
		$query = 'SELECT nomArticle
			FROM tblarticles
			WHERE idArticle = "'.$_GET['idarticle'].'"';
		$prep = $connexion->prepare($query);
		$prep->setFetchMode(PDO::FETCH_OBJ);
		$prep->execute();
		
		//test si l'utilisateur confirme la suppresion
		if(isset($_POST['delete']))
		{
			//Requête qui passe l'article en mode inactif.
			$queryDel ='UPDATE tblarticles SET 
						Activite = "1"
						WHERE idArticle = "'.$_GET['idarticle'].'"';
			$prepDel = $connexion->prepare($queryDel);
			$prepDel->setFetchMode(PDO::FETCH_OBJ);
			$prepDel->execute();
			header('Location: gererarticle.php');
		}
	}
	?>
	<body>	
	<form id="form1" method="post" action="">
	<?php 
	
	//Si l'affichage est un ajout ou une modification
	if($affichage == 1)
	{
	?>
		<div class="div1">
		
		<label>Article: </label>
		<input type="text" name="nomArticle" class="" value="<?php echo $Nom; ?>"/>
		<span class="inputtext2">
		<label>Prix: </label>
		<input type="text" name="prixArticle" class="" value="<?php echo $Prix; ?>" />
		</span>
		<?php echo $erreur;?>
		<br>
		<br>	
		<br>
		</div>
		<input class="btn btnprimary" type="submit" name="<?php echo $submit; ?>" value="Confirmer"/>
		<input class="btn btnprimary" type="submit" name="retour" value="Retour"/>

		
	<?php
	}
	else
	{
	?>
	<div>
	<p>Êtes-vous sur de vouloir supprimer l'article: <?php $ligne = $prep->fetch(); echo $ligne->nomArticle;?></p>
	<input class="btn btnprimary" type="submit" name="delete" value ="Oui"/>
	<input class="btn btnprimary" type="submit" name="retour" value="Retour"/>
	</div>
	<?php 
	}
	?>
	
	</body>
	</form>
</html>