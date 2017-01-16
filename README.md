Caffe Bar
Amina Krekić 16632

-Web stranica informacionog karaktera o CaffeBar-u-

SPIRALA 4

1. Šta je urađeno?
Dodane su dvije forme: forma za registraciju na početnoj stranici, koja je vidljiva svima i forma za predlaganje stavki cjenovnika, na podstranici ponuda, koju mogu vidjeti samo logovani korisnici. 
Napravljena je baza podataka caffebar, sa tri povezane  i dvije nepovezane tabele. Tabele koje su povezane su users (svi registrovani korisnici, primarni ključ je username), prijedlozi (svi prijedlozi logovanih korisnika, primarni ključ je id), i cjenovnik (sve stavke iz cjenovnika, primarni ključ je id, a foreign key ima na tabelu users (korisnik) i na tabelu prijedlozi (proizvodFK)). Preostale dvije tabele su newsletteri i kontakt i imaju svoje id-ove kao primarne ključeve. 
Dodano je dugme xmlUbazu, koje je vidljivo samo administratoru, i klikom na to dugme, svi podaci iz xml-ova se prebacuju u bazu. Radi se provjera duplikata, tako da se prebacuju samo podaci koji se ne nalaze u bazi. Samo se u tabelu kontakt ne može prebacivati iz xml-a, jer mislim da nema potrebe za tim, iz forme za kontakt se podaci spremaju i u jedan XML fajl, i u bazu podataka, ali ako griješim i ako je i to trebalo uraditi, uradilo bi se na isti način kao i za sve ostale tabele.
PHP skripte su prepravljene, tako da se podaci čuvaju u bazi podataka, a ne u XML fajlovima. 
Napravljena je jedna metoda REST web servisa (GET metoda), koja vraća podatke o proizvodi koji odgovara zadanom id-u, u oblik JSON-a. Metoda je implementirana u fajlu webservis.php. Ukoliko proizvod sa unesenim id-om ne postoji u bazi, dolazi do greške, i ispisuje se poruka. 
Izvještaj, odnosno screenshotovi na kojima se vidi testiranje web servisa koristeći POSTMAN se nalaze u folderu "Postman_izvjestaj". 

login podaci: 
admin ----> username: amina
		password:amina123
