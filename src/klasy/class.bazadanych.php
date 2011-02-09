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
		
		public function sprawdzKlienta($login)
		{
			$wynik = $this->bazaDanych->query("SELECT * FROM klienci
			WHERE login='$login'");
			if ($wynik)
			{
				if ($wynik->num_rows)
					return false;
			}
			return true;
		}
		
		public function sprawdzLokalizacje($kod)
		{
			$wynik = $this->bazaDanych->query("SELECT * FROM karty_przewozowe kp
			LEFT OUTER JOIN magazyny m ON kp.id_m=m.id_m
			WHERE kod='$kod'");
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
		
		public function generujKod()
		{
			$wynik = $this->bazaDanych->query("SELECT MAX(id_kp) FROM karty_przewozowe");
			$wynik = $wynik->fetch_array();
			$id_kp = $wynik[0];
			$sha1 = sha1($id_kp);
			$kod = '';
			
			for ($i = 0; $i < 8; $i++)
				$kod .= $sha1[$i * 5];
			$kod = strtoupper($kod);
			
			$this->bazaDanych->query("UPDATE karty_przewozowe
			SET kod='$kod'
			WHERE id_kp='$id_kp'");
		}
		
		public function zamknijPolaczenie()
		{
			$this->bazaDanych->close();
		}
	}
?>