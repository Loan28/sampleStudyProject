<?php
	session_start();
	//Inclusion du fichier me permettant de me connecter à ma BDD.
	include 'connect_PDO.inc.php';
	$reponse = "";

	//Test si l'on appuie sur le bouton retour
	if(isset($_POST['retour']))
	{
		//Redirige sur l'accueil
		header('Location: accueil.php');
	}
	//Test si l'utilisateur a cliqué sur le bouton save
	if(isset($_POST['Save']))
	{
		//Répertoire où sauvegarder le dump de la base de données
		$rep = $_SERVER['DOCUMENT_ROOT'].'/TPI/DATA/SQL/'.date("m-d-y-H-i").'backup.sql';
		
		//Requête query à query4 récupère toutes les informations de la BDD
		$query ="SELECT * FROM tblmembres";
		$prep = $connexion->prepare($query);
		$prep->setFetchMode(PDO::FETCH_OBJ);
		$prep->execute();
		$query2 ="SELECT * FROM tblarticles";
		$prep2 = $connexion->prepare($query2);
		$prep2->setFetchMode(PDO::FETCH_OBJ);
		$prep2->execute();
		$query3 ="SELECT * FROM tblmembresarticles";
		$prep3 = $connexion->prepare($query3);
		$prep3->setFetchMode(PDO::FETCH_OBJ);
		$prep3->execute();
		$query4 ="SELECT * FROM tbltypemembre";
		$prep4 = $connexion->prepare($query4);
		$prep4->setFetchMode(PDO::FETCH_OBJ);
		$prep4->execute();
		//
		//my backup est le fichier SQL de backup que l'on crée, toute la partie qui suit est la création du fichier sql.
		$mybackup = fopen($rep,"w");
		
		$txt = "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
				/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
				/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
				/*!40101 SET NAMES utf8 */;
				/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
				/*!40103 SET TIME_ZONE='+00:00' */;
				/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
				/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
				/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
				/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;\n\n";
		fwrite($mybackup, $txt);
		$txt = "DROP TABLE IF EXISTS `tblarticles`;
				/*!40101 SET @saved_cs_client     = @@character_set_client */;
				/*!40101 SET character_set_client = utf8 */;
				CREATE TABLE `tblarticles` (
				  `idArticle` int(11) NOT NULL AUTO_INCREMENT,
				  `nomArticle` text NOT NULL,
				  `prixArticle` int(11) NOT NULL,
				  `Activite` int(11) NOT NULL,
				  PRIMARY KEY (`idArticle`)
				) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
				/*!40101 SET character_set_client = @saved_cs_client */;\n\nLOCK TABLES `tblarticles` WRITE;
				/*!40000 ALTER TABLE `tblarticles` DISABLE KEYS */;";
		fwrite($mybackup, $txt);
		while($ligne = $prep2->fetch())
		{
			$txt = 'INSERT INTO `tblarticles` VALUES ("'.$ligne->idArticle.'","'.$ligne->nomArticle.'","'.$ligne->prixArticle.'","'.$ligne->Activite.'");';
			fwrite($mybackup, "\n");
			fwrite($mybackup, $txt);
		}
		$txt = "/*!40000 ALTER TABLE `tblarticles` ENABLE KEYS */;
				UNLOCK TABLES;\n\n";
				fwrite($mybackup, $txt);
		$txt = "DROP TABLE IF EXISTS `tblmembres`;
				/*!40101 SET @saved_cs_client     = @@character_set_client */;
				/*!40101 SET character_set_client = utf8 */;
				CREATE TABLE `tblmembres` (
				  `idMembre` int(11) NOT NULL AUTO_INCREMENT,
				  `prenomMembre` text NOT NULL,
				  `nomMembre` text NOT NULL,
				  `numbadge` text NOT NULL,
				  `npa` text NOT NULL,
				  `localite` text NOT NULL,
				  `rue` text NOT NULL,
				  `email` text NOT NULL,
				  `dateentre` text NOT NULL,
				  `telephone` text NOT NULL,
				  `fkTypeMembre` int(11) NOT NULL,
				  `Activite` int(11) NOT NULL,
				  PRIMARY KEY (`idMembre`),
				  KEY `fkTypeMembre` (`fkTypeMembre`),
				  CONSTRAINT `tblmembres_ibfk_1` FOREIGN KEY (`fkTypeMembre`) REFERENCES `tbltypemembre` (`idTypemembre`) ON DELETE CASCADE ON UPDATE CASCADE
				) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
				/*!40101 SET character_set_client = @saved_cs_client */;\n
				LOCK TABLES `tblmembres` WRITE;
				/*!40000 ALTER TABLE `tblmembres` DISABLE KEYS */;";
		fwrite($mybackup, $txt);
		while($ligne = $prep->fetch())
		{
			$txt = 'INSERT INTO `tblmembres` VALUES ("'.$ligne->idMembre.'","'.$ligne->prenomMembre.'","'.$ligne->nomMembre.'","'.$ligne->numbadge.'","'.$ligne->npa.'","'.$ligne->localite.'","'.$ligne->rue.'","'.$ligne->email.'","'.$ligne->dateentre.'","'.$ligne->telephone.'","'.$ligne->fkTypeMembre.'","'.$ligne->Activite.'");';
			fwrite($mybackup, "\n");
			fwrite($mybackup, $txt);
		}
		$txt = "/*!40000 ALTER TABLE `tblmembres` ENABLE KEYS */;
				UNLOCK TABLES;\n";
				fwrite($mybackup, $txt);
		$txt = "\nDROP TABLE IF EXISTS `tblmembresarticles`;
				/*!40101 SET @saved_cs_client     = @@character_set_client */;
				/*!40101 SET character_set_client = utf8 */;
				CREATE TABLE `tblmembresarticles` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `fkmembres` int(11) NOT NULL,
				  `fkarticles` int(11) NOT NULL,
				  `dateConso` date NOT NULL,
				  `quantite` int(11) NOT NULL,
				  `DateFacturation` date DEFAULT NULL,
				  `prixAchat` int(11) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `fkmembres` (`fkmembres`,`fkarticles`),
				  KEY `fkarticles` (`fkarticles`),
				  CONSTRAINT `tblmembresarticles_ibfk_1` FOREIGN KEY (`fkmembres`) REFERENCES `tblmembres` (`idMembre`) ON DELETE CASCADE ON UPDATE CASCADE,
				  CONSTRAINT `tblmembresarticles_ibfk_2` FOREIGN KEY (`fkarticles`) REFERENCES `tblarticles` (`idArticle`) ON DELETE CASCADE ON UPDATE CASCADE
				) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;
				/*!40101 SET character_set_client = @saved_cs_client */;\n\nLOCK TABLES `tblmembresarticles` WRITE;
				/*!40000 ALTER TABLE `tblmembresarticles` DISABLE KEYS */;";
		fwrite($mybackup, $txt);
		while($ligne = $prep3->fetch())
		{
			$txt = 'INSERT INTO `tblmembresarticles` VALUES ("'.$ligne->id.'","'.$ligne->fkmembres.'","'.$ligne->fkarticles.'","'.$ligne->dateConso.'","'.$ligne->quantite.'","'.$ligne->DateFacturation.'","'.$ligne->prixAchat.'");';
			fwrite($mybackup, "\n");
			fwrite($mybackup, $txt);
		}
		$txt = "/*!40000 ALTER TABLE `tblmembresarticles` ENABLE KEYS */;
				UNLOCK TABLES;
			\nDROP TABLE IF EXISTS `tbltypemembre`;
			/*!40101 SET @saved_cs_client     = @@character_set_client */;
			/*!40101 SET character_set_client = utf8 */;
			CREATE TABLE `tbltypemembre` (
			  `idTypemembre` int(11) NOT NULL AUTO_INCREMENT,
			  `typemembre` text NOT NULL,
			  PRIMARY KEY (`idTypemembre`),
			  KEY `idTypemembre` (`idTypemembre`)
			) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
			/*!40101 SET character_set_client = @saved_cs_client */;\n\nLOCK TABLES `tbltypemembre` WRITE;
			/*!40000 ALTER TABLE `tbltypemembre` DISABLE KEYS */;";
		fwrite($mybackup, $txt);
		while($ligne = $prep4->fetch())
		{
			$txt = 'INSERT INTO `tbltypemembre` VALUES ("'.$ligne->idTypemembre.'","'.$ligne->typemembre.'");';
			fwrite($mybackup, "\n");
			fwrite($mybackup, $txt);
		}		
		$txt = "UNLOCK TABLES;
				/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;";
		fwrite($mybackup, $txt);	
		fclose($mybackup);
		$reponse = "Sauvegarde réussi";
		
		//Création du fichier ZIP. A COMPRENDRE 
		// Get real path for our folder
		$rootPath = realpath(''.$_SERVER['DOCUMENT_ROOT'].'/TPI/DATA/');

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open('DATA/'.date("m-d-y-H-i").'backup2.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($rootPath),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
			// Skip directories (they would be added automatically)
			if (!$file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);

				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}

		// Zip archive will be created only after closing object
		$zip->close();
	}
	//
	//Test si l'utilisateur appuie sur le bouton Restore
	if(isset($_POST['Restore']))
	{	
		//Futur emplacement du fichier upload
		$rep = $_SERVER['DOCUMENT_ROOT'].'/TPI/DATA/SQL/'.date("m-d-y-H-m").'backup.sql';
		//Fichier upload
		$file = $_FILES['fileToUpload']['tmp_name'];
		//
		//Test si le déplacement de l'upload a fonctionné.
		if(move_uploaded_file($file,$rep))
		{
			//Requête qui rempli la base de donnée avec le fichier que l'on vient d'upload.
			$query = file_get_contents($rep);
			$prep = $connexion->prepare($query);
			$prep->setFetchMode(PDO::FETCH_OBJ);
			$prep->execute();
			echo "Restauration réussie";
		}
		else
		{
			echo "Restauration échouée";
		}	
	}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Vollkorn"/>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <link rel="stylesheet" type="text/css" href="css/backup.css"/>
</head>
	<body>	
	<form method="post" enctype="multipart/form-data">
	<div class="gauche">
	<input class="btn btnprimary" type="submit" name="Save" value="Sauvegarder les données"/> <?php echo $reponse; ?>
	</div>
	<div class="droite">
	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
	<input type="file" name="fileToUpload" id="fileToUpload">
	<br>
	<br>
	<input class="btn btnprimary" type="submit" name="Restore" value="Restaurer les données"/>
	</div>
	<br>
	<br>
	<input class="btn btnprimary" type="submit" name="retour" value="Retour"/>
	</form>
	</body>
</html>