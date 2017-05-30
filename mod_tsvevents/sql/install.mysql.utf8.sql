--
-- Table structure for table `tsv_events`
--

CREATE TABLE IF NOT EXISTS `tsv_events` (
`id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `zeit` time DEFAULT NULL,
  `titel` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `inhalt_kurz` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `inhalt_lang` text COLLATE utf8_unicode_ci NOT NULL,
  `abteilung` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
