<?php


	/* 	_________________________
	
		autor: Dawid Myślak
		data: 2011-02-02
		
		klasa Szablon
		_________________________
	*/

	class Szablon
	{
		public function wyswietlPoczatek()
		{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="pl" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<title>Spedycja</title>
</head>
<body>
	<div id="strona">
		<div id="logo">
			<img src="obrazki/logo.png" alt="Logo" />
			<h1>Spedycja</h1> PANEL KLIENTA
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
		
		public function wyswietlPanelKlienta()
		{
?>
<div id="nawigacja">
	<div id="menu_glowne">
		Witaj, <font style="color: #485fb5;"><?php echo $_SESSION['klient']->imie; ?></font>!
		<ul>
			<li><a href="?akcja=podglad_danych">&#187; Podgląd danych osobowych</a></li>
			<li><a href="?akcja=edytuj_dane">&#187; Edytuj dane osobowe</a></li>
			<li><a href="?akcja=usun_konto">&#187; Usuń konto</a></li>
		</ul>
	</div>
	<div id="menu_akcje">
		<h1>Panel klienta</h1>
		<ul>
			<li><a href="?akcja=przeglad_przesylek">Przegląd przesyłek</a></li>
			<li><a href="?akcja=utworz_przesylke">Utwórz przesyłkę</a></li>
			<li><a href="?akcja=wyloguj">Wyloguj się</a></li>
		</ul>
	</div>			
</div>
<?php
		}
		
		public function wyswietlPrzegladPrzesylek(&$wynik)
		{
			echo '<div id="tytul">Przegląd przesyłek</div>';
			echo '<table>';
			echo '<tr class="naglowek">';
			echo '<td>#</td>';
			echo '<td class="dane">Imię</td>';
			echo '<td class="dane">Nazwisko</td>';
			echo '<td>Data nadania</td>';
			echo '<td>Data dostarczenia</td>';
			echo '<td>Status</td>';
			echo '<td>Cena</td>';
			echo '<td>Kod</td>';
			echo '<td>Szczegóły</td>';
			echo '</tr>';
			
			$licznik = 1;
			foreach ($wynik as $wiersz)
			{
				if ($licznik % 2)
					$styl = 'nieparzyste';
				else
					$styl = 'parzyste';
				
				echo '<tr class="' . $styl . '">';
				echo '<td>' . $licznik . '</td>';
				echo '<td class="dane">' . $wiersz['imie'] . '</td>';
				echo '<td class="dane">' . $wiersz['nazwisko'] . '</td>';
				if ($wiersz['data_nadania'] == '0000-00-00')
					echo '<td>-</td>';
				else
					echo '<td>' . $wiersz['data_nadania'] . '</td>';
				if ($wiersz['data_dostarczenia'] == '0000-00-00')
					echo '<td>-</td>';
				else
					echo '<td>' . $wiersz['data_dostarczenia'] . '</td>';
				echo '<td>';
				switch ($wiersz['status'])
				{
					case 0: echo 'Oczekuje'; break;
					case 1: echo 'W realizacji'; break;
					case 2: echo 'Dostarczona'; break;
				}
				echo '</td>';
				if ($wiersz['cena'] == 0)
					echo '<td>-</td>';
				else
					echo '<td>' . number_format($wiersz['cena'], 2) . ' zł</td>';
				echo '<td>-</td>';
				echo '<td><a href="?akcja=szczegoly_przesylki&id=' . $wiersz['id_kp'] . '">Podgląd</a></td>';
				echo '</tr>';
				
				$licznik++;
			}
			echo '</table>';
		}
		
		public function wyswietlTworzeniePrzesylki()
		{
			echo '<form action="?akcja=utworz_przesylke" method="post">';
			echo '<div id="tytul">Utwórz przesyłkę</div>';
			echo '<table style="padding: 1px; border: 3px solid #cbd7fe;">';
			echo '<tr class="naglowek"><td style="width: 150px;" class="dane">Dane odbiorcy</td><td></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Imię:</td><td class="dane"><input type="text" name="imie" size="50" maxlength="50" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Nazwisko:</td><td class="dane"><input type="text" name="nazwisko" size="50" maxlength="50" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Adres:</td><td class="dane"><input type="text" name="adres" size="50" maxlength="50" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Kod pocztowy:</td><td class="dane"><input type="text" name="kod_pocztowy" size="50" maxlength="50" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Miejscowość:</td><td class="dane"><input type="text" name="miejscowosc" size="50" maxlength="50" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Telefon:</td><td class="dane"><input type="text" name="telefon" size="50" maxlength="50" /></td></tr>';
			echo '<tr class="naglowek"><td style="border-top: 1px solid #ffffff;" class="dane">Przesyłka</td><td style="border-top: 1px solid #ffffff;"></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Rodzaj:</td><td class="dane"><select name="rodzaj"><option value="0">Płatność z góry</option><option value="1">Płatność przy odbiorze</option></select></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Taryfa:</td><td class="dane"><select name="priorytet"><option value="0">Standard (12 zł)</option><option value="1">Bezpieczenie i szybko (17 zł)</option><option value="2">Ekspres (30 zł)</option></select></td></tr>';
			echo '<tr class="parzyste"><td class="dane"><input type="submit" value="Utwórz przesyłkę" /></td><td class="dane">Upewnij się, że wszystkie pola zostały wypełnione poprawnie.</td></tr>';
			echo '</table>';
			echo '</form>';
		}
		
		public function wyswietlSzczegolyPrzesylki(&$wynik)
		{
			echo '<div id="tytul">Szczegóły przesyłki</div>';
			echo '<table style="padding: 1px; border: 3px solid #cbd7fe;">';
			echo '<tr class="naglowek"><td style="width: 150px;" class="dane">Dane odbiorcy</td><td></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Imię:</td><td class="dane">' . $wynik[0]['imie'] . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Nazwisko:</td><td class="dane">' . $wynik[0]['nazwisko'] . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Adres:</td><td class="dane">' . $wynik[0]['adres'] . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Kod pocztowy:</td><td class="dane">' . $wynik[0]['kod_pocztowy'] . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Miejscowość:</td><td class="dane">' . $wynik[0]['miejscowosc'] . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Telefon:</td><td class="dane">' . $wynik[0]['telefon'] . '</td></tr>';
			echo '<tr class="naglowek"><td style="border-top: 1px solid #ffffff;" class="dane">Przesyłka</td><td style="border-top: 1px solid #ffffff;"></td></tr>';
			echo '<tr class="parzyste"><td class="dane">ID:</td><td class="dane">' . $wynik[0]['id_kp'] . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Rodzaj:</td><td class="dane">';
			switch ($wynik[0]['rodzaj'])
			{
				case 0: echo 'Płatność z góry'; break;
				case 1: echo 'Płatność przy odbiorze'; break;
			}
			echo '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Taryfa:</td><td class="dane">';
			switch ($wynik[0]['priorytet'])
			{
				case 0: echo 'Standard'; break;
				case 1: echo 'Bezpieczenie i szybko'; break;
				case 2: echo 'Ekspres'; break;
			}
			echo '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Cena:</td><td class="dane">';
			if ($wynik[0]['cena'] == 0)
				echo '-';
			else
				echo number_format($wynik[0]['cena'], 2) . ' zł';
			echo '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Status:</td><td class="dane">';
			switch ($wynik[0]['status'])
			{
				case 0: echo 'Oczekuje'; break;
				case 1: echo 'W realizacji'; break;
				case 2: echo 'Dostarczona'; break;
			}
			echo '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Data nadania:</td><td class="dane">';
			if ($wynik[0]['data_nadania'] == '0000-00-00')
				echo '-';
			else
				echo $wynik[0]['data_nadania'];
			echo '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Data dostarczenia:</td><td class="dane">';
			if ($wynik[0]['data_dostarczenia'] == '0000-00-00')
				echo '-';
			else
				echo $wynik[0]['data_dostarczenia'];
			echo '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Kod:</td><td class="dane">-</td></tr>';
			echo '</table>';
		}
		
		public function wyswietlPodgladDanych()
		{
			echo '<div id="tytul">Podgląd danych osobowych</div>';
			echo '<table style="padding: 1px; border: 3px solid #cbd7fe;">';
			echo '<tr class="naglowek"><td style="width: 150px;" class="dane">ID:</td><td class="dane">' . $_SESSION['klient']->id_k . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Imię:</td><td class="dane">' . $_SESSION['klient']->imie . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Nazwisko:</td><td class="dane">' . $_SESSION['klient']->nazwisko . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Adres:</td><td class="dane">' . $_SESSION['klient']->adres . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Kod pocztowy:</td><td class="dane">' . $_SESSION['klient']->kod_pocztowy . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Miejscowość:</td><td class="dane">' . $_SESSION['klient']->miejscowosc . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">E-mail:</td><td class="dane">' . $_SESSION['klient']->email . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Telefon:</td><td class="dane">' . $_SESSION['klient']->telefon . '</td></tr>';
			echo '</table>';
		}
		
		public function wyswietlEdycjeDanych()
		{
			echo '<form action="?akcja=edytuj_dane" method="post">';
			echo '<div id="tytul">Edytuj dane osobowe</div>';
			echo '<table style="padding: 1px; border: 3px solid #cbd7fe;">';
			echo '<tr class="naglowek"><td style="width: 150px;" class="dane">ID:</td><td class="dane">' . $_SESSION['klient']->id_k . '</td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Imię:</td><td class="dane"><input type="text" name="imie" size="50" maxlength="50" value="' . $_SESSION['klient']->imie . '" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Nazwisko:</td><td class="dane"><input type="text" name="nazwisko" size="50" maxlength="50" value="' . $_SESSION['klient']->nazwisko . '" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Adres:</td><td class="dane"><input type="text" name="adres" size="50" maxlength="50" value="' . $_SESSION['klient']->adres . '" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Kod pocztowy:</td><td class="dane"><input type="text" name="kod_pocztowy" size="50" maxlength="50" value="' . $_SESSION['klient']->kod_pocztowy . '" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Miejscowość:</td><td class="dane"><input type="text" name="miejscowosc" size="50" maxlength="50" value="' . $_SESSION['klient']->miejscowosc . '" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">E-mail:</td><td class="dane"><input type="text" name="email" size="50" maxlength="50" value="' . $_SESSION['klient']->email . '" /></td></tr>';
			echo '<tr class="nieparzyste"><td class="dane">Telefon:</td><td class="dane"><input type="text" name="telefon" size="50" maxlength="50" value="' . $_SESSION['klient']->telefon . '" /></td></tr>';
			echo '<tr class="parzyste"><td class="dane"><input type="submit" value="Zapisz zmiany" /></td><td class="dane">Upewnij się, że wszystkie pola zostały wypełnione poprawnie.</td></tr>';
			echo '</table>';
			echo '</form>';
		}
		
		public function wyswietlUsuwanieKonta()
		{
			echo '<div id="tytul">Usuń konto</div>';
			echo '<div id="komunikat_blad">';
			echo '<h1>Jesteś pewien, że chcesz usunąć konto?</h1><font style="color: #6e1c1c;">Operacja ta jest nieodwracalna.</font><br /><br />';
			echo '<form action="?akcja=usun_konto" method="post">';
			echo '<input type="hidden" name="usun_konto" />';
			echo '<input type="submit" value="Usuń konto" />';
			echo '</form>';
			echo '</div>';
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