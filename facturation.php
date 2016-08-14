
<?php
	session_start();
	include 'connect_PDO.inc.php';
	$date = date("Ymd");
	$date2 = date("d.m.Y");
	$date3 = date("Y-m-d-h.i.s");
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
	
	//Test si l'utilisateur appuie sur générer facture
	if(isset($_POST['genFacture']))
	{
		$nom = $_FILES['fileToUpload']['name'];
		$file = $_FILES['fileToUpload']['tmp_name'];
		if($file != NULL)
		{
			 header('Content-type: application/pdf'); 
			 header('Content-Disposition: attachment; filename="'.$nom.'"');
			 readfile($file);

		}
		else
		{			
			require("invoice.php");
			
			//Test si l'utilisateur à cocher la case "tous le monde"
			if(isset($_POST['tlm']))
			{
				//Requête récuperant des informations sur tous les membres
				$query = 'SELECT idMembre,nomMembre,prenomMembre,npa,localite,rue from tblmembres ';
				$prep = $connexion->prepare($query);
				$prep->setFetchMode(PDO::FETCH_OBJ);
				$prep->execute();
			}
			else
			{
				//Requête récuperant des informations sur tous le membre choisit
				$query = 'SELECT idMembre,nomMembre,prenomMembre,npa,localite,rue from tblmembres WHERE idMembre = '.$_POST['membreSelectionne'].'';
				$prep = $connexion->prepare($query);
				$prep->setFetchMode(PDO::FETCH_OBJ);
				$prep->execute();
			}
			$boolFacture2 = false;
			$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
			while($ligne = $prep->fetch())
			{
				$boolFacture = false;
				$MembreSelec = $ligne->nomMembre.$ligne->prenomMembre;
				$data = array();
				$iCpt = 0;
				$total = 0;
				//Requête récuperant les quantité et l'id des articles consommer par le client
				$query2 =	'SELECT id,quantite,dateConso,prixAchat,nomArticle,Numbadge
						FROM tblmembres
						INNER JOIN tblmembresarticles
						ON idMembre = fkmembres
						INNER JOIN tblarticles
						ON tblmembresarticles.fkarticles = tblarticles.idArticle
						WHERE idMembre = '.$ligne->idMembre.' AND DateFacturation = 0
						ORDER BY dateConso ASC';
				$prep2 = $connexion->prepare($query2);
				$prep2->setFetchMode(PDO::FETCH_OBJ);
				$prep2->execute();
				while($ligne2 = $prep2->fetch())
				{
					$badge = $ligne2->Numbadge;
					$boolFacture = true;
					$boolFacture2 = true;
					$dateConso = date_create($ligne2->dateConso);
					$dateConso = date_format($dateConso,"d.m.Y");
					$data[$iCpt] = $dateConso.";".$ligne2->quantite.";".$ligne2->prixAchat.".-;".utf8_decode($ligne2->nomArticle).";".$ligne2->quantite * $ligne2->prixAchat.".-";		
					$PremiereConso[$iCpt] = $dateConso;
					$iCpt++;
					$total += $ligne2->quantite * $ligne2->prixAchat;
					$queryUpdateDateFacturation = 'UPDATE tblmembresarticles SET DateFacturation = "'.$date3.'" WHERE id = "'.$ligne2->id.'"';
					$prepUpdateDateFacturation = $connexion->prepare($queryUpdateDateFacturation);
					$prepUpdateDateFacturation->execute();
				}	
				if($boolFacture == true)
				{
				$pdf->AddPage();
				$pdf->addSociete( "Club Nautique Le Landeron",
								  "Numero facture: ".$date.$badge
								  );
				$pdf->addDate( $date2);
				$pdf->addClientAdresse("Monsieur\n".utf8_decode($ligne->prenomMembre) ." ". utf8_decode($ligne->nomMembre) ."\n".utf8_decode($ligne->rue) ."\n".$ligne->npa ." ".utf8_decode($ligne->localite) ."");
				$cols=array( "Date",
							 "Quantite",
							 "Prix unitaire",
							 "Articles",
							 "Total"
							 );
				
				
					$data[$iCpt+1] = ";;;Total:;".$total.".-";
					$pdf->BasicTable( $cols, $data);
					$pdf->addReference(' '.$PremiereConso[0].' au '.$date2.'');
					$pdf->addReference2();
				}
			}		
			if($boolFacture2 == true)
			{
				if(isset($_POST['tlm']))
				{
					  $pdf->Output(''.$_SERVER['DOCUMENT_ROOT'].'/TPI/DATA/PDF/'.$date3.'-tlm.pdf','F');
					  // $file = ''.$_SERVER['DOCUMENT_ROOT'].'/TPI/DATA/PDF/'.$date3.'-tlm.pdf';
					  // header('Content-type: application/pdf'); 
					  // header('Content-Disposition: attachment; filename="'.$date3.'-tlm.pdf"');
				}
				else
				{
					$pdf->Output(''.$_SERVER['DOCUMENT_ROOT'].'/TPI/DATA/PDF/'.$date3.''.$MembreSelec.'.pdf','F');
					// $file = ''.$_SERVER['DOCUMENT_ROOT'].'/TPI/DATA/PDF/'.$date3.''.$MembreSelec.'.pdf';
					// header('Content-type: application/pdf'); 
					// header('Content-Disposition: attachment; filename="'.$date3.''.$MembreSelec.'.pdf"');
					// readfile($file);
				}

			}
			else
			{	
				echo "Aucune facture";
			}
		}
	}		
	//Requête pour récuperer le nom et prenom de l'utilisateur en cour
	$query = 'SELECT nomMembre,prenomMembre from tblmembres WHERE Numbadge = '.$_SESSION['NBadge'].'';
	$prep = $connexion->prepare($query);
	$prep->setFetchMode(PDO::FETCH_OBJ);
	$prep->execute();	
	
	//Requête qui récuperant tous les nom/prénom des membres
	$query2 = 'SELECT idMembre,nomMembre,prenomMembre from tblmembres';
	$prep2 = $connexion->prepare($query2);
	$prep2->setFetchMode(PDO::FETCH_OBJ);
	$prep2->execute();	
	
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Vollkorn"/>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <link rel="stylesheet" type="text/css" href="css/facturation.css"/>
</head>
	<body>	
	<form method="post" enctype="multipart/form-data" id="facturation" action="">
	<div class="membre">
	<BR>
	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
	<input type="file" name="fileToUpload" id="fileToUpload" value="">
	<BR>
	<BR>
	<BR>
		<SELECT name="membreSelectionne" <?php echo $selectactivite ?>>
		<?php
			while($ligne = $prep2->fetch())
			{
				echo '<option value='.$ligne->idMembre.'>'.$ligne->prenomMembre .' '. $ligne->nomMembre ;
			}
		?>
		</SELECT>
		<input class="increase" type="checkbox" name="tlm" onclick="CheckifCheck();"><span class="checkbox">Tous le monde</span>
		<br>
		<br>
	</div>
		<br>
		<br>
		<br>
		<input class="btn btnprimary" type="submit" name="genFacture" value="Générer la facture"/>
		<input class="btn btnprimary" type="submit" name="retour" value="Retour"/>		
		<br>
		<br>
	</div>

	</form>
	</body>
</html>
                <script type="text/javascript">
				//
				//Fonction permettant de savoir si l'on ajoute un article ou un titre/sous-titre
				//
                function CheckifCheck()
                {
					if(document.getElementById("facturation").elements["membreSelectionne"].disabled == true)
					{
						document.getElementById("facturation").elements["membreSelectionne"].disabled = false;
					}
					else
					{
						document.getElementById("facturation").elements["membreSelectionne"].disabled = true;
					}
                }

                </script> 

