<?php
$send_error = array();
$no_error = true;
	if(isset($_POST['ok1'])){
		$ime=htmlEntities($_POST['ime'], ENT_QUOTES);
		$ime=preg_replace("#[^a-zA-Z ščćžđŠČĆŽĐ]#i", "", $ime);
		$validacija = preg_replace("#[^a-zA-ZščćžđŠČĆŽĐ]#i", "", $ime);
		if(strlen($validacija)<2) {
			$send_error[]="Ime mora sadržati minimalno dva karaktera.";
			$no_error=false;
		}
		$email = htmlEntities($_POST['email'], ENT_QUOTES);
		$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
		if((preg_match($pattern, $email))==0){
			$send_error[]="Email nije ispravan.";
			$no_error=false;
		}
		$poruka = htmlEntities($_POST['poruka'], ENT_QUOTES);
		$poruka = preg_replace("#[^0-9a-zA-Z ščćžđŠČĆŽĐ]#i", "", $poruka);
		$validacija = preg_replace("#[^0-9a-zA-ZščćžđŠČĆŽĐ]#i", "", $poruka);
		if(strlen($validacija)<2) {
			$send_error[]="Poruka mora sadržati minimalno dva karaktera.";
			$no_error=false;
		}
		unset($_POST['ok1']);
	}
	session_start();
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
	<?php
	if (isset($_REQUEST['ok1'])){
		$xml=new DOMDocument("1.0","UTF-8");
		$xml->load("kontakt.xml");
		$rootTag=$xml->getElementsByTagName("document")->item(0);
		$dataTag=$xml->createElement("podaci");
		
		$Test3Tag=$xml->createElement("ime",$_REQUEST['ime']);
		$Test1Tag=$xml->createElement("email",$_REQUEST['email']);
		$Test4Tag=$xml->createElement("poruka",$_REQUEST['poruka']);
		
		$dataTag->appendChild($Test3Tag);
		$dataTag->appendChild($Test1Tag);
		$dataTag->appendChild($Test4Tag);
		
		$rootTag->appendChild($dataTag);
		$xml->save("kontakt.xml");
	}
	?>
	<script type="text/javascript" src="kontaktKod.js"></script>
		<div class="red" id="pozadina">
			<ul class="header" id="mytopnav">
				<li><a class="podstranica" href="pocetna.php">O nama</a> </li>
				<li><a class="podstranica" href="aktuelno.php">Aktuelno</a> </li>
				<li><a class="podstranica" href="ponuda.php">Ponuda</a> </li> 
				<li><a class="podstranica" href="galerija.php">Galerija</a></li>	        
				<li><a class="active" href="kontakt.php">Kontakt</a></li>
				<li class="ikonica">
					<a href="javascript:void(0);" style="font-size:70px;" onclick="dropDownFunkcija()">☰</a>
				</li>
			</ul>
		</div>
		
		
		<h2><br>Vaša pitanja, eventualne sugestije i prijedloge za saradnju možete nam uputiti putem slijedećeg web kontakt formulara:<br><br></h2>
		<div class="red" id="forma-main">
			<div class="kolona dva" id="forma-div">
				<form class="forma" id="formaId" method="post" action="">
					<p class="ime">
						<input name="ime" type="text" placeholder="Ime" id="Test3" onblur="validateName('Test3')"/>
						<span id="Test3Error" class="err">Unesite ispravno ime!</span>
						<span id="Test3Success" class="suc">Ime ispravno ✓</span>
					</p>
					<script type="text/javascript" src="kod.js"></script>
					<p class="email">
						<input name="email" type="text" placeholder="E-mail" id="Test1" onblur="validateEmail('Test1')"/>
						<span id="Test1Error" class="err">Unesite ispravan e-mail!</span>
						<span id="Test1Success" class="suc">E-mail ispravan ✓</span>
					</p>
					<p class="poruka">
						<textarea name="poruka" type="text" placeholder="Poruka" id="Test4" onblur="validateMessage('Test4')"></textarea>
						<span id="Test4Error" class="err">Unesite poruku!</span>
						<span id="Test4Success" class="suc">Poruka ispravna ✓</span>
					</p>
					<script type="text/javascript" src="kod.js"></script>
					<div class="submit">
						<input type="submit" name="ok1" value="Pošalji" id="posalji1" onclick="return SimulateSubmit()"/>
					</div>
					<?php
						if(count($send_error) > 0){
							echo '<ul>';
							foreach($send_error as $g){
								echo '<li style = "color:red; list-style: none;">- ' . $g . '</li>';
							}
							echo '</ul>';
						}
					?>
					<script type="text/javascript" src="kod.js"></script>
					<div class="ease"></div>
				</form>
			</div>
			
			<div class="kolona dva" id="marketing">
				<strong>MARKETING I OGLAŠAVANJE</strong> <br>
				marketing@caffebar.ba<br><br>
				<strong>INFO I UPITI</strong> <br>
				info@caffebar.ba
			</div>
		</div>
		
		
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
			</div>
		</div>

	</body>  
</html>