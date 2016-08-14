<?php
	
	//Test si l'on appuie sur le bouton retour
	include 'connect_PDO.inc.php';
	
	//Variable pour savoir si le badge est utilisé ou non.
	$boolBadge = false;
	//Variable contenant la date d'aujoud'hui
	$erreur = NULL;
	//Test si l'on appuie sur le bouton retour
	if(isset($_POST['retour']))
	{
		//Redirige sur l'accueil
		header('Location: gerermembre.php');
	}
	
	//Test si l'utilisateur a cliqué sur le bouton delete
	if(isset($_POST['delete']))
	{
		//Requête qui passe le membre en mode inactif.
		$queryDel ='UPDATE tblmembres SET 
					Activite = "1"
					WHERE idMembre = "'.$_GET['idmembre'].'"';
		$prepDel = $connexion->prepare($queryDel);
		$prepDel->setFetchMode(PDO::FETCH_OBJ);
		$prepDel->execute();
		header('Location: gerermembre.php');
	}
	else
	{
		//Test si c'est un ajout ou une modification
		if(isset($_POST['Modifier']) || isset($_POST['Ajouter']))
		{
			if(isset($_POST['Modifier']))
			{
				//Requête pour récuperer le numéro de badge du membre modifié
				$querybadge ='SELECT numbadge from tblmembres 
							WHERE Activite = 0 AND idMembre != "'.$_GET['idmembre'].'"  ';
			}
			else
			{
				//Requête qui récupère tous les numéro de badge
				$querybadge ='SELECT numbadge from tblmembres 
							WHERE Activite = 0';
			}
			$prepbadge = $connexion->prepare($querybadge);
			$prepbadge->setFetchMode(PDO::FETCH_OBJ);
			$prepbadge->execute();
			while ($ligne = $prepbadge->fetch())
			{
				$Numbadge = $ligne->numbadge;
				//Si le numéro de badge entré correspond à l'un des badge de la base de donnée la modification est impossible.
				if($Numbadge == $_POST['numBadge'])
				{			
					$erreur = "Le numéro de badge que vous voulez attribuer est déjà utilisé.";
					$boolBadge = true;
				}		
			}
		}
	}
	//Test si l'utilisateur a appuyé sur le bouton modifier.
	if(isset($_POST['Modifier']))
	{
		//Test si l'utilisateur a modifier le type pour un nouveau caissier, l'ancien est supprimer
		if($_POST['type'] == '2')
		{
			$queryModifType = 'UPDATE tblmembres SET  
								fkTypeMembre = 1
								WHERE fkTypeMembre = :fkTypeMembre ';
			$prepModifType = $connexion->prepare($queryModifType);
			$prepModifType->bindValue(':fkTypeMembre',$_POST['type']);
			$prepModifType->execute();
		}
		//Test si l'utilisateur a modifier le type pour un nouveau Superviseur, l'ancien est supprimer
		elseif($_POST['type'] == '3')
		{
			$queryModifType = 'UPDATE tblmembres SET  
								fkTypeMembre = 1
								WHERE fkTypeMembre = :fkTypeMembre ';
			$prepModifType = $connexion->prepare($queryModifType);
			$prepModifType->bindValue(':fkTypeMembre',$_POST['type']);
			$prepModifType->execute();
		}
			//Test si le badge n'est pas utilisé on modifie le membre dans la bdd
			if($boolBadge == false)
			{
					$queryModif ='UPDATE tblmembres SET 
					rue = :rue, 
					numbadge = :numBadge,
					npa = :npa, 
					localite = :localite, 
					email = :email, 
					dateentre = :dateinscription, 
					telephone = :telephone,
					fkTypeMembre = :fkTypeMembre
					WHERE idMembre = "'.$_GET['idmembre'].'"';
					$prepModif = $connexion->prepare($queryModif);
					$prepModif->setFetchMode(PDO::FETCH_OBJ);
					$prepModif->bindValue(':rue',$_POST['rue']);
					$prepModif->bindValue(':numBadge',$_POST['numBadge']);
					$prepModif->bindValue(':npa',$_POST['npa']);
					$prepModif->bindValue(':localite',$_POST['localite']);
					$prepModif->bindValue(':email',$_POST['email']);
					$prepModif->bindValue(':dateinscription',$_POST['dateinscription']);
					$prepModif->bindValue(':telephone',$_POST['telephone']);
					$prepModif->bindValue(':fkTypeMembre',$_POST['type']);
					$prepModif->execute();
					header('Location: gerermembre.php');
			}
		
	}
	//Test si l'utilisateur a appuyé sur le bouton ajouter.
	if(isset($_POST['Ajouter']))
	{
		//Test si tous les champs sont remplis
		if($_POST['nomMembre'] == NULL  OR $_POST['prenomMembre'] == NULL
								OR $_POST['rue'] == NULL 
								OR $_POST['npa'] == NULL
								OR $_POST['localite'] == NULL
								OR $_POST['email'] == NULL
								OR $_POST['dateinscription'] == NULL
								OR $_POST['tel'] == NULL
								)						
		{
			$erreur = "Veuillez remplire tout les champs";
		}	
		else
		{	
			//Test si le badge n'est pas utilisé on modifie le membre dans la bdd, si oui l'on ajoute un nouveau membre dans la BDD
			if($boolBadge == false)
			{
				$erreur = NULL;
				$queryAjout ='INSERT INTO tblmembres SET 
							nomMembre = :nomMembre, 
							prenomMembre = :prenomMembre,
							rue = :rue, 
							numbadge = :numBadge, 
							npa = :npa, 
							localite = :localite, 
							email = :email, 
							dateentre = :dateinscription, 
							telephone = :telephone, 
							fkTypeMembre = :fkTypeMembre';
				$prepAjout = $connexion->prepare($queryAjout);
				$prepAjout->setFetchMode(PDO::FETCH_OBJ);
				$prepAjout->bindValue(':nomMembre',$_POST['nomMembre']);
				$prepAjout->bindValue(':prenomMembre',$_POST['prenomMembre']);
				$prepAjout->bindValue(':rue',$_POST['rue']);
				$prepAjout->bindValue(':numBadge',$_POST['numBadge']);
				$prepAjout->bindValue(':npa',$_POST['npa']);
				$prepAjout->bindValue(':localite',$_POST['localite']);
				$prepAjout->bindValue(':email',$_POST['email']);
				$prepAjout->bindValue(':dateinscription',$_POST['dateinscription']);
				$prepAjout->bindValue(':telephone',$_POST['tel']);
				$prepAjout->bindValue(':fkTypeMembre',$_POST['type']);
				$prepAjout->execute();
				header('Location: gerermembre.php');
			}
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
	//Les variables select seront utilisé pour préselecitonner le type du membre lors d'une modification
	$select1 = "";
	$select2 = "";
	$select3 = "";
	//
	//Test si l'utilisateur a appuyé sur le bouton modifier.
	if($_GET['action'] == 'modif')
	{
		//Type d'affiche pour la page (modification ici)
		$affichage = 1;
		//Requête pour récupérer les infomations du memmbre que l'on veut modifier
		$query = 'SELECT nomMembre,prenomMembre,rue,npa,numBadge,localite,email,telephone,dateentre,fkTypeMembre
			FROM tblmembres
			WHERE idMembre = "'.$_GET['idmembre'].'"';
		$prep = $connexion->prepare($query);
		$prep->setFetchMode(PDO::FETCH_OBJ);
		$prep->execute();
		$ligne = $prep->fetch();
		$Nom = $ligne->nomMembre;
		$Prenom = $ligne->prenomMembre;
		$Rue = $ligne->rue;
		$NumBadge = $ligne->numBadge;
		$Npa = $ligne->npa;
		$Localite = $ligne->localite;
		$Email = $ligne->email;
		$DateEntree = $ligne->dateentre;
		$Telephone = $ligne->telephone;
		$TypeMembre = $ligne->fkTypeMembre;
		$readonly = 'readonly = "true"';
		$submit = 'Modifier';
		
		//Test si le membre que l'on modifie est un "Membre"
		if($TypeMembre == '1')
		{
			$select1 = "selected";
		}
		//Test si le membre que l'on modifie est un "Caissier"
		elseif($TypeMembre == '2')
		{
			$select2 = "selected";
		}
		//Test si le membre que l'on modifie est un "Superviseur"
		else
		{
			$select3 = "selected";
		}
	}
	//Test si l'utilisateur ajouter un utilisateur.
	if($_GET['action'] == 'add')
	{
		$affichage = 1;
		$Nom = NULL;
		$Prenom = NULL;
		$Rue = NULL;
		$NumBadge = NULL;
		$Npa = NULL;
		$Localite = NULL;
		$Email = NULL;
		$DateEntree = NULL;
		$Telephone = NULL;
		$TypeMembre = NULL;
		$readonly = NULL;
		$submit = 'Ajouter';
	}
	//Test si l'utilisateur veut supprimer un utilisateur
	if($_GET['action'] == 'del')
	{
		$affichage = 2;
		
		//Requête pour modifier l'état d'un membre et le rendre inactif.
		$query = 'SELECT nomMembre,prenomMembre
			FROM tblmembres
			WHERE idMembre = "'.$_GET['idmembre'].'"';
		$prep = $connexion->prepare($query);
		$prep->setFetchMode(PDO::FETCH_OBJ);
		$prep->execute();
	}
	?>
	<body>	
	<form id="form1" method="post" action="">
	<?php 
	
	//Test si l'on doit afficher pour un ajout ou une modification
	if($affichage == 1)
	{
	?>
		<div class="tableau">
		<label>Nom: </label>
		<input class="inputtext" type="text" name="nomMembre" <?php echo $readonly; ?> class="" value="<?php echo $Nom; ?>"/>
		<span class="inputtext2">
		<label>Prénom: </label>
		<input type="text" name="prenomMembre" <?php echo $readonly; ?> class="" value="<?php echo $Prenom; ?>" />
		</span>
		<br>
		<br>
		<br>
		<label>Rue: </label>
		<input class="inputtext" type="text" name="rue" class="" value="<?php echo $Rue; ?>" />
		<span class="inputtext2">
		<label>NPA: </label>
		<input type="text" name="npa" class="" value="<?php echo $Npa; ?> "/>
		</span>
		<br>
		<br>
		<br>
		<label>Localité: </label>
		<input class="inputtext" type="text" name="localite" class="" value="<?php echo $Localite; ?>" />
		<span class="inputtext2">
		<label>Badge: </label>
		<input type="text" name="numBadge" class="" value="<?php echo $NumBadge; ?>" />
		</span>
		<br>
		<br>
		<br>
		<label>Email: </label>
		<input class="inputtext" type="text" name="email" class="" value="<?php echo $Email; ?>" />
		<span class="inputtext2">
		<label>Date d'inscritpion: </label>
		<input type="text" name="dateinscription" class="" value="<?php echo $DateEntree; ?>" />
		</span>
		<br>
		<br>
		<br>
		<label>Téléphone: </label>
		<input class="inputtext" type="text" name="tel" class="" value="<?php echo $Telephone; ?>" />
		<span class="inputtext2">
		<label>Type de membre: </label>
		<select name="type"> 
			<option <?php echo $select1; ?> value='1'>Membre</option> 
			<option <?php echo $select2; ?> value='2'>Caissier</option> 
			<option <?php echo $select3; ?> value='3'>Superviseur</option> 
		</select> 
		</span>
		<br>
		<br>
		<br>
		<p>*Attention si vous ajoutez un nouveau caissier ou superviseur l'ancien sera supprimé</p><?php //Popup javascript? ?>
		<?php echo $erreur; ?>
		<br>
		</div>
		<input class="btn btnprimary"type="submit" name="<?php echo $submit; ?>" value="Confirmer"/>
		<input class="btn btnprimary" type="submit" name="retour" value="Retour"/>		
	<?php
	}
	else
	{
	?>
	<div>
	<p>Êtes-vous sur de vouloir supprimer le membre <?php $ligne = $prep->fetch(); echo $ligne->nomMembre.' '. $ligne->prenomMembre; ?></p>
	<input class="btn btnprimary" type="submit" name="delete" value ="Oui"/>
	<input class="btn btnprimary" type="submit" name="retour" value="Retour"/>
	
	</div>
	<?php 
	}
	?>

		
	</body>
	</form>
</html>