<?php

/**
 * @author Mateusz Przybyłek
 * @copyright 2011
 */

class Kurier extends Pracownik
{
  public function controllerAction($action)
  {
  	switch($action)
    {
      case "szczegolyKarta":
      	if(isset($_GET['id_kp']))
      	{
					try{
						$wynik = $this->db->wykonajZapytanie("SELECT * FROM karty_przewozowe WHERE id_p='".intval($_SESSION["id_p"])."' AND id_kp='".intval($_GET["id_kp"])."' ");
						if($wynik)
						{
							$nadawca = $this->db->wykonajZapytanie("SELECT * FROM klienci WHERE id_k='".intval($wynik[0]["id_k"])."'");
							$magazyn = $this->db->wykonajZapytanie("SELECT * FROM magazyny WHERE id_m='".intval($wynik[0]["id_m"])."'");
							$this->tpl->wyswietlSzczegolyKarty($wynik, $nadawca, $magazyn);
						}else
							$this->tpl->wyswietlKomunikatBledu("Nie istnieje taka karta, bądź nie masz uprawnień aby ją przeglądac");
					}
					catch (Exception $e)
					{
						$this->tpl->wyswietlKomunikatBledu($e->getMessage());
					}
				}
				break; 
      case "edytujKarta": 
      	if(isset($_POST['id_kp']))
      		$id_kp = intval($_POST['id_kp']);
				else if(isset($_GET['id_kp']))
     			$id_kp = intval($_GET['id_kp']);
     			
				if(isset($id_kp))
				{
					try
					{
						$wynik = $this->db->wykonajZapytanie("SELECT * FROM karty_przewozowe WHERE id_p='".intval($_SESSION["id_p"])."' AND id_kp='".$id_kp."' ");
						
						if($wynik)
						{
							$magazyn = $this->db->wykonajZapytanie("SELECT * FROM magazyny");
							if(isset($_POST['id_m']))
							{
								if(isset($_POST['id_m'])&&!empty($_POST['kod_pocztowy']))
				      	{
					      		$_POST['id_m'] = intval($_POST['id_m']);
					      		
					      		$_POST['data_nadania'] = $this->db->escapeString($_POST['data_nadania']);
					      		if(empty($_POST['data_nadania']))
					      			$_POST['data_nadania'] = "NULL";
					      		$_POST['data_dostarczenia'] = $this->db->escapeString($_POST['data_dostarczenia']);
					      		if(empty($_POST['data_dostarczenia']))
					      			$_POST['data_dostarczenia'] = "NULL";
					      		$_POST['kod_pocztowy'] = $this->db->escapeString($_POST['kod_pocztowy']);
						      		
										try
										{
											$this->db->wykonajAktualizacje("UPDATE karty_przewozowe
				  							SET id_m='".$_POST['id_m']."',
				  							data_nadania='".$_POST['data_nadania']."',
				  							data_dostarczenia='".$_POST['data_dostarczenia']."',
				  							kod_pocztowy='".$_POST['kod_pocztowy']."'
												WHERE id_kp='".$id_kp."'");
												
											$this->tpl->wyswietlKomunikat("Karta została pomyślnie wyedytowana");
											
											unset($_POST['id_m'],$_POST['data_nadania'],$_POST['data_dostarczenia'],$_POST['kod_pocztowy']);
										}catch (Exception $e)
										{
											$error = $e->getMessage();
										}
			      		}else
									$error = "Wypełnij wszystkie wymagane pola";
								if(isset($error))
								{
									$this->tpl->wyswietlKomunikatBledu($error);
									$arr[0] = $_POST;
									$this->tpl->wyswietlEdycjeKarty($arr, $magazyn);
								}
							}else
								$this->tpl->wyswietlEdycjeKarty($wynik, $magazyn);
								
							
						}else
							$this->tpl->wyswietlKomunikatBledu("Nie ma takiej karty, bądź nie masz do niej uprawnień");
					}
					catch (Exception $e)
					{
						$this->tpl->wyswietlKomunikatBledu($e->getMessage());
					}
				}else	
				{
					try{
						$wynik = $this->db->wykonajZapytanie("SELECT * FROM karty_przewozowe WHERE id_p=".intval($_SESSION["id_p"])." ORDER BY id_kp DESC");
						//czy jest jakis pracownik
						if($wynik)
						{
							$this->tpl->wyswietlKarty($wynik);
						}else
							$this->tpl->wyswietlKomunikatBledu("Nie ma przesyłek");
					}
					catch (Exception $e)
					{
						$this->tpl->wyswietlKomunikatBledu($e->getMessage());
					}
				}
				break;
			default:
					try{
						$wynik = $this->db->wykonajZapytanie("SELECT * FROM karty_przewozowe WHERE id_p=".intval($_SESSION["id_p"])." ORDER BY id_kp DESC");
						//czy jest jakis pracownik
						if($wynik)
						{
							$this->tpl->wyswietlKarty($wynik);
						}else
							$this->tpl->wyswietlKomunikatBledu("Nie ma przesyłek");
					}
					catch (Exception $e)
					{
						$this->tpl->wyswietlKomunikatBledu($e->getMessage());
					}
				break;			
		}
  }	
  public function showToolBar()
  {
    $this->tpl->wyswietlPanel(array("przegladajKarta", "edytujKarta","wyloguj"));    
  }
	
}


?>