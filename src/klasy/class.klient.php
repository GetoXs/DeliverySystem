<?php

	/* 	_________________________
	
		autor: Dawid Myślak
		data: 2011-02-04
		
		klasa Klient
		_________________________
	*/

	class Klient
	{
		private $id_k;
		private $imie;
		private $nazwisko;
		private $adres;
		private $kod_pocztowy;
		private $miejscowosc;
		private $email;
		private $telefon;
		
		public function __construct($id_k, $imie, $nazwisko, $adres, $kod_pocztowy, $miejscowosc, $email, $telefon)
		{
			$this->id_k = $id_k;
			$this->imie = $imie;
			$this->nazwisko = $nazwisko;
			$this->adres = $adres;
			$this->kod_pocztowy = $kod_pocztowy;
			$this->miejscowosc = $miejscowosc;
			$this->email = $email;
			$this->telefon = $telefon;
		}
		
		public function __get($zmienna)
		{
			return $this->$zmienna;
		}
		
		public function __set($zmienna, $wartosc)
		{
			$this->$zmienna = $wartosc;
		}
	}
?>