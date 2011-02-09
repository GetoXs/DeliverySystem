<?php

/**
 * @author Mateusz Przybyłek
 * @copyright 2011
 */

	// Sesja
	session_start();

	// Dołączenie plików
  require_once('config.php');
  $config = new config();
	require_once('klasy/class.bazadanych.php');
	require_once($config->tpl_folder.$config->tpl_name.'.admin.php');
	
	// Utworzenie i deserializacja obiektów
	$bazaDanych = new BazaDanych('localhost', $config->mysql_user, $config->mysql_pass, $config->mysql_db);
	$szablon = new Szablon($config->tpl_folder);
	
	// Rozpoczęcie generowania kodu strony
	$szablon->wyswietlPoczatek();
	
	try
	{
		// Próba połączenia z bazą danych
		$bazaDanych->nawiazPolaczenie();
		
    
    
		// Próba zalogowania
	  if (isset($_POST['login']) && isset($_POST['haslo']) && !isset($_SESSION['autoryzacja_admin']))
		{
			$login = $_POST['login'];
			$haslo = sha1($_POST['haslo']);
			
			$wynik = $bazaDanych->zalogujPracownika($login, $haslo);
			if ($wynik)
			{
				$_SESSION['autoryzacja_admin'] = true;
        $_SESSION['id_p'] = $wynik['id_p'];
        $_SESSION['typ'] = $wynik['typ'];
				$szablon->wyswietlKomunikat('Zalogowano poprawnie.');
			}
			else
			{
				$szablon->wyswietlKomunikatBledu('Nieprawidłowy login lub hasło.');
			}
		}
    
    
		// Sesja istnieje
		if (isset($_SESSION['autoryzacja_admin']) && isset($_SESSION['typ']))
		{
			//Tworzenie pracownika
			Pracownik *$pracownik = NULL;
			// domyslna akcja
      if(!isset($_GET['akcja']))
        $_GET['akcja'] = '';
        
      // Wyloguj się
			if ($_GET['akcja'] == 'wyloguj')
			{
				session_destroy();
				
				$szablon->wyswietlKomunikat('Wylogowano poprawnie.');
				$szablon->wyswietlFormularzLogowania();
			}else
      {  
				if($_SESSION['typ']==0)
    		{
          require_once('klasy/class.kierownik.php');
          
          $pracownik = new Kierownik($_SESSION['id_p'], $szablon, $bazaDanych);
          $pracownik->showToolBar($_GET['akcja']);
          $pracownik->controllerAction($_GET['akcja']);
        }else if($_SESSION['typ']==1)
    		{
          require_once('klasy/class.kurier.php');
          
          $pracownik = new Kurier($_SESSION['id_p'], $szablon, $bazaDanych);
          $pracownik->showToolBar($_GET['akcja']);
          $pracownik->controllerAction($_GET['akcja']);
        }
      }
		}
		else
			$szablon->wyswietlFormularzLogowania();
		
		$bazaDanych->zamknijPolaczenie();
	}
	catch (Exception $e)
	{
		$szablon->wyswietlKomunikatBledu($e->getMessage());
	}
	
	$szablon->wyswietlKoniec();
	
?>