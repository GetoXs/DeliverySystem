<?php
	// Sesja
	session_start();

	// Dołączenie plików
	require_once('klasy/class.bazadanych.php');
	require_once('klasy/class.szablon.php');
	require_once('klasy/class.klient.php');
	
	// Utworzenie i deserializacja obiektów
	$bazaDanych = new BazaDanych('localhost', 'spedycja', 'spedycja', 'spedycja');
	$szablon = new Szablon();
	if (isset($_SESSION['klient'])) $_SESSION['klient'] = unserialize($_SESSION['klient']);
	
	// Rozpoczęcie generowania kodu strony
	$szablon->wyswietlPoczatek();
	
	try
	{
		// Próba połączenia z bazą danych
		$bazaDanych->nawiazPolaczenie();
		
		// Sesja istnieje
		if (isset($_SESSION['autoryzacja']))
		{
			// Przegląd przesyłek
			if (!isset($_GET['akcja']) || $_GET['akcja'] == 'przeglad_przesylek')
			{
				try
				{
					$szablon->wyswietlPanelKlienta();
					
					$id_k = $_SESSION['klient']->id_k;
					$wynik = $bazaDanych->wykonajZapytanie("SELECT * FROM karty_przewozowe WHERE id_k='$id_k'");
					
					if ($wynik)
						$szablon->wyswietlPrzegladPrzesylek($wynik);
					else
						$szablon->wyswietlKomunikatBledu('Nie utworzono jeszcze przesyłek.');
				}
				catch (Exception $e)
				{
					$szablon->wyswietlKomunikatBledu($e->getMessage());
				}
			}
			// Utwórz przesyłkę
			else if ($_GET['akcja'] == 'utworz_przesylke')
			{
				$komunikat = 0;
				
				if (isset($_POST['imie']) &&
					isset($_POST['nazwisko']) &&
					isset($_POST['adres']) &&
					isset($_POST['kod_pocztowy']) &&
					isset($_POST['miejscowosc']) &&
					isset($_POST['telefon']) &&
					isset($_POST['rodzaj']) &&
					isset($_POST['priorytet']))
				{
					if (!empty($_POST['imie']) &&
						!empty($_POST['nazwisko']) &&
						!empty($_POST['adres']) &&
						!empty($_POST['kod_pocztowy']) &&
						!empty($_POST['miejscowosc']) &&
						!empty($_POST['telefon']))
					{
						try
						{
							$id_k = $_SESSION['klient']->id_k;
							$imie = $_POST['imie'];
							$nazwisko = $_POST['nazwisko'];
							$adres = $_POST['adres'];
							$kod_pocztowy = $_POST['kod_pocztowy'];
							$miejscowosc = $_POST['miejscowosc'];
							$telefon = $_POST['telefon'];
							$rodzaj = $_POST['rodzaj'];
							$priorytet = $_POST['priorytet'];
							
							$bazaDanych->wykonajWstawianie("INSERT INTO karty_przewozowe
							(id_k, imie, nazwisko, adres, kod_pocztowy, miejscowosc, telefon, rodzaj, priorytet)
							VALUES ('$id_k', '$imie', '$nazwisko', '$adres', '$kod_pocztowy', '$miejscowosc', '$telefon', '$rodzaj', '$priorytet')");
							
							$bazaDanych->generujKod();
							
							$komunikat = 1;
						}
						catch (Exception $e)
						{
							$szablon->wyswietlKomunikatBledu($e->getMessage());
						}
					}
					else
						$komunikat = 2;
				}
				
				$szablon->wyswietlPanelKlienta();
				
				if ($komunikat == 1)
					$szablon->wyswietlKomunikat('Poprawnie utworzono przesyłkę.');
				else if ($komunikat == 2)
				{
					$szablon->wyswietlKomunikatBledu('Nie wypełniono wszystkich pól.');
					$szablon->wyswietlTworzeniePrzesylki();
				}
				else
					$szablon->wyswietlTworzeniePrzesylki();
			}
			// Wyloguj się
			else if ($_GET['akcja'] == 'wyloguj')
			{
				session_destroy();
				
				$szablon->wyswietlStroneGlowna();
				$szablon->wyswietlKomunikat('Wylogowano poprawnie.');
			}
			// Szczegóły przesyłki
			else if ($_GET['akcja'] == 'szczegoly_przesylki')
			{
				if (!empty($_GET['id']))
				{
					try
					{
						$szablon->wyswietlPanelKlienta();
						
						$id_kp = $_GET['id'];
						$id_k = $_SESSION['klient']->id_k;
						$wynik = $bazaDanych->wykonajZapytanie("SELECT * FROM karty_przewozowe WHERE id_kp='$id_kp' AND id_k='$id_k'");
						
						if ($wynik)
							$szablon->wyswietlSzczegolyPrzesylki($wynik);
						else
							$szablon->wyswietlKomunikatBledu('Nie można wyświetlić strony.');
					}
					catch (Exception $e)
					{
						$szablon->wyswietlKomunikatBledu($e->getMessage());
					}
				}
				else
				{
					$szablon->wyswietlPanelKlienta();
					$szablon->wyswietlKomunikatBledu('Nie można wyświetlić strony.');
				}
			}
			// Podgląd danych osobowych
			else if ($_GET['akcja'] == 'podglad_danych')
			{
				$szablon->wyswietlPanelKlienta();
				$szablon->wyswietlPodgladDanych();
			}
			// Edytuj dane osobowe
			else if ($_GET['akcja'] == 'edytuj_dane')
			{
				$komunikat = 0;
				
				if (isset($_POST['imie']) &&
					isset($_POST['nazwisko']) &&
					isset($_POST['adres']) &&
					isset($_POST['kod_pocztowy']) &&
					isset($_POST['miejscowosc']) &&
					isset($_POST['email']) &&
					isset($_POST['telefon']))
				{
					if (!empty($_POST['imie']) &&
						!empty($_POST['nazwisko']) &&
						!empty($_POST['adres']) &&
						!empty($_POST['kod_pocztowy']) &&
						!empty($_POST['miejscowosc']) &&
						!empty($_POST['email']) &&
						!empty($_POST['telefon']))
					{
						try
						{
							$id_k = $_SESSION['klient']->id_k;
							$imie = $_POST['imie'];
							$nazwisko = $_POST['nazwisko'];
							$adres = $_POST['adres'];
							$kod_pocztowy = $_POST['kod_pocztowy'];
							$miejscowosc = $_POST['miejscowosc'];
							$email = $_POST['email'];
							$telefon = $_POST['telefon'];
							
							$bazaDanych->wykonajAktualizacje("UPDATE klienci
							SET imie='$imie',
							nazwisko='$nazwisko',
							adres='$adres',
							kod_pocztowy='$kod_pocztowy',
							miejscowosc='$miejscowosc',
							email='$email',
							telefon='$telefon'
							WHERE id_k='$id_k'");
							
							$_SESSION['klient']->imie = $imie;
							$_SESSION['klient']->nazwisko = $nazwisko;
							$_SESSION['klient']->adres = $adres;
							$_SESSION['klient']->kod_pocztowy = $kod_pocztowy;
							$_SESSION['klient']->miejscowosc = $miejscowosc;
							$_SESSION['klient']->email = $email;
							$_SESSION['klient']->telefon = $telefon;
							
							$komunikat = 1;
						}
						catch (Exception $e)
						{
							$szablon->wyswietlKomunikatBledu($e->getMessage());
						}
					}
					else
						$komunikat = 2;
				}
				
				$szablon->wyswietlPanelKlienta();
				
				if ($komunikat == 1)
					$szablon->wyswietlKomunikat('Poprawnie zaktualizowano dane.');
				else if ($komunikat == 2)
					$szablon->wyswietlKomunikatBledu('Nie wypełniono wszystkich pól.');
				
				$szablon->wyswietlEdycjeDanych();
			}
			// Usuń konto
			else if ($_GET['akcja'] == 'usun_konto')
			{
				if (isset($_POST['usun_konto']))
				{
					try
					{
						$id_k = $_SESSION['klient']->id_k;
						
						$bazaDanych->wykonajUsuniecie("DELETE FROM klienci WHERE id_k='$id_k'");
						
						session_destroy();
						
						$szablon->wyswietlStroneGlowna();
						$szablon->wyswietlKomunikat('Usunięto konto.');
					}
					catch (Exception $e)
					{
						$szablon->wyswietlKomunikatBledu($e->getMessage());
					}				
				}
				else
				{
					$szablon->wyswietlPanelKlienta();
					$szablon->wyswietlUsuwanieKonta();
				}
			}
			else
			{
				$szablon->wyswietlPanelKlienta();
				$szablon->wyswietlKomunikatBledu('Nie można wyświetlić strony.');
			}
		}
		// Strona główna
		else if (!isset($_GET['akcja']))
		{
			$szablon->wyswietlStroneGlowna();
		}
		// Próba zalogowania
		else if ($_GET['akcja'] == 'zaloguj')
		{
			if (isset($_POST['login']) && isset($_POST['haslo']))
			{
				$login = $_POST['login'];
				$haslo = sha1($_POST['haslo']);
				
				$wynik = $bazaDanych->zalogujKlienta($login, $haslo);
				if ($wynik)
				{
					$_SESSION['autoryzacja'] = true;
					$_SESSION['klient'] = new Klient($wynik['id_k'], $wynik['imie'], $wynik['nazwisko'], $wynik['adres'], $wynik['kod_pocztowy'], $wynik['miejscowosc'], $wynik['email'], $wynik['telefon']);
					$szablon->wyswietlPanelKlienta();
					$szablon->wyswietlKomunikat('Zalogowano poprawnie.');
				}
				else
				{
					$szablon->wyswietlStroneGlowna();
					$szablon->wyswietlKomunikatBledu('Nieprawidłowy login lub hasło.');
				}
			}
			else
				$szablon->wyswietlStroneGlowna();
		}
		// Rejestracja
		else if ($_GET['akcja'] == 'rejestracja')
		{
			$komunikat = 0;
			
			if (isset($_POST['login']) &&
				isset($_POST['haslo']) &&
				isset($_POST['imie']) &&
				isset($_POST['nazwisko']) &&
				isset($_POST['adres']) &&
				isset($_POST['kod_pocztowy']) &&
				isset($_POST['miejscowosc']) &&
				isset($_POST['email']) &&
				isset($_POST['telefon']))
			{
				if (!empty($_POST['login']) &&
					!empty($_POST['haslo']) &&
					!empty($_POST['imie']) &&
					!empty($_POST['nazwisko']) &&
					!empty($_POST['adres']) &&
					!empty($_POST['kod_pocztowy']) &&
					!empty($_POST['miejscowosc']) &&
					!empty($_POST['email']) &&
					!empty($_POST['telefon']))
				{
					$login = $_POST['login'];
					$wynik = $bazaDanych->sprawdzKlienta($login);
					
					if ($wynik)
					{
						try
						{
							$haslo = sha1($_POST['haslo']);
							$imie = $_POST['imie'];
							$nazwisko = $_POST['nazwisko'];
							$adres = $_POST['adres'];
							$kod_pocztowy = $_POST['kod_pocztowy'];
							$miejscowosc = $_POST['miejscowosc'];
							$email = $_POST['email'];
							$telefon = $_POST['telefon'];
							
							$bazaDanych->wykonajWstawianie("INSERT INTO klienci
							(login, haslo, imie, nazwisko, adres, kod_pocztowy, miejscowosc, email, telefon)
							VALUES ('$login', '$haslo', '$imie', '$nazwisko', '$adres', '$kod_pocztowy', '$miejscowosc', '$email', '$telefon')");
							
							$komunikat = 1;
						}
						catch (Exception $e)
						{
							$szablon->wyswietlKomunikatBledu($e->getMessage());
						}
					}
					else
						$komunikat = 2;
				}
				else
					$komunikat = 3;
			}
			
			$szablon->wyswietlStroneGlowna();
			
			if ($komunikat == 1)
				$szablon->wyswietlKomunikat('Poprawnie zarejestrowano nowego użytkownika, możliwe jest teraz zalogowanie się.');
			else if ($komunikat == 2)
			{
				$szablon->wyswietlKomunikatBledu('Wybrany login jest juz zajęty.');
				$szablon->wyswietlRejestracje();
			}
			else if ($komunikat == 3)
			{
				$szablon->wyswietlKomunikatBledu('Nie wypełniono wszystkich pól.');
				$szablon->wyswietlRejestracje();
			}
			else
				$szablon->wyswietlRejestracje();
		}
		// Próba lokalizacji przesyłki
		else if ($_GET['akcja'] == 'lokalizacja_przesylki')
		{
			if (isset($_POST['kod']))
			{
				$kod = $_POST['kod'];
				
				$wynik = $bazaDanych->sprawdzLokalizacje($kod);
				if ($wynik)
				{
					$szablon->wyswietlStroneGlowna();
					$szablon->wyswietlLokalizacjePrzesylki($wynik);
				}
				else
				{
					$szablon->wyswietlStroneGlowna();
					$szablon->wyswietlKomunikatBledu('Nieprawidłowy kod przesyłki.');
				}
			}
			else
				$szablon->wyswietlStroneGlowna();
		}
		else
		{
			$szablon->wyswietlStroneGlowna();
			$szablon->wyswietlKomunikatBledu('Nie można wyświetlić strony.');
		}
		
		$bazaDanych->zamknijPolaczenie();
	}
	catch (Exception $e)
	{
		$szablon->wyswietlKomunikatBledu($e->getMessage());
	}
	
	$szablon->wyswietlKoniec();
	
	// Serializacja obiektów
	if (isset($_SESSION['klient'])) $_SESSION['klient'] = serialize($_SESSION['klient']);
?>