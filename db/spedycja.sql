-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 10 Lut 2011, 13:13
-- Wersja serwera: 5.0.81
-- Wersja PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Baza danych: `getox_spedycja`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `karty_przewozowe`
--

CREATE TABLE IF NOT EXISTS `karty_przewozowe` (
  `id_kp` int(11) NOT NULL auto_increment,
  `id_k` int(11) NOT NULL,
  `id_m` int(11) NOT NULL default '0',
  `id_p` int(11) NOT NULL default '0',
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `kod_pocztowy` varchar(50) NOT NULL,
  `miejscowosc` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `cena` float NOT NULL default '0',
  `priorytet` int(11) NOT NULL,
  `rodzaj` int(11) NOT NULL,
  `status` int(11) NOT NULL default '0',
  `data_nadania` date NOT NULL default '0000-00-00',
  `data_dostarczenia` date NOT NULL default '0000-00-00',
  `kod` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_kp`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Zrzut danych tabeli `karty_przewozowe`
--

INSERT INTO `karty_przewozowe` (`id_kp`, `id_k`, `id_m`, `id_p`, `imie`, `nazwisko`, `adres`, `kod_pocztowy`, `miejscowosc`, `telefon`, `cena`, `priorytet`, `rodzaj`, `status`, `data_nadania`, `data_dostarczenia`, `kod`) VALUES
(1, 4, 0, 0, 'Zdzisław', 'Pedałowicz', 'Konopowska 13/a', '23-113', 'Wały', '345-546-244', 14.5, 1, 1, 2, '2011-02-05', '2011-02-06', '391C42E4'),
(2, 4, 1, 7, 'Paweł', 'Gałach', 'Lolowa 13/a', '54-465', 'Polkowice', '245-251-157', 25, 2, 0, 1, '2011-02-12', '0000-00-00', 'D2C167A0'),
(3, 4, 1, 7, 'Łukasz', 'Wędkarz', 'Stolarska 1/a', '22-121', 'Knurów', '400-224-132', 0, 2, 1, 1, '2011-02-08', '0000-00-00', '78DA8CDE'),
(33, 4, 0, 7, 'Roman', 'Pawłowicz', 'Konopowa 4b/13', '11-109', 'Muszyna', '456-283-138', 0, 2, 1, 0, '0000-00-00', '0000-00-00', 'BE9D2AD7'),
(35, 8, 0, 0, 'Halina', 'Kiepska', 'Czekolada 4a/1', '12-345', 'Polonia', '213-567-123', 0, 0, 1, 0, '0000-00-00', '0000-00-00', '979A9510'),
(34, 4, 0, 7, 'Andrzej', 'Kępa', 'Leśna 4c/1', '90-343', 'Dębica', '466-573-123', 0, 1, 0, 0, '0000-00-00', '0000-00-00', 'F6A2B11F');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `klienci`
--

CREATE TABLE IF NOT EXISTS `klienci` (
  `id_k` int(11) NOT NULL auto_increment,
  `login` varchar(50) NOT NULL,
  `haslo` varchar(50) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `kod_pocztowy` varchar(50) NOT NULL,
  `miejscowosc` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_k`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_k`, `login`, `haslo`, `imie`, `nazwisko`, `adres`, `kod_pocztowy`, `miejscowosc`, `email`, `telefon`) VALUES
(6, 'mateusz', 'c74780982fca069d559e5c78b4677476dc80851c', 'Mateusz', 'Przybyłek', 'Akademicka 69/ą', '00-000', 'Pedały Rowerowe', 'boski_mateusz@sexi-chlopcy.pl', '500-500-500'),
(4, 'dawid', 'bca4c1486c8153b43d0030277dc1b346a5686c0a', 'Dawid', 'Myślak', 'Akademicka 69/z', '66-666', 'Knurów', 'dawid@buziaczek.pl', '666-666-666'),
(5, 'marek', 'e54ec4e8b56ff7382fb135e028860ad99be4caf9', 'Marek', 'Knura', 'Akademicka 69/f', '66-666', 'Jejkowice', 'marek@buziaczek.pl', '696-969-696'),
(7, 'adrian', 'a1b909ec1cc11cce40c28d3640eab600e582f833', 'Adrian', 'Kulis', 'Akademicka 69/ł', '22-222', 'Kosowo', 'adrianek@buziaczek.pl', '544-344-213'),
(8, 'tester', 'ab4d8d2a5f480a137067da17100271cd176607a1', 'Tester', 'Testerowski', 'Testowa 1', '00-000', 'Testowo', 'test@test.pl', '000-000-000');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `magazyny`
--

CREATE TABLE IF NOT EXISTS `magazyny` (
  `id_m` int(11) NOT NULL auto_increment,
  `adres` varchar(50) NOT NULL,
  `kod_pocztowy` varchar(50) NOT NULL,
  `miejscowosc` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_m`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `magazyny`
--

INSERT INTO `magazyny` (`id_m`, `adres`, `kod_pocztowy`, `miejscowosc`, `telefon`) VALUES
(1, 'Szefowska 12', '21-313', 'Łódź', '345-122-453');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `pracownicy`
--

CREATE TABLE IF NOT EXISTS `pracownicy` (
  `id_p` int(11) NOT NULL auto_increment,
  `typ` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `haslo` varchar(50) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `kod_pocztowy` varchar(50) NOT NULL,
  `miejscowosc` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `NIP` varchar(50) NOT NULL,
  `stawka` float NOT NULL,
  PRIMARY KEY  (`id_p`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`id_p`, `typ`, `imie`, `nazwisko`, `login`, `haslo`, `adres`, `kod_pocztowy`, `miejscowosc`, `email`, `telefon`, `NIP`, `stawka`) VALUES
(1, 0, 'Mateusz', 'Przybyłek', 'mateusz', 'c74780982fca069d559e5c78b4677476dc80851c', 'ul. ZWM', '44-100', 'Gliwice', 'niunia@buziaczek.pl', '23253225', '334-234234-324', 5500),
(7, 1, 'Dawid', 'Myślak', 'dawid', 'bca4c1486c8153b43d0030277dc1b346a5686c0a', 'ul. knurowka', '44-110', 'Knurów', 'dejvo@dejvo.com', '324543445', '324-324-3432', 2500),
(8, 1, 'Marek', 'Knura', 'marek', 'e54ec4e8b56ff7382fb135e028860ad99be4caf9', 'ul. gliwicka', '44-200', 'Rybnik', 'Marek@master.pl', '342324234', '223-3-432-324', 4212);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `przesylki`
--

CREATE TABLE IF NOT EXISTS `przesylki` (
  `id_pr` int(11) NOT NULL auto_increment,
  `id_kp` int(11) NOT NULL,
  `masa` float NOT NULL,
  `wymiary` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_pr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `przesylki`
--

