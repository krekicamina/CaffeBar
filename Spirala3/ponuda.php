<?php
	session_start();
	$change_error = array();
	$add_error = array();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<script type="text/javascript" src="kod.js"></script>
		<title>Caffe Bar</title>
	  
	</head>
	
	<body>
	<script type="text/javascript" src="kod.js"></script>
		<div class="red" id="pozadina">
			<ul class="header" id="mytopnav">
				<li><a class="podstranica" href="pocetna.php">O nama</a> </li>
				<li><a class="podstranica" href="aktuelno.php">Aktuelno</a> </li>
				<li><a class="active" href="ponuda.php">Ponuda</a></li>
				<li><a class="podstranica" href="galerija.php">Galerija</a></li>	        
				<li><a class="podstranica" href="kontakt.php">Kontakt</a></li>
				<li class="ikonica">
					<a href="javascript:void(0);" style="font-size:70px;" onclick="dropDownFunkcija()">☰</a>
				</li>
			</ul>
		</div>
		
		<p class="quote">“I'm a traditionalist, so for me, black coffee is cool." </p> 
		
		<div class="red" id="carousel">	
			<div class="slideshow-container">
				<div class="mySlides fade">
					<img src="carousel1.jpg">
				</div>
				<div class="mySlides fade">
					<img src="carousel2.jpg">
				</div>
				<div class="mySlides fade">
					<img src="carousel3.jpg">
				</div>
				<a class="prev" onclick="plusSlides(-1)">❮</a>
				<a class="next" onclick="plusSlides(1)">❯</a>
			</div>
			<br>
			<div style="text-align:center">
				<span class="dot" onclick="currentSlide(1)"></span>
				<span class="dot" onclick="currentSlide(2)"></span>
				<span class="dot" onclick="currentSlide(3)"></span>
			</div>
		</div>
		<br>
		<?php
		if (isset($_SESSION['username'])){
		if(stristr($_SESSION['username'], "Amina")){
			echo '<h2><br>Zdravo, Amina. Ovdje možete pregledati, uređivati, dodavati i brisati stavke iz cjenovnika: </h2>';
		}
		}
		?>
		<div class="red">
		<div class="kolona cetri" id="tabela">
		<form method="post" action="ponuda.php">
		<table>
			<tr>
				<th>Jedinstveni broj</th>
				<th>Proizvod</th>
				<th>Cijena u KM</th>
			</tr>
			<?php
			$fajlovi=glob('cjenovnik/*.xml');
			foreach($fajlovi as $fajl){
				$xml=new SimpleXMLElement($fajl,0,true);
				echo '<tr>';
				echo '<td>'. htmlspecialchars($xml->ID, ENT_QUOTES, 'UTF-8') . '</td>';
				echo '<td>'. htmlspecialchars($xml->proizvod, ENT_QUOTES, 'UTF-8') . '</td>';
				echo '<td>'. htmlspecialchars($xml->cijena, ENT_QUOTES, 'UTF-8') . '</td>';
				if (isset($_SESSION['username'])){
				if(stristr($_SESSION['username'], "Amina")){
					echo '<td><form action="" method="POST"><input type="hidden" name="iksic" value="' . $xml->ID. '"/><input type="submit" name="izbrisi" value="X" style="width:70%; background-color:#E2DD91; margin-left:15%; margin-right:15%;"/></form></td>';
				}
				}
				echo '</tr>';
			}
			if (isset($_SESSION['username'])){
				if(stristr($_SESSION['username'], "Amina")){
					echo '<tr>';
					echo '<td><input type="text" style="background-color: inherit; width:100%;" name="dodajBroj" class="poljeTabela" placeholder="Jedinstveni broj proizvoda kojeg dodajete"></td>';
					echo '<td><input type="text" style="background-color: inherit; width:100%;" name="dodajProizvod" class="poljeTabela" placeholder="Naziv proizvoda"></td>';
					echo '<td><input type="text" style="background-color: inherit; width:100%;" name="dodajCijenu" class="poljeTabela" placeholder="Cijena proizvoda"></td>';
					echo '<td><input type="submit" name="add_this" value = "+" style="width:70%; background-color:#7F3C05; margin-left:15%; margin-right:15%;"';
					echo '</tr>';
								
					echo '<tr>';
					echo '<td><input type="text" style="background-color: inherit; width:100%;" name="change_ID" placeholder="Jedinstveni broj proizvoda kojeg mijenjate"></td>';
					echo '<td><input type="text" style="background-color: inherit; width:100%;" name="novi_proizvod" placeholder="Novi naziv proizvoda"></td>';
					echo '<td><input type="text" style="background-color: inherit; width:100%;" name="nova_cijena" placeholder="Nova cijena proizvoda"></td>';
					echo '<td><input type="submit" name="change_this" value="E" style="width:70%; background-color:#E2DD91; margin-left:15%; margin-right:15%;"';
					echo '</tr>';
				}
			}			
			if(isset($_POST['change_this'])){
				$fajlovi = glob('cjenovnik/*.xml');
				$no_error1 = true;
				$nema = true;
				foreach($fajlovi as $fajl) {
				$xml = new SimpleXMLElement($fajl, 0, true);
				if($xml->ID == $_POST['change_ID']){
					$ID_d = $_POST['change_ID'];
					$proizvod_d = htmlEntities($_POST['novi_proizvod'], ENT_QUOTES);
					$proizvod_d = preg_replace("#[^0-9a-zA-Z ,.ščćžđŠČĆŽĐ]#i", "", $proizvod_d);
					$provjera = preg_replace("#[^0-9a-zA-ZščćžđŠČĆŽĐ]#i", "", $proizvod_d);
					if(strlen($provjera)<2) {
						$change_error[]="Naziv proizvoda mora sadržati minimalno dva karaktera.";
						$no_error1=false;
					}
					$cijena_d = htmlEntities($_POST['nova_cijena'], ENT_QUOTES);
					$cijena_d=preg_replace("#[^0-9a-zA-Z .,ščćžđŠČĆŽĐ]#i", "", $cijena_d);
					$provjera = preg_replace("#[^a-zA-ZščćžđŠČĆŽĐ]#i", "", $cijena_d);
					if (strlen($provjera)>0){
						$change_error[]="Cijena ne smije sadržavati nikakve znakove osim brojeva i tacke ili zareza.";
						$no_error1=false;
					}
					$cijena_d=str_replace(',', '.', $cijena_d);
					$cijena_d = preg_replace('/\.{2,}/', '.', $cijena_d);
					$nema = false;
					if($no_error1){
						$fajl1 = "cjenovnik/" . $ID_d . ".xml";
						unlink($fajl1);
						$xml = new SimpleXMLElement('<?xml version = "1.0" encoding = "utf-8"?><stavka></stavka>');
						$xml->addChild('ID', $ID_d);
						$xml->addChild('proizvod', $proizvod_d);
						$xml->addChild('cijena', $cijena_d);
						$xml->asXML('cjenovnik/' . $ID_d . '.xml');
						echo "<meta http-equiv = 'refresh' content = '0'>";
					}
				}
				}
				if($nema){
					$change_error[] = "Pod unesenim jedinstvenim brojem ne postoji proizvod.";
				}
			}
							
			if(isset($_POST['add_this'])){
				$fajlovi = glob('cjenovnik/*.xml');
				$nema = true;
				foreach($fajlovi as $fajl) {
					$xml1 = new SimpleXMLElement($fajl, 0, true);
					if($xml1->ID == $_POST['dodajBroj']){
						$nema = false;
					}
				}
				$no_error2 = true;
				if($nema){
					$ID_d = htmlEntities($_POST['dodajBroj'], ENT_QUOTES);
					$ID_d = preg_replace("#[^0-9a-zA-Z ščćžđŠČĆŽĐ]#i", "", $ID_d);
					$provjera = preg_replace("#[^a-zA-ZščćžđŠČĆŽĐ]#i", "", $ID_d);
					if(strlen($provjera)>0) {
						$add_error[] = "Jedinstveni broj ne smije sadržavati nikakve znakove osim brojeva.";
						$no_error2 = false;
					}
					$proizvod_d = htmlEntities($_POST['dodajProizvod'], ENT_QUOTES);
					$proizvod_d = preg_replace("#[^0-9a-zA-Z ,.ščćžđŠČĆŽĐ]#i", "", $proizvod_d);
					$provjera = preg_replace("#[^0-9a-zA-ZščćžđŠČĆŽĐ]#i", "", $proizvod_d);
					if(strlen($provjera)<2) {
						$add_error[] = "Naziv proizvoda mora sadržati minimalno dva karaktera.";
						$no_error2 = false;
					}
					
					$cijena_d = htmlEntities($_POST['dodajCijenu'], ENT_QUOTES);
					
					$cijena_d=preg_replace("#[^0-9a-zA-Z .,ščćžđŠČĆŽĐ]#i", "", $cijena_d);
					$provjera = preg_replace("#[^a-zA-ZščćžđŠČĆŽĐ]#i", "", $cijena_d);
					if (strlen($provjera)>0){
						$add_error[]="Cijena ne smije sadržavati nikakve znakove osim brojeva i tačke ili zareza.";
						$no_error2=false;
					}
					$cijena_d=str_replace(',', '.', $cijena_d);
					$cijena_d = preg_replace('/\.{2,}/', '.', $cijena_d);
					
					if($no_error2){
						$xml = new SimpleXMLElement('<?xml version = "1.0" encoding = "utf-8"?><stavka></stavka>');
						$xml->addChild('ID', $ID_d);
						$xml->addChild('proizvod', $proizvod_d);
						$xml->addChild('cijena', $cijena_d);
						$xml->asXML('cjenovnik/' . $ID_d . '.xml');
						echo "<meta http-equiv = 'refresh' content = '0'>";
					}
				}
				else {
					$add_error[] = "Već postoji cijena sa tim jedinstvenim brojem.";
				}
			}
					
			if(isset($_POST['izbrisi'])){
				$ID_i = $_POST['iksic'];
				$fajl = "cjenovnik/" . $ID_i . ".xml";
				unlink($fajl);
				echo "<meta http-equiv = 'refresh' content = '0'>";
			}
			?>
		</table>
		</form>
		<?php
			if(count($change_error)>0){
				echo '<p>Došlo je do greške pri izmjeni proizvoda:';
				foreach($change_error as $g){
					echo '<p style = "color:red;">' . $g . '</p>';
				}
				echo '</p>';
			}
			if(count($add_error) > 0){
				echo '<p>Došlo je do greške pri dodavanju proizvoda:';
				foreach($add_error as $g){
					echo '<p style = "color:red;">' . $g . '</p>';
				}
				echo '</p>';
			}
		?>
		</div>
		</div>
		<br>
		<div class="clearfix"></div>
		
		<div class="red" id="footer">
			<div class="kolona jedan">
				<h3>Radno vrijeme</h3>
				<p>	Pon-Ned: 7:00-00:00</p>
			</div>
			<div class="kolona dva">
				<h3>Adresa</h3>
				<p>	Zmaja od Bosne bb <br>
				 <br>
				</p>
			</div>
			<div class="kolona jedan">
				<h3>Kontakt</h3>
				<p>	📱 Mob: +387603108108<br>
				☎ Fiksni: +38733815401<br>
				 </p>
				</p>
			</div>
		</div>
		<script type="text/javascript" src="kod.js"></script>
	</body>  
</html>
