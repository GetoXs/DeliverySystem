<?php
/**
 * @author Dawid Myślak, Mateusz Przybyłek
 * @copyright 2011
 * 
*/

require_once("klasy/class.pracownik.php");
class Szablon
{
  private $name="tpl1";
  private $folder;
  public function __construct($folder)
  {
    $this->folder=$folder;
  }
	public function wyswietlPoczatek()
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="pl" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->folder.$this->name.".css"; ?>" />
	<title>Spedycja</title>
</head>
<body>
	<div id="strona">
		<div id="logo">
			<a href="index.php">
				<img src="obrazki/logo.png" alt="Logo" />
				<h1>Spedycja</h1> PANEL PRACOWNIKA
			</a>
		</div>
		<div id="zawartosc">
<?php
		}
		
		public function wyswietlFormularzLogowania()
		{
?>
<div id="nawigacja">
	<form action="index.php" method="post">
		<table>
			<tr>
				<td>Login: <input type="text" name="login" size="15" maxlength="50" /></td>
			</tr>
			<tr>
				<td>Hasło: <input type="password" name="haslo" size="15" maxlength="50" /></td>
			</tr>
			<tr>
				<td><input type="submit" value="Zaloguj się" /></td>
			</tr>
		</table>
	</form>
</div>
<?php
		}
		
		public function wyswietlPanel($actions)
		{
?>
<div id="nawigacja">
	<div id="menu_akcje">
		<h1>Panel pracownika - <?php echo Pracownik::$typArray[$_SESSION['typ']]; ?></h1>
		<ul><?php
    if(is_array($actions))
    {
      foreach($actions as $a)
      {
				echo "\n\t\t\t";
        switch($a)
        {
          case "edytujKarta": 
            echo "<li><a href=\"?akcja=edytujKarta\">Edycja Karty Przewozowej</a></li>";
            break;
          case "przegladajKarta": 
            echo "<li><a href=\"?akcja=przegladajKarta\">Przeglądaj Karty</a></li>";
            break;
          case "dodajPracownik": 
            echo "<li><a href=\"?akcja=dodajPracownik\">Dodaj Pracownika</a></li>";
            break;
          case "usunPracownik": 
            echo "<li><a href=\"?akcja=usunPracownik\">Usun Pracownika</a></li>";
            break;
          case "edytujPracownik": 
            echo "<li><a href=\"?akcja=edytujPracownik\">Edytuj Pracownika</a></li>";
            break;
          case "pokazPracownik": 
            echo "<li><a href=\"?akcja=pokazPracownik\">Przeglądaj pracowników</a></li>";
            break;
          case "wyloguj": 
            echo "<li><a href=\"?akcja=wyloguj\">Wyloguj się</a></li>";
            break;
        }
        
      }
    } 
      ?>
    </ul>
	</div>			
</div>
<?php
		}
		
		
		public function wyswietlEdycjeKarty(&$wynik, &$magazyn)
		{
			?>
	<form action="?akcja=edytujKarta" method="post">
		<div id="tytul">Edytuj Kartę przewozową</div>
		<table style="padding: 1px; border: 3px solid #cbd7fe;">
			<tr class="parzyste"><td class="dane">ID KP:</td><td style="font-weight: bold;" class="dane"><input type="hidden" name="id_kp" size="50" maxlength="50" value="<?php echo $wynik[0]['id_kp']; ?>" /><?php echo $wynik[0]['id_kp']; ?></td></tr>
			<tr class="nieparzyste"><td class="dane">Magazyn:</td><td class="req dane">
				<select name="id_m">
			<?php
				foreach($magazyn as $wiersz)
				{
					echo "
					<option value=\"".$wiersz["id_m"]."\"";
					echo ($wynik[0]['id_m']==$wiersz["id_m"])?" selected=\"1\"":"";
					echo ">".$wiersz['miejscowosc']."</option>";
				}
			?>
				</select> *</td>
			</tr>
			<tr class="parzyste"><td class="dane">Data nadania:</td><td class="dane"><input type="text" name="data_nadania" size="50" maxlength="50" value="<?php echo $wynik[0]['data_nadania']; ?>" />(rrrr-mm-dd lub puste)</td></tr>
			<tr class="nieparzyste"><td class="dane">Data dostarczenia:</td><td class="dane"><input type="text" name="data_dostarczenia" size="50" maxlength="50" value="<?php echo $wynik[0]['data_dostarczenia']; ?>" />(rrrr-mm-dd lub puste)</td></tr>
			<tr class="parzyste"><td class="dane">Kod pocztowy:</td><td class="req dane"><input type="text" name="kod_pocztowy" size="50" maxlength="50" value="<?php echo $wynik[0]['kod_pocztowy']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="req dane">* Wymagane pola</td><td class="dane"><input type="submit" value="Edytuj kartę" /></td></tr>
		</table>
	</form>
	<?php
		}
		
		public function wyswietlSzczegolyKarty(&$wynik, &$nadawca, &$magazyn)
		{
			require_once("klasy/class.kartaprzewozowa.php");
			echo $wynik[0]['m_miejscowosc'];
			?>
		<div id="tytul">Szczegóły Karty Przewozowej</div>
		<table style="padding: 1px; border: 3px solid #cbd7fe;">
			
			<tr class="naglowek"><td class="dane" style="width: 33%;">Dane nadawcy</td><td></td></tr>
			<tr class="nieparzyste"><td class="dane">Imię:</td><td class="dane"><?php echo $nadawca[0]['imie']; ?></td></tr>
			<tr class="parzyste"><td class="dane">Nazwisko:</td><td class="dane"><?php echo $nadawca[0]['nazwisko']; ?></td></tr>
			<tr class="nieparzyste"><td class="dane">Adres:</td><td class="dane"><?php echo $nadawca[0]['adres']; ?></td></tr>
			<tr class="parzyste"><td class="dane">Kod pocztowy:</td><td class="dane"><?php echo $nadawca[0]['kod_pocztowy']; ?></td></tr>
			<tr class="nieparzyste"><td class="dane">Miejscowość:</td><td class="dane"><?php echo $nadawca[0]['miejscowosc']; ?></td></tr>
			<tr class="parzyste"><td class="dane">Telefon:</td><td class="dane"><?php echo $nadawca[0]['telefon']; ?></td></tr>

			<tr class="naglowek"><td class="dane">Dane odbiorcy</td><td></td></tr>
			<tr class="nieparzyste"><td class="dane">Imię:</td><td class="dane"><?php echo $wynik[0]['imie']; ?></td></tr>
			<tr class="parzyste"><td class="dane">Nazwisko:</td><td class="dane"><?php echo $wynik[0]['nazwisko']; ?></td></tr>
			<tr class="nieparzyste"><td class="dane">Adres:</td><td class="dane"><?php echo $wynik[0]['adres']; ?></td></tr>
			<tr class="parzyste"><td class="dane">Kod pocztowy:</td><td class="dane"><?php echo $wynik[0]['kod_pocztowy']; ?></td></tr>
			<tr class="nieparzyste"><td class="dane">Miejscowość:</td><td class="dane"><?php echo $wynik[0]['miejscowosc']; ?></td></tr>
			<tr class="parzyste"><td class="dane">Telefon:</td><td class="dane"><?php echo $wynik[0]['telefon']; ?></td></tr>
			
			<tr class="naglowek"><td class="dane">Przesyłka</td><td></td></tr>
			<tr class="nieparzyste"><td class="dane">ID KP:</td><td class="dane"><?php echo $wynik[0]['id_kp']; ?></td></tr>
			<tr class="nieparzyste"><td class="dane">Magazyn:</td><td class="dane"><?php echo $magazyn[0]['adres']."<br />".$magazyn[0]['kod_pocztowy']." ".$magazyn[0]['miejscowosc']; ?></td></tr>
			<tr class="parzyste"><td class="dane">Rodzaj:</td><td class="dane"><?php echo KartaPrzewozowa::$rodzajArray[$wynik[0]['rodzaj']]; ?></td></tr>
			<tr class="nieparzyste"><td class="dane">Taryfa:</td><td class="dane"><?php echo KartaPrzewozowa::$priorytetArray[$wynik[0]['priorytet']]; ?></td></tr>
			<tr class="parzyste"><td class="dane">Cena:</td><td class="dane"><?php 
			if ($wynik[0]['cena'] == 0)	
				echo '-';
			else
				echo number_format($wynik[0]['cena'], 2) . ' zł';
			?></td></tr>
			<tr class="nieparzyste"><td class="dane">Status:</td><td class="dane"><?php echo KartaPrzewozowa::$statusArray[$wynik[0]['status']]; ?></td></tr>
			<tr class="parzyste"><td class="dane">Data nadania:</td><td class="dane"><?php echo ($wynik[0]['data_nadania'] == '0000-00-00')?'-':$wynik[0]['data_nadania']; ?></td></tr>
			<tr class="nieparzyste"><td class="dane">Data dostarczenia:</td><td class="dane"><?php echo ($wynik[0]['data_dostarczenia'] == '0000-00-00')?'-':$wynik[0]['data_dostarczenia']; ?></td></tr>
		</table>
		<?php 
		}
		
		public function wyswietlKarty(&$wynik)
		{
			require_once("klasy/class.kartaprzewozowa.php");
			?>
	<div id="tytul">Przegląd kart przewozowych</div>
		<table>
			<tr class="naglowek dane">
				<td>id</td>
				<td>Imię<br />Nazwisko</td>
				<td>Adres</td>
				<td>Kod<br />Miejscowośc</td>
				<td>Telefon</td>
				<td>Cena</td>
				<td>Priorytet</td>
				<td>Rodzaj</td>
				<td>Status</td>
				<td style="text-align: center;">Operacje</td>
			</tr>
			<?php
			$licznik = 1;
			foreach ($wynik as $wiersz)
			{
				if ($licznik % 2)
					$styl = 'nieparzyste';
				else
					$styl = 'parzyste';
				
				?>
			<tr class="<?php echo $styl; ?>">
				<td class="dane"><?php echo $wiersz['id_kp']; ?></td>
				<td class="dane"><?php echo $wiersz['imie']."<br />".$wiersz['nazwisko']; ?></td>
				<td class="dane"><?php echo $wiersz['adres']; ?></td>
				<td class="dane"><?php echo $wiersz['kod_pocztowy']."<br />".$wiersz['miejscowosc']; ?></td>
				<td class="dane"><?php echo $wiersz['telefon']; ?></td>
				<td class="dane"><?php 
				if ($wiersz['cena'] == 0)	
					echo '-';
				else
					echo number_format($wiersz['cena'], 2) . ' zł';
				?></td>
				<td class="dane"><?php echo KartaPrzewozowa::$priorytetArray[$wiersz['priorytet']]; ?></td>
				<td class="dane"><?php echo KartaPrzewozowa::$rodzajArray[$wiersz['rodzaj']]; ?></td>
				<td class="dane"><?php echo KartaPrzewozowa::$statusArray[$wiersz['status']]; ?></td>
				<td>
					<a href="?akcja=szczegolyKarta&id_kp=<?php echo $wiersz['id_kp']; ?>">Szczegóły</a><br />
					<a href="?akcja=edytujKarta&id_kp=<?php echo $wiersz['id_kp']; ?>">Edytuj</a>
				</td>
				
			</tr>
				<?php
				$licznik++;
			}
			echo '
		</table>';
		}
		
		public function wyswietlPracownikow(&$wynik)
		{?>
	<div id="tytul">Przegląd przesyłek</div>
		<table>
			<tr class="naglowek" style="text-align: left;">
				<td>id</td>
				<td>Imię</td>
				<td>Nazwisko</td>
				<td>Login</td>
				<td>Typ</td>
				<td>Adres</td>
				<td>Miejscowosc</td>
				<td>E-mail</td>
				<td>Telefon</td>
				<td>NIP</td>
				<td>Stawka</td>
				<td>Operacje</td>
			</tr>
			<?php
			$licznik = 1;
			
			
			foreach ($wynik as $wiersz)
			{
				if ($licznik % 2)
					$styl = 'nieparzyste';
				else
					$styl = 'parzyste';
				
				?>
			<tr class="<?php echo $styl; ?>">
				<td><?php echo $wiersz['id_p']; ?></td>
				<td class="dane"><?php echo $wiersz['imie']; ?></td>
				<td class="dane"><?php echo $wiersz['nazwisko']; ?></td>
				<td class="dane"><?php echo $wiersz['login']; ?></td>
				<td class="dane"><?php echo Pracownik::$typArray[$wiersz['typ']]; ?></td>
				<td class="dane"><?php echo $wiersz['adres']; ?></td>
				<td class="dane"><?php echo $wiersz['miejscowosc']; ?></td>
				<td class="dane"><?php echo $wiersz['email']; ?></td>
				<td class="dane"><?php echo $wiersz['telefon']; ?></td>
				<td class="dane"><?php echo $wiersz['NIP']; ?></td>
				<td class="dane"><?php echo $wiersz['stawka']; ?></td>
				
				<td>
				<?php if($wiersz['typ']==1 || $wiersz['typ']==2)
					{ ?>
					<a href="?akcja=edytujPracownik&id_p=<?php echo $wiersz['id_p']; ?>">Edycja</a><br />
					<a href="?akcja=usunPracownik&id=<?php echo $wiersz['id_p']; ?>">Usuń</a><br />
					<?php } ?>
				</td>
			</tr>
				<?php
				$licznik++;
			}
			echo '
		</table>';
		}
		public function wyswietlTworzeniePracownika()
		{
			?>
	<form action="?akcja=dodajPracownik" method="post">
		<div id="tytul">Stwórz pracownika</div>
		<table style="padding: 1px; border: 3px solid #cbd7fe;">
			<tr class="naglowek" ><td colspan="2" style="width: 150px;" class="dane">Dane personalne</td></tr>
			<tr class="nieparzyste"><td class="dane">Imię:</td><td class="req dane"><input type="text" name="imie" size="50" maxlength="50" value="<?php echo $_POST['imie']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">Nazwisko:</td><td class="req dane"><input type="text" name="nazwisko" size="50" maxlength="50" value="<?php echo $_POST['nazwisko']; ?>" /> *</td></tr>
			<tr class="nieparzyste"><td class="dane">Adres:</td><td class="req dane"><input type="text" name="adres" size="50" maxlength="50" value="<?php echo $_POST['adres']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">Kod pocztowy:</td><td class="req dane"><input type="text" name="kod_pocztowy" size="50" maxlength="50" value="<?php echo $_POST['kod_pocztowy']; ?>" /> *</td></tr>
			<tr class="nieparzyste"><td class="dane">Miejscowość:</td><td class="req dane"><input type="text" name="miejscowosc" size="50" maxlength="50" value="<?php echo $_POST['miejscowosc']; ?>" /> *</td></tr>
			<tr class="naglowek"><td colspan="2" style="width: 150px;" class="dane">Dane kontaktowe</td></tr>
			<tr class="nieparzyste"><td class="dane">Telefon:</td><td class="req dane"><input type="text" name="telefon" size="50" maxlength="50" value="<?php echo $_POST['telefon']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">E-mail:</td><td class="req dane"><input type="text" name="email" size="50" maxlength="50" value="<?php echo $_POST['email']; ?>" /> *</td></tr>
			<tr class="naglowek"><td colspan="2" style="width: 150px;" class="dane">Dane zarobkowe</td></tr>
			<tr class="nieparzyste"><td class="dane">NIP:</td><td class="req dane"><input type="text" name="NIP" size="50" maxlength="50" value="<?php echo $_POST['NIP']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">Pensja:</td><td class="req dane"><input type="text" name="stawka" size="50" maxlength="50" value="<?php echo $_POST['stawka']; ?>" /> *</td></tr>
			<tr class="naglowek"><td colspan="2" style="width: 150px;" class="dane">Dane systemowe</td></tr>
			<tr class="nieparzyste"><td class="dane">Login:</td><td class="req dane"><input type="text" name="login" size="50" maxlength="50" value="<?php echo $_POST['login']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">Hasło:</td><td class="req dane"><input type="password" name="haslo" size="50" maxlength="50" /> *</td></tr>
			<tr class="nieparzyste"><td class="dane">Typ konta:</td><td class="req dane"><select  name="typ">
					<option value="1"<?php if($_POST['typ']==1) echo " selected=\"1\""; ?>><?php echo Pracownik::$typArray[1] ?></option>
					<option value="2"<?php if($_POST['typ']==2) echo " selected=\"1\""; ?>><?php echo Pracownik::$typArray[2] ?></option>
			</select> *</td></tr>
			<tr class="parzyste"><td class="req dane">* Wymagane pola</td><td class="dane"><input type="submit" value="Utwórz pracownika" /></td></tr>
		</table>
	</form>
	<?php
		}
		public function wyswietlEdycjePracownika(&$wynik)
		{
			?>
	<form action="?akcja=edytujPracownik" method="post">
		<div id="tytul">Edytuj pracownika</div>
		<table style="padding: 1px; border: 3px solid #cbd7fe;">
			<tr class="naglowek" ><td colspan="2" style="width: 150px;" class="dane">Dane personalne</td></tr>
			<tr class="nieparzyste"><td class="dane">Imię:</td><td class="req dane"><input type="text" name="imie" size="50" maxlength="50" value="<?php echo $wynik[0]['imie']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">Nazwisko:</td><td class="req dane"><input type="text" name="nazwisko" size="50" maxlength="50" value="<?php echo $wynik[0]['nazwisko']; ?>" /> *</td></tr>
			<tr class="nieparzyste"><td class="dane">Adres:</td><td class="req dane"><input type="text" name="adres" size="50" maxlength="50" value="<?php echo $wynik[0]['adres']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">Kod pocztowy:</td><td class="req dane"><input type="text" name="kod_pocztowy" size="50" maxlength="50" value="<?php echo $wynik[0]['kod_pocztowy']; ?>" /> *</td></tr>
			<tr class="nieparzyste"><td class="dane">Miejscowość:</td><td class="req dane"><input type="text" name="miejscowosc" size="50" maxlength="50" value="<?php echo $wynik[0]['miejscowosc']; ?>" /> *</td></tr>
			<tr class="naglowek"><td colspan="2" style="width: 150px;" class="dane">Dane kontaktowe</td></tr>
			<tr class="nieparzyste"><td class="dane">Telefon:</td><td class="req dane"><input type="text" name="telefon" size="50" maxlength="50" value="<?php echo $wynik[0]['telefon']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">E-mail:</td><td class="req dane"><input type="text" name="email" size="50" maxlength="50" value="<?php echo $wynik[0]['email']; ?>" /> *</td></tr>
			<tr class="naglowek"><td colspan="2" style="width: 150px;" class="dane">Dane zarobkowe</td></tr>
			<tr class="nieparzyste"><td class="dane">NIP:</td><td class="req dane"><input type="text" name="NIP" size="50" maxlength="50" value="<?php echo $wynik[0]['NIP']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">Pensja:</td><td class="req dane"><input type="text" name="stawka" size="50" maxlength="50" value="<?php echo $wynik[0]['stawka']; ?>" /> *</td></tr>
			<tr class="naglowek"><td colspan="2" style="width: 150px;" class="dane">Dane systemowe</td></tr>
			<tr class="nieparzyste"><td class="dane">ID:</td><td style="font-weight: bold;" class="dane"><?php echo $wynik[0]['id_p']; ?><input type="hidden" name="id_p" size="50" maxlength="50" value="<?php echo $wynik[0]['id_p']; ?>" /></td></tr>
			<tr class="nieparzyste"><td class="dane">Login:</td><td class="req dane"><input type="text" name="login" size="50" maxlength="50" value="<?php echo $wynik[0]['login']; ?>" /> *</td></tr>
			<tr class="parzyste"><td class="dane">Nowe hasło:</td><td class="req dane"><input type="password" name="haslo" size="50" maxlength="50" /></td></tr>
			<tr class="nieparzyste"><td class="dane">Typ konta:</td><td class="req dane"><select  name="typ">
					<option value="1"<?php if($wynik[0]['typ']==1) echo " selected=\"1\""; ?>><?php echo Pracownik::$typArray[1] ?></option>
					<option value="2"<?php if($wynik[0]['typ']==2) echo " selected=\"1\""; ?>><?php echo Pracownik::$typArray[2] ?></option>
			</select> *</td></tr>
			<tr class="parzyste"><td class="req dane">* Wymagane pola</td><td class="dane"><input type="submit" value="Edytuj pracownika" /></td></tr>
		</table>
	</form>
	<?php
		}
		
		public function wyswietlSzukajPracownika()
		{?>
	<form action="?akcja=pokazPracownik" method="post">
		<div id="tytul">Wyszukaj pracownika</div>
			<table style="padding: 1px; border: 3px solid #cbd7fe;">
				<tr class="nieparzyste"><td style="width: 150px;" class="dane">ID:</td><td class="dane"><input type="text" name="id" size="50" maxlength="50" value="<?php echo $_POST['id']; ?>" /></td></tr>
				<tr class="parzyste"><td class="dane">Imię:</td><td class="dane"><input type="text" name="imie" size="50" maxlength="50" value="<?php echo $_POST['imie']; ?>" /></td></tr>
				<tr class="nieparzyste"><td class="dane">Nazwisko:</td><td class="dane"><input type="text" name="nazwisko" size="50" maxlength="50" value="<?php echo $_POST['nazwisko']; ?>" /></td></tr>
				<tr class="parzyste"><td class="dane">Miejscowość:</td><td class="dane"><input type="text" name="miejscowosc" size="50" maxlength="50" value="<?php echo $_POST['miejscowosc']; ?>" /></td></tr>
				<tr class="nieparzyste"><td class="dane">E-mail:</td><td class="dane"><input type="text" name="email" size="50" maxlength="50" value="<?php echo $_POST['email']; ?>" /></td></tr>
				<tr class="parzyste"><td class="dane">Telefon:</td><td class="dane"><input type="text" name="telefon" size="50" maxlength="50" value="<?php echo $_POST['telefon']; ?>" /></td></tr>
				<tr class="nieparzyste"><td class="dane">NIP:</td><td class="dane"><input type="text" name="NIP" size="50" maxlength="50" value="<?php echo $_POST['NIP']; ?>" /></td></tr>
				<tr class="parzyste"><td></td><td class="dane"><input type="submit" value="Szukaj" /></td></tr>
			</table>
		</form>
			<?php
		}
		/**
		 * Wyświetlenie potwierdzenia usunięcia pracownika
		*/
		public function wyswietlUsuwaniePracownika()
		{
			?>
	<div id="tytul">Usuń pracownika</div>
	<div id="komunikat_blad">
		<h1>Jesteś pewien, że chcesz usunąć pracownika z bazy?</h1><font style="color: #6e1c1c;">Operacja ta jest nieodwracalna.</font><br /><br />
		<form action="?akcja=usunPracownik" method="post">
			<input type="hidden" name="usun_id" value="<?php echo $_GET["id"];?>" />
			<input type="submit" value="Usuń pracownika" />
		</form>
	</div>
			<?php
		}	
		
		public function wyswietlKomunikat($komunikat)
		{
			echo '<div id="komunikat">' . $komunikat . '</div>';
		}		
		
		public function wyswietlKomunikatBledu($komunikat)
		{
			echo '<div id="komunikat_blad">' . $komunikat . '</div>';
		}
		
		public function wyswietlKoniec()
		{
?>
		</div>
		<div id="stopka">
			<font style="color: #46ac35;">Autorzy:</font> Dawid Myślak, Marek Knura, Adrian Kupis, Mateusz Przybyłek
		</div>
	</div>
</body>
</html>
<?php
		}
	}
?>