2. Šta nije urađeno?
Nije napravljen hosting stranice na OpenShift.
3. Bugovi koje ste primjetili, ali niste stigli ispraviti, a znate rješenja (opis rješenja)?
Prilikom testiranja svake stranice na mom laptopu, bugove nisam primjetila.
4. Bugovi koje ste primjetili, ali ne znate rješenje?
Prilikom testiranja svake stranice na mom laptopu, bugove nisam primjetila.
5. Lista fajlova u formatu NAZIVFAJLA - Opis u vidu jedne rečenice šta se u fajlu nalazi.
U spirali 3 na github su postavljeni i stari .html fajlovi i još neki fajlovi koji su zapravo bespotrebni, tako da vas molim da ih ignorišete. Pri pokretanju stranice treba krenuti od pocetna.php.
pocetna.php - Početna stranica koja sadrži osnovne informacije o CaffeBar-u, sliku lokacije, formu za prijavu za newsletter, login formu, formu za registraciju. Ukoliko je logovan admin, na ovoj stranici mu se nalaze dugmad za download podataka u obliku .csv i .pdf fajlova, kao i prebacivanje podataka iz XML-a u bazu.
aktuelno.php - Podstranica koja sadrži najave nadolazećih događaja, novosti, važna obavještenja i slično
ponuda.php - Podstranica na kojoj se nalazi carousel, te tabela sa proizvodima i cijenama. Ukoliko je logovan admin, na ovoj podstranici ima mogućnost uređivanja, brisanja i dodavanja proizvoda i njihovih cijena. Samo mora voditi računa o jedinstvenom broju proizvoda, jer se ne može dodati proizvod sa već postojećim jedinstvenim brojem u tabeli. Ukoliko je logovan bilo koji korisnik, ima mogućnost pisanja prijedloga proizvoda koje želi vidjeti u ponudi. 
galerija.php - Podstranica na kojoj se nalaze galerije fotografija sa prethodnih događaja
kontakt.php - Podstranica koja sadrži formu za kontakt, kontakt e-mail za marketing i oglašavanje
style.css - css kod stranice
kod.js - javascript fajl sa funkcijama za dropdown meni i carousel
kontaktKod.js - javascript fajl sa funkcijama za validaciju forme za kontakt i localStorage
pocetna.Kod.js - javascript fajl sa funkcijama za validaciju forme za newsletter i localStorage, kao i funkcijom prikazi, koja prima unesenu vrijednost iz polja za pretragu, i funkcijom prikazirezultate koja ispisuje rezultate ispod pretrage nakon pritiska na dugme traži
pretraga.php - php fajl koji vrši pretraživanje XML fajlova unutar foldera cjenovnik i šalje kao odgovor rezultat pretrage
webservis.php - php fajl u kojem se nalazi GET metoda REST web servisa koja vraća podatke u obliku JSON-a
kontakt.xml - xml fajl u kojem se nalaze svi podaci koji se unesu u formu kontakt
folder Postman_izvjestaj - folder u kojem se nalaze screenshotovi na kojima je prikazano testiranje web servisa
folder cjenovnik - folder u koji se mogu smjestiti XML fajlovi, koji sadrže id, cijenu i naziv proizvoda, te admin pritiskom dugmeta xmlUbazu može da ih prebaci u bazu 
folder users - folder u koji se mogu smjestiti XML fajlovi sa podacima koji sadrže username, password i email korisnika 
folder newsletteri - folder u koji se mogu smjestiti XML fajlovi koji sadrže emailove koji su uneseni u formu na početnoj stranici 
caffebar.sql -  export baze sa phpMyAdmin


SPIRALA 3

1.Šta je urađeno?

Upotrebom PHP-a urađena je serijalizacija svih podataka u XML fajlove. Za serijalizaciju podataka iz forme za kontakt korišten je DOMDocument, te su svi podaci koji se unesu u formu kontakt odmah spremljeni u kontakt.xml. Za rad sa XML-om prilikom serijalizacije forme za newsletter korišten je SimpleXML, te su svi podaci koji se unesu u formu newsletter odmah smješteni u folder newsletteri, kao pojedinačni XML fajlovi. 
Sadržaj stranice se može čitati i bez obavezne prijave (logina). U XML fajlu u folderu users sačuvana su dva korisnika, amina i korisnik. Amina kao admin, ima mogućnost unosa, izmjene, prikazivanja i brisanja stavki iz cjenovnika koje se nalaze na podstranici ponuda.php. Svaka stavka u tabeli je označena nekim posebnim brojem koji je jedinstven za svaku stavku, čisto zbog jednostavnosti izmjene. Sve stavke su serijalizovane u XML fajlove (koristeći SimpleXML) i nalaze se u folderu cjenovnik, a spremljene su pod nazivom jedinstvenibroj.xml. U foldere users, newsletteri i cjenovnik, ubačen je .htaccess file koji onemogućava čitanje sadržaja tih foldera. Passwordi za korisnika i admina su kodirani pomoću md5 funkcije. 
Svi podaci koji se unose u XML fajlove su validirani. Što se tiče unosa i izmjene podataka koje vrši admin, pomoću funkcije preg_replace(), ukoliko se unese neki specijalni simbol, ignorira se, da se ne bi bespotrebno ispisivala greška adminu.
Omogućen je download podataka za admina, tj. na podstranici pocetna.php, admin ima mogućnost da downloaduje .csv fajl sa pristiglim emailovima za prijavu newslettera. Podaci se u .csv fajl prebacuju iz XML fajlova iz foldera newsletteri. 
Admin na podstranici pocetna.php, ima mogućnost da downloaduje izvještaj koji sadrži emailove za prijavu newslettera u obliku .pdf fajla. Za to je korištena fpdf biblioteka. Podaci su iz XML fajlova iz foldera newsletteri. 
Napravljena je opcija pretrage podataka sa prijedlozima. Dok korisnik (logovani ili ne-svejedno), upisuje vrijednost pretrage, prikazuje mu se do deset najsličnijih stavki iz tabele cjenovnik.  Nakon klika na dugme traži, ispisuju se sve stavke iz cjenovnika koje sadrže uneseni tekst. Podaci koji se pretražuju su iz XML fajlova iz foldera cjenovnik.

