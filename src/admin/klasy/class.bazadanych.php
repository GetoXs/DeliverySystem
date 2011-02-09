<?php

	/* 	_________________________
	
		autor: Dawid Myślak
		data: 2011-02-02
		
		klasa BazaDanych
		_________________________
	*/

	class BazaDanych
	{
		private $bazaDanych;
		private $host;
		private $login;
		private $haslo;
		private $uzytkownik;
		
		public function __construct($host, $login, $haslo, $uzytkownik)
		{
			$this->host = $host;
			$this->login = $login;
			$this->haslo = $haslo;
			$this->uzytkownik = $uzytkownik;
		}
		
		public function nawiazPolaczenie()
		{
			@$this->bazaDanych = new mysqli($this->host, $this->login, $this->haslo, $this->uzytkownik);
			if ($this->bazaDanych->connect_errno)
				throw new Exception('Nie można nawiązać połączenia z bazą danych.');
			$this->bazaDanych->query("SET NAMES 'utf8'");
		}
		public function escapeString($s)
		{
			return $this->bazaDanych->real_escape_string($s);
		}
		public function zalogujKlienta($login, $haslo)
		{
			$wynik = $this->bazaDanych->query("SELECT * FROM klienci
			WHERE login='$login' AND haslo='$haslo'");
			if ($wynik)
			{
				if ($wynik->num_rows)
					return $wynik->fetch_array();
			}
			return false;
		}
    public function zalogujPracownika($login, $haslo)
		{
			$wynik = $this->bazaDanych->query("SELECT * FROM pracownicy
			WHERE login='$login' AND haslo='$haslo'");
			if ($wynik)
			{
				if ($wynik->num_rows)
					return $wynik->fetch_array();
			}
			return false;
		}
		
		public function wykonajZapytanie($zapytanie)
		{
			$wynik = $this->bazaDanych->query($zapytanie);
			if ($wynik)
			{
				if ($wynik->num_rows)
				{
					while ($wiersz = $wynik->fetch_array())
						$tablicaWynikow[] = $wiersz;
					return $tablicaWynikow;
				}
				else
					return false;
			}
			else
				throw new Exception('Niepoprawne zapytanie do bazy danych.');
		}

		public function wykonajWstawianie($zapytanie)
		{
			$wynik = $this->bazaDanych->query($zapytanie);
			if (!$wynik)
				throw new Exception('Niepoprawne zapytanie do bazy danych.');
		}
		
		public function wykonajAktualizacje($zapytanie)
		{
			$wynik = $this->bazaDanych->query($zapytanie);
			if (!$wynik)
				throw new Exception('Niepoprawne zapytanie do bazy danych.');
		}
		
		public function wykonajUsuniecie($zapytanie)
		{
			$wynik = $this->bazaDanych->query($zapytanie);
			if (!$wynik)
				throw new Exception('Niepoprawne zapytanie do bazy danych.');
		}
		
		public function zamknijPolaczenie()
		{
			$this->bazaDanych->close();
		}
	}
?>