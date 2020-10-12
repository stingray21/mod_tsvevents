--
-- Table structure for table `hb_sponsor`
--

CREATE TABLE IF NOT EXISTS `hb_sponsor` (
  `sponsorID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `freigabe` tinyint(1) DEFAULT NULL,
  `logo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bemerkung` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `homepage` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresse` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stadt` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefon` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobil` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sponsorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;