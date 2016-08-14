<?php
	session_start();	
	//Variable qui contiendra le message d'erreur si l'utiliseur ne rentre pas le bon badge
	$erreur = "";
	
	//Inclusion du fichier me permettant de me connecter à ma BDD.
	include 'connect_PDO.inc.php';
	
	//Vérifie di l'utilisateur a cliqué sur le bouton connexion
	if(isset($_POST['connexion']))
	{
		//Requête qui récupère tous les numéro de badge
		$query ='SELECT fkTypeMembre, numbadge,nomMembre,prenomMembre from tblmembres';
		$prep = $connexion->prepare($query);
		$prep->setFetchMode(PDO::FETCH_OBJ);
		$prep->execute();
		while ($ligne = $prep->fetch())
		{
			//Variable contenant le numéro de badge des membres.
			$Numbadge = $ligne->numbadge;
			
			//Variable contenant la FK correspondant à leur type de membre.
			$fktypemembre = $ligne->fkTypeMembre;
			
			//
			//Si le numéro de badge entré correspond à l'un des badge de la base de donnée l'utilisateur se connecte avec succès
			if($Numbadge == $_POST['badge'])
			{
				//Requête récuperant le type de membre du membre (membre simple,caissier,administrateur) //A refaire
				$query2 ='SELECT typemembre from tbltypemembre WHERE idTypemembre ="'.$fktypemembre.'"';
				$prep2 = $connexion->prepare($query2);
				$prep2->setFetchMode(PDO::FETCH_OBJ);
				$prep2->execute();
				$ligne2 = $prep2->fetch();
				
				//Variable de session contenant le type de membre
				$_SESSION['type'] = $ligne2->typemembre;
				
				//Variable de session contenant le n° de badge de l'utiliseur
				$_SESSION['NBadge'] = $Numbadge;
				
				//Variable destiné à de l'affichage.
				$_SESSION['Membre'] = $ligne->prenomMembre .' '. $ligne->nomMembre;
				
				//Redirige sur la page d'accueil
				header('Location: accueil.php');
			}
			else
			{
				$erreur = "Le numéro de badge ne correspond à aucun badge enregistré";
			}
		}
	}
	?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/connexion.css"/>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <link rel="stylesheet" type="text/css" href="css/font-awesome-4.6.2/css/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="css/ionicons.css"/>
</head>
	<body>	

	<form id="claviervirtuel" method="post">
	<div class="centre">
        <ul class="input-list style-3">
            <input type="text" id="code" readonly="true" name="badge" class="focus">
        </ul>
	  <table class="tableau">
			<tr>
				<td><input id="b1" type="button" class="btn btn-primary" value="1" onclick="Keyboard('b1');"></td> 
				<td><input id="b2" type="button" class="btn btn-primary" value="2" onclick="Keyboard('b2');"></td>
				<td><input id="b3" type="button" class="btn btn-primary" value="3" onclick="Keyboard('b3');"></td>
			</tr>
			</tr>
			<tr>
				<td><input id="b4" type="button" class="btn btn-primary" value="4" onclick="Keyboard('b4');"></td>
				<td><input id="b5" type="button" class="btn btn-primary" value="5" onclick="Keyboard('b5');"></td>
				<td><input id="b6" type="button" class="btn btn-primary" value="6" onclick="Keyboard('b6');"></td>
			</tr>
			<tr>
				<td><input id="b7" type="button" class="btn btn-primary" value="7" onclick="Keyboard('b7');"></td>
				<td><input id="b8" type="button" class="btn btn-primary" value="8" onclick="Keyboard('b8');"></td>
				<td><input id="b9" type="button" class="btn btn-primary" value="9" onclick="Keyboard('b9');"></td>
			</tr>	
			<tr>
				<td><a href="index.php"><button id="backspace" type="button" class="btn btn-backspace">
				<i class="fa fa-times-circle" aria-hidden="true"></i></button></a></td>
				<td><input id="b0" type="button" class="btn btn-primary" value="0" onclick="Keyboard('b0');"></td>				
				<td> <button id="cancel" type="button" class="btn btn-backspace" onclick="KeyboardDel();">
				<i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button></td>
			</tr>
		</table>
		<br/>
		<input type="submit" name="connexion" class="btn btn-ok" value="OK"/>
		<br />
		<?php echo $erreur; ?>
	</div>
	</form>	
	
<script language=Javascript>
	//Fonction permettant de recevoir le chiffre entré par l'utilisateur
	function Keyboard(id) 
	{ 
		var chiffre = document.getElementById(id).value;
		var badge = document.getElementById('code').value;
		var badge = badge + chiffre;
		document.getElementById("claviervirtuel").elements["code"].value = badge;
	} 
	function KeyboardDel() 
	{ 
		var badge = document.getElementById('code').value;
		var taille = badge.length-1;
		var result =badge.substring(0,taille); 
		document.getElementById("claviervirtuel").elements["code"].value = result;
	} 
</script>
	</body>
</html>