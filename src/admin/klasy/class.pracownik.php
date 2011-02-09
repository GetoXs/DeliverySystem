<?php

/**
 * @author Mateusz Przybyłek
 * @copyright 2011
 */
require_once('klasy/class.bazadanych.php');

abstract class Pracownik
{
  protected $tpl;
  protected $db;
  
	protected $id_p;
	
	public function __construct($id_p, &$tpl, &$db)
  //, $imie, $nazwisko, $adres, $kod_pocztowy, $miejscowosc, $email, $telefon, $login, $haslo, $NIP,  $stawka)
	{
    $this->tpl = $tpl;
    $this->db = $db;
    
		$this->id_p = $id_p;
	}
  abstract public function controllerAction($action);
  
  abstract public function showToolBar();
  
  public static $typArray = array(0=>"Kierownik", 1=>"Kurier", 2=>"Spedytor");
 }

?>