<?php
	$tekst = $_GET["q"];
	$fajlovi = glob('cjenovnik/*.xml');
	$prikaz = "";
	if (strlen($tekst)>0) {
		
		$brojac = 0;
		foreach($fajlovi as $fajl) {
			$xml = new SimpleXMLElement($fajl, 0, true);
			if(stristr($xml->proizvod, $tekst)){
				if ($prikaz == "") {
					$prikaz = $xml->proizvod;
				}
				else {
				  $prikaz = $prikaz . "<br/>" . $xml->proizvod;
				}
				$brojac++;
			}
			if($brojac < 10 && stristr($xml->cijena, $tekst)){
				if ($prikaz == "") {
					$prikaz = $xml->cijena;
				}
				else {
				  $prikaz = $prikaz . "<br/>" . $xml->cijena;
				}
				$brojac++;
			}
			if($brojac > 9){
				break;
			}
		}
	}
	if ($prikaz == "") {
	  $odgovor = "Nema rezultata";
	}
	else {
	  $odgovor = $prikaz;
	}
	echo $odgovor;
?>