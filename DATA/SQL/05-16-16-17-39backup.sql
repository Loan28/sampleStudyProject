/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
				/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
				/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
				/*!40101 SET NAMES utf8 */;
				/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
				/*!40103 SET TIME_ZONE='+00:00' */;
				/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
				/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
				/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
				/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `tblarticles`;
				/*!40101 SET @saved_cs_client     = @@character_set_client */;
				/*!40101 SET character_set_client = utf8 */;
				CREATE TABLE `tblarticles` (
				  `idArticle` int(11) NOT NULL AUTO_INCREMENT,
				  `nomArticle` text NOT NULL,
				  `prixArticle` int(11) NOT NULL,
				  `Activite` int(11) NOT NULL,
				  PRIMARY KEY (`idArticle`)
				) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
				/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tblarticles` WRITE;
				/*!40000 ALTER TABLE `tblarticles` DISABLE KEYS */;
INSERT INTO `tblarticles` VALUES ("1","Vin Blanc","11","0");
INSERT INTO `tblarticles` VALUES ("2","Oeil de Perdrix","15.5","0");
INSERT INTO `tblarticles` VALUES ("3","Pinot noir","15","0");
INSERT INTO `tblarticles` VALUES ("4","Bière","3","0");
INSERT INTO `tblarticles` VALUES ("5","Minérale","2","0");
INSERT INTO `tblarticles` VALUES ("6","Café/Thé","3","0");
INSERT INTO `tblarticles` VALUES ("7","Schnaps","3","0");
INSERT INTO `tblarticles` VALUES ("8","Whisky 4cl","5","0");
INSERT INTO `tblarticles` VALUES ("9","Apéro","3","0");
INSERT INTO `tblarticles` VALUES ("10","Snacks","3","0");
INSERT INTO `tblarticles` VALUES ("11","Fondue","13","0");/*!40000 ALTER TABLE `tblarticles` ENABLE KEYS */;
				UNLOCK TABLES;

DROP TABLE IF EXISTS `tblmembres`;
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
				/*!40101 SET character_set_client = @saved_cs_client */;

				LOCK TABLES `tblmembres` WRITE;
				/*!40000 ALTER TABLE `tblmembres` DISABLE KEYS */;
INSERT INTO `tblmembres` VALUES ("1","Loan","Gauchat","128","2000   ","Neuchâtel","Rue de la Maladière 82","loan.gauchat@rpn.ch","28.04.1996","","3","0");
INSERT INTO `tblmembres` VALUES ("2","Sebastian","Garcia","200","2000 ","Neuchâtel","Rue de la maladière 81","sebastian.garcia@rpn.ch","27.03.2000","","1","0");
INSERT INTO `tblmembres` VALUES ("3","Géraldine","Ackermann","100","2014         ","Bôle","Rue de la maladière 83","ackermann.gerladine@rpn.ch","20.11.2000","","1","0");/*!40000 ALTER TABLE `tblmembres` ENABLE KEYS */;
				UNLOCK TABLES;

DROP TABLE IF EXISTS `tblmembresarticles`;
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
				/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tblmembresarticles` WRITE;
				/*!40000 ALTER TABLE `tblmembresarticles` DISABLE KEYS */;
INSERT INTO `tblmembresarticles` VALUES ("297","1","1","2016-05-16","1","0000-00-00","11");
INSERT INTO `tblmembresarticles` VALUES ("298","1","2","2016-05-16","5","0000-00-00","15.5");/*!40000 ALTER TABLE `tblmembresarticles` ENABLE KEYS */;
				UNLOCK TABLES;
			
DROP TABLE IF EXISTS `tbltypemembre`;
			/*!40101 SET @saved_cs_client     = @@character_set_client */;
			/*!40101 SET character_set_client = utf8 */;
			CREATE TABLE `tbltypemembre` (
			  `idTypemembre` int(11) NOT NULL AUTO_INCREMENT,
			  `typemembre` text NOT NULL,
			  PRIMARY KEY (`idTypemembre`),
			  KEY `idTypemembre` (`idTypemembre`)
			) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
			/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tbltypemembre` WRITE;
			/*!40000 ALTER TABLE `tbltypemembre` DISABLE KEYS */;
INSERT INTO `tbltypemembre` VALUES ("1","Membre");
INSERT INTO `tbltypemembre` VALUES ("2","Caissier");
INSERT INTO `tbltypemembre` VALUES ("3","Superviseur");UNLOCK TABLES;
				/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;