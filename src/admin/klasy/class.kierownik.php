<?php

/**
 * @author Mateusz Przybyłek
 * @copyright 2011
 */
require_once('klasy/class.pracownik.php');

class Kierownik extends Pracownik
{
  public function controllerAction($action)
  {
    switch($action)
    {
      case "dodajPracownik": 
      	if(isset($_POST['imie']))
      	{
	      	if(!empty($_POST['imie'])&&!empty($_POST['nazwisko'])&&!empty($_POST['adres'])&&!empty($_POST['miejscowosc'])&&!empty($_POST['kod_pocztowy'])&&!empty($_POST['telefon'])&&!empty($_POST['email'])&&!empty($_POST['NIP'])&&!empty($_POST['stawka'])&&!empty($_POST['haslo'])&&!empty($_POST['login'])&&!empty($_POST['typ']))
	      	{
	      		if($_POST['typ']==1 || $_POST['typ']==2)
	      		{
	      			$_POST['login'] = $this->db->escapeString($_POST['login']);
	      			if(strlen($_POST['login'])>4 && strlen($_POST['haslo'])>4)
	      			{
			      		$_POST['stawka'] = floatval($_POST['stawka']);
			      		
			      		$haslo = sha1($_POST['haslo']);
			      		
			      		$_POST['imie'] = $this->db->escapeString($_POST['imie']);
			      		$_POST['nazwisko'] = $this->db->escapeString($_POST['nazwisko']);
			      		$_POST['adres'] = $this->db->escapeString($_POST['adres']);
			      		$_POST['miejscowosc'] = $this->db->escapeString($_POST['miejscowosc']);
			      		$_POST['kod_pocztowy'] = $this->db->escapeString($_POST['kod_pocztowy']);
			      		$_POST['telefon'] = $this->db->escapeString($_POST['telefon']);
			      		$_POST['email'] = $this->db->escapeString($_POST['email']);
			      		$_POST['NIP'] = $this->db->escapeString($_POST['NIP']);

								try
								{
									
									$this->db->wykonajWstawianie("INSERT INTO `pracownicy` 
								(`id_p`, `typ`, `imie`, `nazwisko`, `login`, `haslo`, `adres`, `kod_pocztowy`, `miejscowosc`, `email`, `telefon`, `NIP`, `stawka`) 
								VALUES (NULL,'".$_POST['typ']."', '".$_POST['imie']."', '".$_POST['nazwisko']."', '".$_POST['login']."', '$haslo', '".$_POST['adres']."', '".$_POST['kod_pocztowy']."', '".$_POST['miejscowosc']."', '".$_POST['email']."', '".$_POST['telefon']."', '".$_POST['NIP']."', '".$_POST['stawka']."')");
									$this->tpl->wyswietlKomunikat("Nowy pracownik pomyślnie został dodany do bazy");
									unset($_POST['typ'],$_POST['imie'],$_POST['nazwisko'],$_POST['login'],$_POST['haslo'],$_POST['kod_pocztowy'],$_POST['miejscowosc'],$_POST['email'],$_POST['telefon'],$_POST['NIP'],$_POST['stawka'],$_POST['adres']);
								}
								catch (Exception $e)
								{
									$this->tpl->wyswietlKomunikatBledu($e->getMessage());
								}
		      		}else
		      			$this->tpl->wyswietlKomunikatBledu("Login i hasło musi miec wiecej niż 4 znaki");
     				}else
   						$this->tpl->wyswietlKomunikatBledu("Nie możesz tworzyc pracownika rownego bądź wyższego szczeblem");
      		}else
						$this->tpl->wyswietlKomunikatBledu("Wypełnij wszystkie pola");
      		      		
     		}
      
      	$this->tpl->wyswietlTworzeniePracownika();
      	break;
      case "usunPracownik": 
      	if(!empty($_GET['id']))
      		$this->tpl->wyswietlUsuwaniePracownika();
     		//weryfikacja i usuwanie 
     		else if(!empty($_POST['usun_id']))
     		{
					try
					{
						$_POST['usun_id'] = intval($_POST['usun_id']);
						$wynik = $this->db->wykonajZapytanie("SELECT * FROM pracownicy WHERE id_p=".$_POST['usun_id']);
						//czy jest jakis pracownik
						if($wynik)
						{
							//sprawdzenie typu pracownika
							if($wynik[0]['typ']==1 || $wynik[0]['typ']==2)
							{
								$this->db->wykonajUsuniecie("DELETE FROM pracownicy WHERE id_p='".$_POST['usun_id']."'");
								
								$this->tpl->wyswietlKomunikat('Usunięto pracownika.');
							}else
								$this->tpl->wyswietlKomunikatBledu("Nie możesz usunąc pracownika rownego bądź wyższego szczeblem");
						}else
							$this->tpl->wyswietlKomunikatBledu("Nie ma takiego pracownika");
					}
					catch (Exception $e)
					{
						$this->tpl->wyswietlKomunikatBledu($e->getMessage());
					}
				}else	
					$this->tpl->wyswietlSzukajPracownika();
				break;
      case "edytujPracownik": 
      	if(isset($_POST['id_p']))
      		$id_p = intval($_POST['id_p']);
     		else if(isset($_GET['id_p']))
     			$id_p = intval($_GET['id_p']);
	      		
						
				if(isset($id_p) && !empty($id_p))
				{
					try
					{
						$wynik = $this->db->wykonajZapytanie("SELECT * FROM pracownicy WHERE id_p=".$id_p);
						//czy jest jakis pracownik
						if($wynik)
						{
							unset($wynik[0]["haslo"]);
							//sprawdzenie typu pracownika
							if($wynik[0]['typ']==1 || $wynik[0]['typ']==2)
							{
								if(isset($_POST['imie']))
								{
									if(!empty($_POST['imie'])&&!empty($_POST['nazwisko'])&&!empty($_POST['adres'])&&!empty($_POST['miejscowosc'])&&!empty($_POST['kod_pocztowy'])&&!empty($_POST['telefon'])&&!empty($_POST['email'])&&!empty($_POST['NIP'])&&!empty($_POST['stawka'])&&!empty($_POST['login'])&&!empty($_POST['typ']))
					      	{
					      		if($_POST['typ']==1 || $_POST['typ']==2)
					      		{
					      			$_POST['login'] = $this->db->escapeString($_POST['login']);
					      			if(strlen($_POST['login'])>4)
					      			{
							      		$_POST['stawka'] = floatval($_POST['stawka']);
							      		
							      		$_POST['imie'] = $this->db->escapeString($_POST['imie']);
							      		$_POST['nazwisko'] = $this->db->escapeString($_POST['nazwisko']);
							      		$_POST['adres'] = $this->db->escapeString($_POST['adres']);
							      		$_POST['miejscowosc'] = $this->db->escapeString($_POST['miejscowosc']);
							      		$_POST['kod_pocztowy'] = $this->db->escapeString($_POST['kod_pocztowy']);
							      		$_POST['telefon'] = $this->db->escapeString($_POST['telefon']);
							      		$_POST['email'] = $this->db->escapeString($_POST['email']);
							      		$_POST['NIP'] = $this->db->escapeString($_POST['NIP']);
							      		
							      		$pass="";
							      		if(!empty($_POST['haslo']))
							      			$pass="haslo='".sha1($haslo)."',";
						      			
						      			if(empty($pass) || (!empty($pass) && strlen($_POST['haslo'])>4))
						      			{
													try
													{
														$this->db->wykonajAktualizacje("UPDATE pracownicy
							  							SET typ='".$_POST['typ']."',
							  							imie='".$_POST['imie']."',
							  							nazwisko='".$_POST['nazwisko']."',
							  							login='".$_POST['login']."',
							  							".$pass."
							  							adres='".$_POST['adres']."',
							  							kod_pocztowy='".$_POST['kod_pocztowy']."',
							  							miejscowosc='".$_POST['miejscowosc']."',
							  							email='".$_POST['email']."',
							  							telefon='".$_POST['telefon']."',
							  							NIP='".$_POST['NIP']."',
							  							stawka='".$_POST['stawka']."'
															WHERE id_p='".$id_p."'");
															
														$this->tpl->wyswietlKomunikat("Nowy pracownik pomyślnie został wyedytowany");
														
														unset($_POST['typ'],$_POST['imie'],$_POST['nazwisko'],$_POST['login'],$_POST['haslo'],$_POST['kod_pocztowy'],$_POST['miejscowosc'],$_POST['email'],$_POST['telefon'],$_POST['NIP'],$_POST['stawka'],$_POST['adres']);
													}catch (Exception $e)
													{
														$error = $e->getMessage();
													}
												}else
													$error = "Hasło musi miec wiecej niż 4 znaki";
						      		}else
						      			$error = "Login musi miec wiecej niż 4 znaki";
				     				}else
				   						$error = "Nie możesz tworzyc pracownika rownego bądź wyższego szczeblem";
				      		}else
										$error = "Wypełnij wszystkie wymagane pola";
								}else
									$this->tpl->wyswietlEdycjePracownika($wynik);
								
								if(isset($error))
								{
									$this->tpl->wyswietlKomunikatBledu($error);
									$arr[0] = $_POST;
									$this->tpl->wyswietlEdycjePracownika($arr);
								}
							}else
								$this->tpl->wyswietlKomunikatBledu("Nie możesz usunąc pracownika rownego bądź wyższego szczeblem");
						}else
							$this->tpl->wyswietlKomunikatBledu("Nie ma takiego pracownika");
					}
					catch (Exception $e)
					{
						$this->tpl->wyswietlKomunikatBledu($e->getMessage());
					}
				}else	
					$this->tpl->wyswietlSzukajPracownika();
				break;
      case "pokazPracownik":
      	if(isset($_POST['id']))
      	{
	    		$query="";
	    		if(!empty($_POST['id']))
	    			$query .= " id_p='".$this->db->escapeString($_POST['id'])."'";
	    		if(!empty($_POST['imie']))
	    			$query .= " imie='".$this->db->escapeString($_POST['imie'])."'";
	    		if(!empty($_POST['nazwisko']))
	    			$query .= " nazwisko='".$this->db->escapeString($_POST['nazwisko'])."'";
	    		if(!empty($_POST['miejscowosc']))
	    			$query .= " miejscowosc='".$this->db->escapeString($_POST['miejscowosc'])."'";
	    		if(!empty($_POST['email']))
	    			$query .= " email='".$this->db->escapeString($_POST['email'])."'";
	    		if(!empty($_POST['telefon']))
	    			$query .= " telefon='".$this->db->escapeString($_POST['telefon'])."'";
	    		if(!empty($_POST['NIP']))
	    			$query .= " NIP='".$this->db->escapeString($_POST['NIP'])."'";
					if(!empty($query))
						$wynik = $this->db->wykonajZapytanie("SELECT * FROM pracownicy WHERE".$query);
			  	else
			  		$wynik = $this->db->wykonajZapytanie("SELECT * FROM pracownicy");
						
					if ($wynik)
						$this->tpl->wyswietlPracownikow($wynik);
					else
						$this->tpl->wyswietlKomunikatBledu('Nie ma takich pracownikow.');
     		}
     		$this->tpl->wyswietlSzukajPracownika();
     		break;
      default:
      	break;
    }
    
  }
  public function showToolBar()
  {
    $this->tpl->wyswietlPanel(array("pokazPracownik","dodajPracownik","usunPracownik","edytujPracownik","wyloguj"));    
  }
}

?>