<?php
require('pdf/fpdf.php');
/*
* Class créé par chokri khalifa, http://khalifa-chokri.com
* déja modifié
*/
class PDF extends FPDF{
var $B;
var $I;
var $U;
var $HREF;

function PDF($orientation='P', $unit='mm', $size='A4'){
    // Appel au constructeur parent
    $this->FPDF($orientation,$unit,$size);
    // Initialisation
    $this->B = 0;
    $this->I = 0;
    $this->U = 0;
    $this->HREF = '';
}
    
function Header(){
    // Logo a inséré 
    $this->Image('image.jpg',10,6,30);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(80);
    // Titre du document
    $this->Cell(30,10,'Titre du document',0,0,'C');
    // Saut de ligne
    $this->Ln(20);
}

// Pied de page
function Footer(){
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

    function WriteHTML($html){
        // Parseur HTML
        $html = str_replace("\n",' ',$html);
        $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e){
            if($i%2==0){
                // Texte
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,$e);
            }else{
                // Balise
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else{
                    // Extraction des attributs
                    $a2 = explode(' ',$e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach($a2 as $v){
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr){
        // Balise ouvrante
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF = $attr['HREF'];
        if($tag=='BR')
            $this->Ln(5);
    }

    function CloseTag($tag){
        // Balise fermante
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable){
        // Modifie le style et sélectionne la police correspondante
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach(array('B', 'I', 'U') as $s){
            if($this->$s>0)
                $style .= $s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt){
        // Place un hyperlien
        $this->SetTextColor(0,0,100);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
}
?>