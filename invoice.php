<?php
require('fpdf.php');

//////////////////////////////////////
// fonctions à utiliser (publiques) //
//////////////////////////////////////
//  function sizeOfText( $texte, $larg )
//  function addSociete( $nom, $adresse )
//  function addDevis( $numdev )
//  function addFacture( $numfact )
//  function addDate( $date )
//  function addClientAdresse( $adresse )
//  function addReference($ref)
//  function addCols( $tab )
//  function addLineFormat( $tab )
//  function addLine( $ligne, $tab )
//  function addRemarque($remarque)

class PDF_Invoice extends FPDF
{
// variables privées
var $colonnes;
var $format;
var $angle=0;

function _endpage()
{
	if($this->angle!=0)
	{
		$this->angle=0;
		$this->_out('Q');
	}
	parent::_endpage();
}

// fonctions publiques
function sizeOfText( $texte, $largeur )
{
	$index    = 0;
	$nb_lines = 0;
	$loop     = TRUE;
	while ( $loop )
	{
		$pos = strpos($texte, "\n");
		if (!$pos)
		{
			$loop  = FALSE;
			$ligne = $texte;
		}
		else
		{
			$ligne  = substr( $texte, $index, $pos);
			$texte = substr( $texte, $pos+1 );
		}
		$length = floor( $this->GetStringWidth( $ligne ) );
		$res = 1 + floor( $length / $largeur) ;
		$nb_lines += $res;
	}
	return $nb_lines;
}

// Cette fonction affiche en haut, a gauche,
// le nom de la societe dans la police Arial-12-Bold
// les coordonnees de la societe dans la police Arial-10
function addSociete( $nom, $adresse )
{
	$x1 = 10;
	$y1 = 8;
	//Positionnement en bas
	$this->SetXY( $x1, $y1 );
	$this->SetFont('Arial','B',12);
	$length = $this->GetStringWidth( $nom );
	$this->Cell( $length, 2, $nom);
	$this->SetXY( $x1, $y1 + 4);
	$this->SetFont('Arial','',10);
	$length = $this->GetStringWidth( $adresse );
	//Coordonnées de la société
	$lignes = $this->sizeOfText( $adresse,$length) ;
	$this->MultiCell(100, 4, $adresse);
}

// Affiche un cadre avec la date de la facture / devis
// (en haut, a droite)
function addDate( $date )
{
	$r1  = $this->w - 75;
	$r2  = $r1 + 68;
	$y1  = 30;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "", 10);
	$this->Cell(10,5,$date, 0,0, "C");
}

// Affiche l'adresse du client
// (en haut, a droite)
function addClientAdresse( $adresse )
{
	$r1     = $this->w - 80;
	$r2     = $r1 + 68;
	$y1     = 40;
	$this->SetXY( $r1, $y1);
	$this->MultiCell( 60, 4, $adresse);
}

// Affiche une ligne avec des reference
// (en haut, a gauche)
function addReference($ref)
{
	$this->SetFont( "Arial", "", 10);
	$length = $this->GetStringWidth( "Références : " . $ref );
	$r1  = 9;
	$r2  = $r1 + $length;
	$y1  = 72;
	$y2  = $y1+5;
	$this->SetXY( $r1 , $y1 );
	$this->Cell($length,4, "Concerne : Facture des consommations du " . $ref);
}

function addReference2()
{
	$this->SetFont( "Arial", "", 10);
	$r1  = 9;
	$y1  = 80;
	$y2  = $y1+5;
	$this->SetXY( $r1 , $y1 );
	$this->MultiCell(80,4, "Monsieur,\nCi-joint la facture de vos commandes");
}

function AfficheTotal( $total )
{
	$r1  = $this->w - 56;
	$r2  = $r1 + 68;
	$y1  = 130;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "", 10);
	$this->Cell(10,5,"Total : ".$total.".-", 0,0, "C");
}

// trace le cadre des colonnes du devis/facture
function BasicTable($header,$data)
{
	$this->SetXY( 10, 90);
	// En-tête
	foreach($header as $col)
		$this->Cell(35,7,$col,1);
	$this->Ln();
	// Données

	foreach($data as $row)
	{
		$line = explode(';',trim($row));
		foreach($line as $col)
			$this->Cell(35,6,$col,1);	
		$this->Ln();
	}
}


}
?>
