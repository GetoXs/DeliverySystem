# Projekt Spedycja
Projekt na studia 2010/2011 r. Aplikacja do obsługi spedycji, bazująca na technologiach: PHP, MySQL, HTML

## Opis tematu

Klient zgłasza firmie kurierskiej zapotrzebowanie na przesyłkę towaru. Zgłoszenie może zostać złożone przez Internet lub osobiście. Gdy zgłoszenie jest przyjęte osobiście osoba odbierająca zgłoszenie (spedytor) sporządza kartę przewozową. W przypadku zgłoszenia przez Internet karta sporządzana jest automatycznie. Karta przewozowa jest przekazywana do działu transportowego firmy. Jeśli przesyłka nie została dostarczona osobiście spedytor na podstawie danych zawartych w karta przewozowym przydziela kuriera do odbioru przesyłki. Kryteriami przydziału kuriera do danej przesyłki jest m.in. lokalizacja geograficzna klienta. Kurier zgłasza się do klienta po odbiór przesyłki. Następnie przesyłka w zależności od położenia adresata, ląduje odpowiednio w jednym z 2-ech typów magazynów, bądź bezpośrednio do adresata. Jeśli przesyłka adresowana jest w obrębie lokalnego strefy obsługiwanej przez kuriera, przesyłka zostaje bezpośrednio mu przekazana, jeśli adres wskazuje położenie geograficzne w obrębie jednego województwa, przesyłka ląduje w głównym magazynie na dane województwo, a następnie jest przydzielania magazynowi lokalnemu i odpowiedniemu kurierowi w zależności od położenia geograficznego adresata, natomiast jeśli przesyłka kierowana jest poza województwo, przesyłka wpierw zostaje transportowana do magazynu głównego na dane województwo, a następnie zostaje przetransportowana do sortowni stamtąd po segregacji przesyłka zostaje przydzielona do odpowiedniego magazynu wojewódzkiego, lokalnego oraz dostarczona przez kuriera do adresata. Kurier przy dostarczaniu przesyłki adresatowi, wypełnia stosowną dokumentację, która jest następnie wprowadzana do systemu informatycznego. W trakcie całej procedury obsługi klient ma możliwość śledzenia statusu przesyłki drogą internetową.

Nadzór nad systemem informatycznym oraz wszelkimi pomyłkami sprawują pracownicy administracyjni. 

### Role w systemie

* Administrator – posiada pełen dostęp do systemu, mogą m.in. przeglądać, dodawać, usuwać, modyfikować zarówno przesyłki, klientów jak i kurierów
* Spedytor – posiada prawa wykonywania operacji na przesyłkach sporządzonych przez siebie
* Kurier – posiada możliwość edycji statusu przydzielonych pod siebie przesyłek.
* Klient – składa zamówienie, ma wgląd do statusu karty przewozowej

## Funkcjonalności

Funkcje systemu dla administratora systemu:
* generowanie raportów tygodniowych/miesięcznych/rocznych
* przeglądanie pracowników/klientów/przesyłek
* edycja cennika oraz wyznaczanie administratorów systemu (tylko główny administrator)
* dodawanie/usuwanie/edytowanie pracowników
* dodawanie/usuwanie/edytowanie klientów
* dodawanie/usuwanie/edytowanie przesyłek

Funkcje systemu dla spedytora:
* dodawanie/usuwanie/edytowanie przesyłek przez siebie stworzonych
* przydzielanie paczek kurierom

Funkcje systemu dla kuriera:
* dodawanie/usuwanie/edytowanie przesyłek przez siebie stworzonych
* przydzielanie paczek kurierom
* wgląd w status karty przewozowej
* składanie zamówienia
* przeglądanie historii spedycji własnych przesyłek