login podaci: 
admin ----> username: amina  ;
		password:amina123
  ;korisnik ----> username: korisnik  ;
		password:korisnik123
		
2.Šta nije urađeno?

Nije urađen deployment (još uvijek).

3.Bugovi koje ste primjetili, ali niste stigli ispraviti, a znate rješenja (opis rješenja)?

Prilikom testiranja svake stranice na mom laptopu, bugove nisam primjetila.

4.Bugovi koje ste primjetili, ali ne znate rješenje?

Prilikom testiranja svake stranice na mom laptopu, bugove nisam primjetila.

5.Lista fajlova u formatu NAZIVFAJLA - Opis u vidu jedne rečenice šta se u fajlu nalazi.

U spirali 3 na github su postavljeni i stari .html fajlovi i još neki fajlovi koji su zapravo bespotrebni, tako da vas molim da ih ignorišete. Pri pokretanju stranice treba krenuti od pocetna.php.

pocetna.php - Početna stranica koja sadrži osnovne informacije o CaffeBar-u, sliku lokacije, formu za prijavu za newsletter, login formu. Ukoliko je logovan admin, na ovoj stranici mu se nalaze dugmad za download podataka u obliku .csv i .pdf fajlova.

aktuelno.php - Podstranica koja sadrži najave nadolazećih događaja, novosti, važna obavještenja i slično

ponuda.php - Podstranica na kojoj se nalazi carousel, te tabela sa proizvodima i cijenama. Ukoliko je logovan admin, na ovoj podstranici ima mogućnost uređivanja, brisanja i dodavanja proizvoda i njihovih cijena. Samo mora voditi računa o jedinstvenom broju proizvoda, jer se ne može dodati proizvod sa već postojećim jedinstvenim brojem u tabeli.  

galerija.php - Podstranica na kojoj se nalaze galerije fotografija sa prethodnih događaja

kontakt.php - Podstranica koja sadrži formu za kontakt, kontakt e-mail za marketing i oglašavanje

style.css - css kod stranice

kod.js - javascript fajl sa funkcijama za dropdown meni i carousel

kontaktKod.js - javascript fajl sa funkcijama za validaciju forme za kontakt i localStorage

pocetna.Kod.js - javascript fajl sa funkcijama za validaciju forme za newsletter i localStorage, kao i funkcijom prikazi, koja prima unesenu vrijednost iz polja za pretragu, i funkcijom prikazirezultate koja ispisuje rezultate ispod pretrage nakon pritiska na dugme traži

pretraga.php - php fajl koji vrši pretraživanje XML fajlova unutar foldera cjenovnik i šalje kao odgovor rezultat pretrage

kontakt.xml - xml fajl u kome se nalaze svi podaci koji se unesu u formu kontakt

folder cjenovnik - folder u kome su smješteni XML fajlovi, koji sadrže id, cijenu i naziv proizvoda koji se nalaze u ponudi

folder users - folder u kome je smješteni XML fajlovi sa podacima o adminu i korisniku (hardkodirani podaci u XML)

folder newsletteri - folder u kome su smješteni XML fajlovi koji sadrže emailove koji su uneseni u formu na početnoj stranici 
