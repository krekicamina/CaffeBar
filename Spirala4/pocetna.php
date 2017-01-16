<?php
	echo '<span style="color:#AFA;"></span>';
	$greske = array();
	if(isset($_POST['registracija'])){
		$username = htmlEntities($_POST['username'], ENT_QUOTES);
		$username = preg_replace('/[^A-Za-z0-9 ščćžđŠČĆŽĐ]/', '', $username);
		$email = htmlEntities($_POST['email'], ENT_QUOTES);
		$password = htmlEntities($_POST['password'], ENT_QUOTES);
		$password2 = htmlEntities($_POST['password2'], ENT_QUOTES);
		$veza = new PDO("mysql:dbname=caffebar; host=localhost; charset=utf8", "amina", "amina123");
		$veza->exec("set names utf8");
		
		$rezultat = $veza->prepare("SELECT * FROM users where username = '$username'");
		$rezultat->execute();
		$broj = $rezultat->rowCount();
		if ($broj > 0){
			$greske[] = 'Username već postoji';
		}
		
		if($username == ''){ $greske[] = 'Niste unijeli username'; }
		if($email == ''){ $greske[] = 'Niste unijeli email'; }
		if($password == '' || $password2 == ''){ $greske[] = 'Niste unijeli password'; }
		if($password != $password2){ $greske[] = 'Passwordi se ne poklapaju'; }
		if(strlen($password) < 8){ $greske[] = 'Password mora sadržati najmanje 8 karaktera'; }
		if(strlen($username) < 3){ $greske[] = 'Username mora sadržati najmanje 3 karaktera'; }
		if (!preg_match("/^[a-zA-Z0-9 ščćžđŠČĆŽĐ]*$/", $password)) { $greske[] = 'Password može sadržati samo slova i brojeve'; }
		if (!preg_match("/^[a-zA-Z0-9 ščćžđŠČĆŽĐ]*$/", $username)) { $greske[] = 'Username može sadržati samo slova i brojeve'; }
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $greske[] = "Neispravan format e-maila"; }
		if(count($greske) == 0){
			$pass = md5($password);
			$rezultat = $veza->prepare("INSERT INTO users (username, password, email)
			VALUES ('$username', '$pass', '$email')");
			$rezultat->execute();
			header('Location: pocetna.php');
			die;
		}
	}

	

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
			$veza = new PDO("mysql:dbname=caffebar; host=localhost; charset=utf8", "amina", "amina123");
			$veza->exec("set names utf8");
			$rezultat = $veza->prepare("SELECT * FROM users where username = '$username'");
			$rezultat->execute();
			$broj = $rezultat->rowCount();
			if ($broj > 0){
				$red = $rezultat->fetch(PDO::FETCH_OBJ);
				if($password == $red->password){
					session_start();
					$_SESSION['username'] = $username;
					header('Location: pocetna.php');
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

	
	session_start();
	$server = "localhost";
	$korisnik = "amina";
	$pass = "amina123";
	$baza = "caffebar";
	$veza = mysqli_connect($server, $korisnik, $pass, $baza);
	mysqli_set_charset($veza, 'utf8');
	if (!$veza) {
		die("Connection failed: " . mysqli_connect_error());
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
			$upit = "INSERT INTO newsletteri (id, email)
			VALUES (DEFAULT, '$email')";
			if (mysqli_query($veza, $upit)) {
				echo "";
			}
			else {
				echo "Greška: " . $upit . "<br>" . mysqli_error($veza);
			}
			header('Location: pocetna.php');
			die;
		}
		unset($_POST['ok']);
	}
	
	
	if(isset($_POST['pdfDownload'])){
		ob_start ();
		require('fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont("Arial", "B", 14);
		$tekst = "CaffeBar - izvjestaj o pristiglim prijavama za newsletter";
	
		$pdf->Cell(50, 10, $tekst, 0, 1);
	
		$pdf->Cell(100, 10, "", 0, 1);
		$pdf->SetFont("Arial", "B", 12);
		$pdf->Cell(50, 10, "Prijavljeni mailovi su: ", 0, 1);
		
		$pdf->SetFont("Arial", "", 12);
		
		$veza = new PDO("mysql:dbname=caffebar; host=localhost; charset=utf8", "amina", "amina123");
		$upit = 'SELECT * FROM newsletteri';
		foreach($veza->query($upit) as $red) {
			$tekst = $red['email'];
			$pdf->Multicell(0, 2, "- " . $tekst . "\n\n\n");
		}
		$pdf->output('D','CaffeBarIzvjestaj.pdf');
		ob_end_flush(); 
	}
	
	if(isset($_POST['csvDownload'])){
		ob_end_clean();
		header('Content-Type: text/csv; charset = utf-8');
		header('Content-Disposition: attachment; filename = newsletteri.csv');
		$fp = fopen('php://output', 'w');
		$veza = new PDO("mysql:dbname=caffebar; host=localhost; charset=utf8", "amina", "amina123");
		$upit = 'SELECT * FROM newsletteri';
		foreach($veza->query($upit) as $red) {
			$red = array($red['email']);
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
	
	
	if(isset($_POST['xmlUbazu'])){
		$server = "localhost";
		$korisnik = "amina";
		$pass = "amina123";
		$baza = "caffebar";
		$veza = mysqli_connect($server, $korisnik, $pass, $baza);
		mysqli_set_charset($veza, 'utf8');
		if (!$veza) {
			die("Connection failed: " . mysqli_connect_error());
		}
		
		$fajlovi = glob('users/*.xml');
		foreach($fajlovi as $fajl) {
			$xml = new SimpleXMLElement($fajl, 0, true);
			$username = $xml->username;
			$password = $xml->password;
			$email = $xml->email;
			
			$provjeraDuplih = "SELECT * FROM users where username = '$username'";
			$rezultat = $veza->query($provjeraDuplih);
			if ($rezultat->num_rows < 1){
				$upit = "INSERT INTO users (username, password, email)
				VALUES ('$username', '$password', '$email')";
				if (mysqli_query($veza, $upit)) {
					echo "Upit uspješno izvršen!";
				}
				else {
					echo "Greška: " . $upit . "<br>" . mysqli_error($veza);
				}
			}
		}
		
		$fajlovi = glob('prijedlog/*.xml');
		foreach($fajlovi as $fajl) {
			$xml = new SimpleXMLElement($fajl, 0, true);
			$proizvod = $xml->proizvod;
			$cijena = $xml->cijena;
			
			$provjeraDuplih = "SELECT * FROM prijedlozi where proizvod = '$proizvod' and cijena = '$cijena'";
			$rezultat = $veza->query($provjeraDuplih);
			if ($rezultat->num_rows < 1){
				$upit = "INSERT INTO prijedlozi (id, proizvod, cijena)
				VALUES (DEFAULT, '$proizvod', '$cijena')";
				if (mysqli_query($veza, $upit)) {
					echo "Upit uspješno izvršen!";
				}
				else {
					echo "Greška: " . $upit . "<br>" . mysqli_error($veza);
				}
			}
		}
		
		$fajlovi = glob('newsletteri/*.xml');
		foreach($fajlovi as $fajl) {
			$xml = new SimpleXMLElement($fajl, 0, true);
			$email = $xml->email;
			
			$provjeraDuplih = "SELECT * FROM newsletteri where email = '$email'";
			$rezultat = $veza->query($provjeraDuplih);
			if ($rezultat->num_rows < 1){
				$upit = "INSERT INTO newsletteri (id, email)
				VALUES (DEFAULT, '$email')";
				if (mysqli_query($veza, $upit)) {
					echo "Upit uspješno izvršen!";
				}
				else {
					echo "Greška: " . $upit . "<br>" . mysqli_error($veza);
				}
			}
		}
		
		$fajlovi = glob('cjenovnik/*.xml');
		foreach($fajlovi as $fajl) {
			$xml = new SimpleXMLElement($fajl, 0, true);
			$ID = $xml->ID;
			$proizvod = $xml->proizvod;
			$cijena = $xml->cijena;
			$korisnik = 'N/A';
			$traziKorisnika = "SELECT * FROM users where username = 'amina'";
			$izvrsi = $veza->query($traziKorisnika);
			if($izvrsi->num_rows > 0) {
				$rez = mysqli_fetch_row($izvrsi);
				$korisnik = $rez[0];
			}
			$proizvodFK = -1;
			$traziFK = "SELECT * FROM prijedlozi where proizvod = '$proizvod' and cijena = '$cijena'";
			$izvrsi = $veza->query($traziFK);
			if($izvrsi->num_rows > 0) {
				$rez = mysqli_fetch_row($izvrsi);
				$proizvodFK = $rez[0];
			}
			$provjeraDuplih = "SELECT * FROM prijedlozi where id = '$ID'";
			$rezultat = $veza->query($provjeraDuplih);
			if ($rezultat->num_rows < 1){
				if($proizvodFK != -1) {
					$upit = "INSERT INTO cjenovnik (id, proizvod, cijena, korisnik, proizvodFK)
					VALUES ('$ID', '$proizvod', '$cijena', '$korisnik', '$proizvodFK')";
				}
				else{
					$upit = "INSERT INTO cjenovnik (id, proizvod, cijena, korisnik, proizvodFK)
					VALUES ('$ID', '$proizvod', '$cijena', '$korisnik', DEFAULT)";
				} 
				if (mysqli_query($veza, $upit)) {
					echo "Upit uspješno izvršen!";
				}
				else {
					echo "Greška: " . $upit . "<br>" . mysqli_error($veza);
				}
			}
		}
	
		header('Location: pocetna.php');
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
				
				else {
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
			echo'<form method ="post" action ="pocetna.php"><h2>U slučaju da želite prebaciti sve podatke iz XML fajlova u bazu podataka kliknite ovdje:
			<input type="submit" id="xmlUbazu" value="Prebaci" name="xmlUbazu"/></h2>';
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
				<?php
				if (isset ($_SESSION['username'])){
				echo 	
					'<div id="mapa">
						Da biste nas lakše pronašli pogledajte mapu:<br><br>
						<img src="lokacija.jpg" alt="lokacija">
					</div>';
						
				}
				else {
					echo '<form id="registracija" action="pocetna.php" method="post">
					<p>Želite se registrovati? Ispunite sljedeću formu!</p>
					
					<p class="korisnickoime">
						<p style="float:left;">Username:</p>
						<input name="username" type="text" placeholder="Username" id="usernameRegistracija"/>
					</p>
					
					<p class="email">
						<p style="float:left;">Email:</p>
						<input name="email" type="text" placeholder="E-mail" id="emailRegistracija"/>
					</p>
					
					<p class="korisnickasifra">
						<p style="float:left;">Password:</p>
						<input name="password" type="password" placeholder="Password" id="passwordRegistracija1"/>
					</p>
					
					<p class="korisnickasifra">
						<p style="float:left;">Password ponovo:</p>
						<input name="password2" type="password" placeholder="Password" id="passwordRegistracija2"/>
					</p>
					
					<input type="submit" id="dugmeregistracija" value="Registruj se!" name="registracija"/>
					</form>';
				
					if(count($greske) > 0){
						echo 'Greške pri pokušaju registracije:';
						foreach($greske as $g){
							echo '<li style = "color:red; list-style: none;">- ' . $g . '</li>';
						}
							
					}
				}
				?>
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