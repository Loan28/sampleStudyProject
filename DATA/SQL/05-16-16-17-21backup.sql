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
INSERT INTO `tblarticles` VALUES ("2","Oeil de Perdrix","15","0");
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
INSERT INTO `tblmembresarticles` VALUES ("161","1","1","2016-05-09","2","2016-05-10","10");
INSERT INTO `tblmembresarticles` VALUES ("162","1","2","2016-05-09","1","2016-05-10","12");
INSERT INTO `tblmembresarticles` VALUES ("164","1","4","2016-05-09","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("165","1","5","2016-05-09","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("166","1","6","2016-05-09","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("168","1","8","2016-05-09","1","2016-05-10","6");
INSERT INTO `tblmembresarticles` VALUES ("169","1","9","2016-05-09","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("170","1","1","2016-05-10","2","2016-05-10","10");
INSERT INTO `tblmembresarticles` VALUES ("171","1","2","2016-05-10","2","2016-05-10","12");
INSERT INTO `tblmembresarticles` VALUES ("173","1","4","2016-05-10","3","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("174","1","5","2016-05-10","1","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("175","1","1","2016-05-10","2","2016-05-10","10");
INSERT INTO `tblmembresarticles` VALUES ("176","1","2","2016-05-10","1","2016-05-10","12");
INSERT INTO `tblmembresarticles` VALUES ("178","1","4","2016-05-10","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("179","1","5","2016-05-10","3","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("180","1","6","2016-05-10","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("182","2","1","2016-05-10","3","2016-05-10","10");
INSERT INTO `tblmembresarticles` VALUES ("183","2","2","2016-05-10","2","2016-05-10","12");
INSERT INTO `tblmembresarticles` VALUES ("184","2","3","2016-05-10","3","2016-05-10","5");
INSERT INTO `tblmembresarticles` VALUES ("185","2","4","2016-05-10","1","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("186","2","5","2016-05-10","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("187","2","6","2016-05-10","1","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("188","2","7","2016-05-10","2","2016-05-10","8");
INSERT INTO `tblmembresarticles` VALUES ("189","2","8","2016-05-10","2","2016-05-10","6");
INSERT INTO `tblmembresarticles` VALUES ("190","2","9","2016-05-10","1","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("191","3","1","2016-05-10","1","2016-05-10","10");
INSERT INTO `tblmembresarticles` VALUES ("192","3","2","2016-05-10","1","2016-05-10","12");
INSERT INTO `tblmembresarticles` VALUES ("193","3","3","2016-05-10","2","2016-05-10","5");
INSERT INTO `tblmembresarticles` VALUES ("194","3","4","2016-05-10","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("195","3","5","2016-05-10","1","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("196","3","6","2016-05-10","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("197","3","7","2016-05-10","1","2016-05-10","8");
INSERT INTO `tblmembresarticles` VALUES ("198","3","8","2016-05-10","1","2016-05-10","6");
INSERT INTO `tblmembresarticles` VALUES ("199","1","1","2016-05-10","2","2016-05-10","10");
INSERT INTO `tblmembresarticles` VALUES ("200","1","2","2016-05-10","1","2016-05-10","12");
INSERT INTO `tblmembresarticles` VALUES ("201","1","4","2016-05-10","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("202","1","1","2016-05-10","2","2016-05-10","10");
INSERT INTO `tblmembresarticles` VALUES ("203","1","2","2016-05-10","2","2016-05-10","12");
INSERT INTO `tblmembresarticles` VALUES ("205","3","1","2016-05-10","1","2016-05-10","10");
INSERT INTO `tblmembresarticles` VALUES ("206","3","3","2016-05-10","1","2016-05-10","5");
INSERT INTO `tblmembresarticles` VALUES ("207","3","1","2016-05-10","1","2016-05-10","10");
INSERT INTO `tblmembresarticles` VALUES ("208","3","2","2016-05-10","1","2016-05-10","12");
INSERT INTO `tblmembresarticles` VALUES ("209","1","4","2016-05-10","2","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("210","1","5","2016-05-10","1","2016-05-10","3");
INSERT INTO `tblmembresarticles` VALUES ("211","1","1","2016-05-10","2","2016-05-11","10");
INSERT INTO `tblmembresarticles` VALUES ("212","1","2","2016-05-10","1","2016-05-11","12");
INSERT INTO `tblmembresarticles` VALUES ("214","1","1","2016-05-11","2","2016-05-11","10");
INSERT INTO `tblmembresarticles` VALUES ("215","1","2","2016-05-11","5","2016-05-11","12");
INSERT INTO `tblmembresarticles` VALUES ("216","1","4","2016-05-11","2","2016-05-11","3");
INSERT INTO `tblmembresarticles` VALUES ("217","1","5","2016-05-11","1","2016-05-11","3");
INSERT INTO `tblmembresarticles` VALUES ("218","1","7","2016-05-11","5","2016-05-11","8");
INSERT INTO `tblmembresarticles` VALUES ("219","1","8","2016-05-11","1","2016-05-11","6");
INSERT INTO `tblmembresarticles` VALUES ("220","1","9","2016-05-11","1","2016-05-11","3");
INSERT INTO `tblmembresarticles` VALUES ("221","2","1","2016-05-11","3","2016-05-11","10");
INSERT INTO `tblmembresarticles` VALUES ("222","2","2","2016-05-11","1","2016-05-11","12");
INSERT INTO `tblmembresarticles` VALUES ("223","2","3","2016-05-11","1","2016-05-11","5");
INSERT INTO `tblmembresarticles` VALUES ("224","2","4","2016-05-11","1","2016-05-11","3");
INSERT INTO `tblmembresarticles` VALUES ("225","2","5","2016-05-11","1","2016-05-11","3");
INSERT INTO `tblmembresarticles` VALUES ("226","2","6","2016-05-11","1","2016-05-11","3");
INSERT INTO `tblmembresarticles` VALUES ("227","2","7","2016-05-11","2","2016-05-11","8");
INSERT INTO `tblmembresarticles` VALUES ("228","2","8","2016-05-11","2","2016-05-11","6");
INSERT INTO `tblmembresarticles` VALUES ("229","2","9","2016-05-11","3","2016-05-11","3");
INSERT INTO `tblmembresarticles` VALUES ("230","3","6","2016-05-11","1","2016-05-12","3");
INSERT INTO `tblmembresarticles` VALUES ("231","3","9","2016-05-11","99","2016-05-12","3");
INSERT INTO `tblmembresarticles` VALUES ("232","1","1","2016-05-11","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("233","2","1","2016-05-11","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("234","2","2","2016-05-11","2","2016-05-12","12");
INSERT INTO `tblmembresarticles` VALUES ("235","2","3","2016-05-11","1","2016-05-12","5");
INSERT INTO `tblmembresarticles` VALUES ("236","1","2","2016-05-11","2","2016-05-12","12");
INSERT INTO `tblmembresarticles` VALUES ("237","1","3","2016-05-11","3","2016-05-12","5");
INSERT INTO `tblmembresarticles` VALUES ("238","1","4","2016-05-11","1","2016-05-12","3");
INSERT INTO `tblmembresarticles` VALUES ("239","1","5","2016-05-11","1","2016-05-12","2");
INSERT INTO `tblmembresarticles` VALUES ("240","1","6","2016-05-11","2","2016-05-12","3");
INSERT INTO `tblmembresarticles` VALUES ("241","1","7","2016-05-11","1","2016-05-12","3");
INSERT INTO `tblmembresarticles` VALUES ("242","3","1","2016-05-11","1","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("243","3","2","2016-05-11","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("244","3","3","2016-05-11","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("245","1","9","2016-05-11","1","2016-05-12","3");
INSERT INTO `tblmembresarticles` VALUES ("246","1","10","2016-05-11","2","2016-05-12","3");
INSERT INTO `tblmembresarticles` VALUES ("247","1","11","2016-05-11","1","2016-05-12","12");
INSERT INTO `tblmembresarticles` VALUES ("248","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("249","1","2","2016-05-12","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("250","1","3","2016-05-12","2","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("251","1","5","2016-05-12","1","2016-05-12","2");
INSERT INTO `tblmembresarticles` VALUES ("252","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("253","1","2","2016-05-12","2","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("254","1","3","2016-05-12","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("255","1","4","2016-05-12","2","2016-05-12","3");
INSERT INTO `tblmembresarticles` VALUES ("256","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("257","1","2","2016-05-12","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("258","1","2","2016-05-12","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("259","1","3","2016-05-12","2","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("260","1","4","2016-05-12","1","2016-05-12","3");
INSERT INTO `tblmembresarticles` VALUES ("261","1","5","2016-05-12","1","2016-05-12","2");
INSERT INTO `tblmembresarticles` VALUES ("262","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("263","1","2","2016-05-12","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("264","1","5","2016-05-12","1","2016-05-12","2");
INSERT INTO `tblmembresarticles` VALUES ("265","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("266","1","2","2016-05-12","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("267","1","3","2016-05-12","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("268","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("269","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("270","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("271","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("272","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("273","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("274","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("275","1","2","2016-05-12","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("276","1","3","2016-05-12","1","2016-05-12","15");
INSERT INTO `tblmembresarticles` VALUES ("277","1","1","2016-05-12","2","2016-05-12","10");
INSERT INTO `tblmembresarticles` VALUES ("278","1","1","2016-05-13","2","2016-05-13","10");
INSERT INTO `tblmembresarticles` VALUES ("279","1","10","2016-05-13","1","2016-05-13","3");
INSERT INTO `tblmembresarticles` VALUES ("280","1","1","2016-05-13","2","2016-05-13","10");
INSERT INTO `tblmembresarticles` VALUES ("281","1","1","2016-05-13","2","2016-05-13","10");
INSERT INTO `tblmembresarticles` VALUES ("282","1","1","2016-05-13","2","2016-05-13","10");
INSERT INTO `tblmembresarticles` VALUES ("283","1","1","2016-05-16","2","0000-00-00","10");
INSERT INTO `tblmembresarticles` VALUES ("284","1","2","2016-05-16","2","0000-00-00","15");
INSERT INTO `tblmembresarticles` VALUES ("285","1","4","2016-05-16","3","0000-00-00","3");
INSERT INTO `tblmembresarticles` VALUES ("286","1","5","2016-05-16","1","0000-00-00","2");
INSERT INTO `tblmembresarticles` VALUES ("287","1","3","2016-05-16","1","0000-00-00","15");
INSERT INTO `tblmembresarticles` VALUES ("288","3","4","2016-05-16","1","0000-00-00","3");
INSERT INTO `tblmembresarticles` VALUES ("289","3","5","2016-05-16","3","0000-00-00","2");
INSERT INTO `tblmembresarticles` VALUES ("290","3","6","2016-05-16","2","0000-00-00","3");
INSERT INTO `tblmembresarticles` VALUES ("291","3","7","2016-05-16","2","0000-00-00","3");
INSERT INTO `tblmembresarticles` VALUES ("292","3","8","2016-05-16","1","0000-00-00","5");
INSERT INTO `tblmembresarticles` VALUES ("293","2","1","2016-05-16","1","0000-00-00","11");
INSERT INTO `tblmembresarticles` VALUES ("294","2","2","2016-05-16","2","0000-00-00","15");
INSERT INTO `tblmembresarticles` VALUES ("295","2","3","2016-05-16","3","0000-00-00","15");
INSERT INTO `tblmembresarticles` VALUES ("296","2","4","2016-05-16","1","0000-00-00","3");/*!40000 ALTER TABLE `tblmembresarticles` ENABLE KEYS */;
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