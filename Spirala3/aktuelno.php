<?php
	session_start();
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
	<script type="text/javascript" src="kod.js"></script>
		<div class="red" id="pozadina">
			<ul class="header" id="mytopnav">
				<li><a class="podstranica" href="pocetna.php">O nama</a> </li>
				<li><a class="active" href="aktuelno.php">Aktuelno</a> </li>
				<li><a class="podstranica" href="ponuda.php">Ponuda</a> </li> 
				<li><a class="podstranica" href="galerija.php">Galerija</a></li>	        
				<li><a class="podstranica" href="kontakt.php">Kontakt</a></li>
				<li class="ikonica">
					<a href="javascript:void(0);" style="font-size:70px;" onclick="dropDownFunkcija()">☰</a>
				</li>
			</ul>
		</div>	 	
		
		<p class="quote">“Coffee is a way of stealing time that should by rights belong to your older self.”</p>
		
		<div class="red">
			<div class="kolona tri">
				<div class="red">
					<div class="kolona dva"><strong>Od sada našu kafu možete piti i kući!</strong> <br>
					Zaželjeli ste se naše kafe ili čaja a niste u mogućnosti da dođete do nas?
					Od sada možete naručiti sve kafe ili čajeve iz naše široke ponude i mi ćemo Vam dostaviti na adresu.
					<br> <br> Vaš Caffe Bar.<br><span style="float:right; font-size:11px">4.novembar 2016.</span><br><br>
					</div>
					<div class="kolona dva"><strong>Vrijeme je za kuhano vino!</strong> <br>
					Večeras u bašti kuhamo vino. To je jedan od omiljenih zimskih napitaka koji grije svaku stanicu u tijelu i kada se temperatura spusti ispod nule.
					Dođite i uživajte u live svirci uz promotivne cijene.  
					<br> <br> Vaš Caffe Bar.<br><span style="float:right; font-size:11px">2.novembar 2016.</span><br><br>
					</div>
				</div>
				<div class="red">
					<div class="kolona dva"><strong>Promocija zdravih stilova života</strong> <br>
					Narednu subotu 5.11.2016. održat će se promocija zdravih stilova života te uvođenje novih napitaka u Caffe bar,
					gdje ćemo dijeliti uzorke novih napitaka kako biste dobili osvrt na ove okuse koji ulaze u jesensku ponudu napitaka našeg Caffe Bar-a.
					Nadamo se da ćemo stvoriti jednu zdravu svijest kod svojih sugrađana koji uvijek znaju gdje mogu u gradu popiti vrhunski napitak.
					<br> <br> Vaš Caffe Bar.<br><span style="float:right; font-size:11px">31.oktobar 2016.</span><br><br>
					</div>
					<div class="kolona dva"><strong>Književno veče u Caffe Bar-u</strong> <br>
					Čitanje je uvijek dobar izbor; uvijek nudi nove načine da se otisnemo u nepoznate svjetove, da doživimo nove pustolovine i probudimo
					osjećanja. Te ispisane stranice su često ogledalo onoga što u nama već postoji. Garantujemo Vam da se nećete pokajati, te Vas stoga
					pozivamo da prisustvujete fantastičnoj
					književnoj večeri u Caffe Bar-u koja će se održati 11. novembra 2016. u 19.00h.
					<br> <br> Vaš Caffe Bar.<br><span style="float:right; font-size:11px">21.oktobar 2016.</span><br><br>
					</div>
				</div>
			</div>
			<div class="kolona jedan" >
				<h4>Posebna ponuda:</h4>
				<img src="specijalnaponuda.jpg" alt="ponuda" id="specijalnaponuda">
			</div>

		</div>
		
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