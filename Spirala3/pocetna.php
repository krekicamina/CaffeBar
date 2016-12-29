<?php
	$error=false;
	if(isset($_POST['login'])){
		
		$username = htmlEntities($_POST['username'], ENT_QUOTES);
		$username = preg_replace('/[^A-Za-z0-9 ščćžđŠČĆŽĐ]/', '', $username);
		$password = md5($_POST['password']);
		$passError='';
		$nameError='';
		if (!preg_match("/^[a-zA-Z]+$/",$username)) {
			$nameError = "Samo slova i brojevi u username-u"; 
		}	
		if(strlen($password)<9){
			$passError='Password mora imati više od 8 karaktera';
		}
		if(!preg_match("/[0-9]/",$password)) {
			$passError='Password mora imati makar jedan broj';
		}
		if($nameError=='' && $passError==''){
		if(file_exists('users/' . $username . '.xml')){
			$xml=new SimpleXMLElement('users/' . $username . '.xml', 0, true);
			if($password==$xml->password){
				session_start();
				$_SESSION['username']=$username;
				header('Location:pocetna.php');
				die;
			}
		}
		}
		if ($nameError!='' && $passError!=''){
			echo '<p>$passError</p>';
			echo '<p>$nameError</p>'; 
		}
		$error=true;
	}

	

	$greske_email = array();
	$bezGreske = true;
	if(isset($_POST['ok'])){
		$email = htmlEntities($_POST['email'], ENT_QUOTES);
		$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
		if(!preg_match($pattern, $email)){
			$greske_email[] = "Email nije ispravan.";
			$bezGreske = false;
		}
		
		if($bezGreske){
			$xml = new SimpleXMLElement('<?xml version = "1.0" encoding = "utf-8"?><podaci></podaci>');
			$xml->addChild('email', $email);
			
			$xml->asXML('newsletteri/' . 'email_' . date("Y-m-d-H-i-s"). '.xml');
			header('Location: pocetna.php');
			die;
		}
		unset($_POST['ok']);
	}
	
	session_start();
	
	if(isset($_POST['pdfDownload'])){
		require('fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont("Arial", "B", 14);
		$tekst = "CaffeBar - izvjestaj o pristiglim prijavama za newsletter";
	
		$pdf->Cell(50, 10, $tekst, 0, 1);
	
		$pdf->Cell(100, 10, "", 0, 1);
		$fajlovi = glob('newsletteri/*.xml');
		if(count($fajlovi)>0){
			$pdf->SetFont("Arial", "B", 12);
			$tekst = "Prijavljeni mailovi su: ";
			$pdf->Cell(50, 10, $tekst, 0, 1);
		}
	
		$pdf->SetFont("Arial", "", 12);
		foreach($fajlovi as $fajl) {
			$xml=new SimpleXMLElement($fajl, 0, true);
			$tekst=$xml->email;
		
			$pdf->Cell(30, 10, "email", 1, 0);
			$pdf->Cell(150, 10, $tekst, 1, 1);
			$tekst = $xml->email;
	
		}
		$pdf->Output('D','CaffeBarIzvjestaj.pdf');
	}
	
	if(isset($_POST['csvDownload'])){
		ob_end_clean();
		header('Content-Type: text/csv; charset = utf-8');
		header('Content-Disposition: attachment; filename = newsletteri.csv');
		$fp = fopen('php://output', 'w');
		$fajlovi = glob('newsletteri/*.xml');
		foreach($fajlovi as $fajl) {
			$xml = new SimpleXMLElement($fajl, 0, true);
			$red = array($xml->email);
			fputcsv($fp, $red, ',');
		}
		exit();
	}

$prikaz="";
	if(isset($_POST['dugmetrazi'])){
		$tekst=htmlEntities($_POST['unostrazi'], ENT_QUOTES);
		$tekst=preg_replace("#[^0-9a-zA-Z ščćžđŠČĆŽĐ]#i", "", $tekst);
		if(strlen($tekst)>0) {
			$za_prikaz=array();
			$fajlovi=glob('cjenovnik/*.xml');
			foreach($fajlovi as $fajl) {
				$xml = new SimpleXMLElement($fajl, 0, true);
				if(stristr($xml->proizvod, $tekst)){
					$za_prikaz[] = $xml->proizvod;
				}
				if (stristr($xml->cijena, $tekst)){
					$za_prikaz[] = $xml->cijena;
				}
			}
			$nadjeno=count($za_prikaz);
			if($nadjeno==0){
				$prikaz = "Nema rezultata za uneseni tekst";
			}
			else {
				$prikaz .= '<br><div style="color:white;"> Za uneseni tekst: "' . htmlspecialchars($tekst, ENT_QUOTES, 'UTF-8') . '" postoje sljedeći rezultati:</div><br>';
				foreach($za_prikaz as $rez){
					$prikaz .= '<div style="color:white;"> ' . htmlspecialchars($rez, ENT_QUOTES, 'UTF-8') . '</div>';
				}
			}
		}
		else {
			$prikaz = "Neispravan tekst za pretragu";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<title>Caffe Bar</title>  
	</head>
	
	<body>
	
	<?php
	if (isset($_REQUEST['ok'])){
		$xml=new DOMDocument("1.0","UTF-8");
		$xml->load("newsletter.xml");
		$rootTag=$xml->getElementsByTagName("document")->item(0);
		$dataTag=$xml->createElement("podaci");
		
		$Test2Tag=$xml->createElement("email",$_REQUEST['email']);
		$dataTag->appendChild($Test2Tag);
		
		$rootTag->appendChild($dataTag);
		$xml->save("newsletter.xml");
	}
	?>
	
	<script type="text/javascript" src="pocetnaKod.js"></script>
		<div class="red" id="pozadina">
			<ul class="header" id="mytopnav">
				<li><a class="active" href="pocetna.php">O nama</a> </li>
				<li><a class="podstranica" href="aktuelno.php">Aktuelno</a> </li>
				<li><a class="podstranica" href="ponuda.php">Ponuda</a> </li>
				<li><a class="podstranica" href="galerija.php">Galerija</a></li>	        
				<li><a class="podstranica" href="kontakt.php">Kontakt</a></li>
				<li class="ikonica">
					<a href="javascript:void(0);" style="font-size:70px;" onclick="dropDownFunkcija()">☰</a>
				</li>
			</ul>
		</div>
		<p class="quote">“As long as there was coffee in the world, how bad could things be?” </p>
		<div class="red">
			<div class="kolona dva" id="kolonalogin">
				<?php 
				if (isset($_SESSION['username'])){

				if(stristr($_SESSION['username'], "Amina")){
				echo '<form id="logout" action="logout.php" method="post" accept-charset="utf-8">
					<p> Prijavljeni ste!</p>
					<input type="submit" id="dugmelogout" value="Log out" />
				</form>';
				}
				
				else if(stristr($_SESSION['username'], "Korisnik")){
				echo '<form id="logout" action="logout.php" method="post" accept-charset="utf-8">
					<p> Prijavljeni ste! </p>
					<input type="submit" id="dugmelogout" value="Log out" />
				</form>';
				}
				}
				else {
				echo '<form id="login" action="pocetna.php" method="post">
					<img src="login-icon.png" alt="login" id="loginIcon">
					<p class="korisnickoime">
						<input name="username" type="text" placeholder="Username" id="username" />
						<span id="usernameError" class="err">Unesite ispravan username!</span>
						<span id="usernameSuccess" class="suc">Username format ispravan ✓</span>
					</p>
					<img src="pass-icon.png" alt="login" id="loginIcon">
					<p class="korisnickasifra">
						<input name="password" type="password" placeholder="Password" id="password1" />
						<span id="password1Error" class="err">Unesite ispravan password!</span>
						<span id="password1Success" class="suc">Password format ispravan ✓</span>
					</p>
					<input type="submit" id="dugmelogin" value="Log in" name="login" onclick="return SimulateSubmit3()"/>
					</form>';
				
					if($error){
						echo '<span style = "color:red;">Pogrešan username ili password</span>';
						$error=false;
					}
				}
				?>
				<?php
					if($error){
					echo '<p>Invalid username and password</p>';
					}
				?>
			<br><br>
			
			</div>
			<div class="kolona dva" id="kolonapretraga">
				<form id="pretraga" action="pocetna.php" method="post"> 
					<img src="search-icon.png" alt="search" id="searchIcon">
					<input type="text" id="unostrazi" name="unostrazi" placeholder="Traži..." onkeyup="prikazi(this.value)">
					<input type="submit" name="dugmetrazi" id="dugmetrazi" value="Traži" >
					<div id="prikazpretrage"></div>
				</form>
				<div id="divzaprikazpretrage"></div>
			</div>
		</div>
		<?php
		if (isset($_SESSION['username'])){
		if(stristr($_SESSION['username'], "Amina")){
			echo'<form method="post" action="pocetna.php"><h2><br>Zdravo, Amina. Da biste pogledali izvještaj sa prijavljenim mailovima kliknite ovdje: 
			<input type="submit" id="pdfDownload" value="PDF" name="pdfDownload"/> <input name="csvDownload" type="submit" id="csvDownload" value="CSV"></h2></form>';
		}
		}
		?>
	
		
		<div class="red">
		<div class="kolona cetri">
			Caffe Bar je nezaobilazno mjesto vrhunskog užitka i ugođaja za svakog slučajnog i namjernog posjetioca. Mi smo tu da Vam pružimo najkvalitetniju uslugu 
			i ponudimo nešto što do sada niste vidjeli niti probali. Posebnu pažnju posvećujemo rasporedu pozitivne energije prostora, spajamo urbano s modernim i 
			ugodnost sa elegancijom. <br> Posjetite nas tokom dana i uživajte uz Vaš omiljeni espresso, a svoje večernje izlaske doživite na jedinstven način uz 
			čašu dobrog vina. <br> Moderno uređeni prostor Caffe Bar-a je mjesto za ugodno ispijanje prve jutarnje kafe, kao i za kasnija druženja u jedinstvenom
			ambijentu. <br>Vikendom ne propustite live svirke, a kod nas možete uvijek proslaviti i rođendane, djevojačke/momačke večeri ili prisustvovati
			zanimljivom promotivnom eventu. <br> <br> KADA STE U CAFFE BAR-U - UVIJEK STE NA PRAVOM MJESTU!<br><br>
		</div>
		</div>
		
		<div class="red" id="forma-main1">
				<div class="kolona dva">
					<div id="mapa">
						Da biste nas lakše pronašli pogledajte mapu:<br><br>
						<img src="lokacija.jpg" alt="lokacija">
					</div>
				</div>
				
				<div class="kolona dva">
					Prijavite se i budite uvijek obaviješteni o novostima:<br><br>
					<form class="forma" method="post" action="pocetna.php">
						<input name="email" type="text" placeholder="E-mail" id="Test2" onblur="validateEmail('Test2')"/>
						<span id="Test2Error" class="err">Unesite ispravan e-mail!</span>
						<span id="Test2Success" class="suc">E-mail ispravan ✓</span>
						<br> 
						<div class="submit">
							<input type="submit" name="ok" value="Prijavi se!" id="prijavise" onclick="return SimulateSubmit1()"/>
						</div> <br>
					</form>
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
		<script>
		function prikaziRezultate(tekst){
			document.getElementById("divzaprikazpretrage").innerHTML = tekst;
		}
		
		function prikazi(str) {
			if (str.length==0) { 
				document.getElementById("prikazpretrage").innerHTML="";
				document.getElementById("prikazpretrage").style.border="0px";
			return;
		}
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else {  // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
				document.getElementById("prikazpretrage").innerHTML=this.responseText;
				document.getElementById("prikazpretrage").style.border="3px solid #E2DD91;";
			}
		}
		xmlhttp.open("GET","pretraga.php?q="+str,true);
		xmlhttp.send();
		}
		</script>
		<?php
			echo "<script>prikaziRezultate('$prikaz'); </script>";
		?>
	</body>  
</html>