--
-- Veritabanı: `sosyal`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `arkadas`
--
USE sosyal;
CREATE TABLE IF NOT EXISTS `arkadas` (
  `uye_id` int(10) NOT NULL,
  `arkadas_id` int(10) NOT NULL,
  `onay` int(1) DEFAULT '0',
  PRIMARY KEY (`uye_id`,`arkadas_id`),
  KEY `FK_arkadas_1` (`uye_id`),
  KEY `FK_arkadas_2` (`arkadas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `arkadas`
--

INSERT INTO `arkadas` (`uye_id`, `arkadas_id`, `onay`) VALUES
(1, 2, 1),
(1, 3, 1),
(1, 8, 0),
(2, 1, 1),
(2, 3, 1),
(2, 8, 1),
(3, 1, 1),
(3, 2, 1),
(8, 2, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gunce`
--

CREATE TABLE IF NOT EXISTS `gunce` (
  `gunce_id` int(11) NOT NULL AUTO_INCREMENT,
  `yazi` text NOT NULL,
  `tarih` varchar(30) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `mesaj_id` int(11) NOT NULL,
  PRIMARY KEY (`gunce_id`),
  KEY `uye_id` (`uye_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Tablo döküm verisi `gunce`
--

INSERT INTO `gunce` (`gunce_id`, `yazi`, `tarih`, `uye_id`, `mesaj_id`) VALUES
(1, 'Birinci yazım', '2012-06-22T19:08:24+03:00', 1, 1),
(2, 'Bende ilk yazımı yazayım', '2012-06-22T19:08:24+03:00', 2, 2),
(3, 'Ben ceren yazdim', '2012-06-22T19:08:24+03:00', 3, 3),
(4, '<a href=''http://youtu.be/xnc7dUEuQ8U'' target=''_blank''>http://youtu.be/xnc7dUEuQ8U</a> <br /><iframe width="300" height="200""344" src="http://www.youtube.com/embed/xnc7dUEuQ8U?fs=1&feature=oembed" frameborder="0" allowfullscreen></iframe><br/>', '2012-06-23T13:52:38+03:00', 2, 2),
(5, '<a href=''http://youtu.be/0XibQZmI0LI'' target=''_blank''>http://youtu.be/0XibQZmI0LI</a> <br /><iframe width="300" height="200""344" src="http://www.youtube.com/embed/0XibQZmI0LI?fs=1&feature=oembed" frameborder="0" allowfullscreen></iframe><br/>', '2012-06-23T14:14:21+03:00', 2, 1),
(6, 'test', '2012-06-26T17:47:16+03:00', 2, 1),
(7, '<a href=''http://youtu.be/UJtB55MaoD0'' target=''_blank''>http://youtu.be/UJtB55MaoD0</a> <br /><iframe width="300" height="200""270" src="http://www.youtube.com/embed/UJtB55MaoD0?fs=1&feature=oembed" frameborder="0" allowfullscreen></iframe><br/> dinleyin bakalım :)', '2012-08-27T14:20:36+03:00', 8, 8);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uye`
--

CREATE TABLE IF NOT EXISTS `uye` (
  `uye_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(255) NOT NULL,
  `sifre` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `resim` varchar(255) NOT NULL DEFAULT '0.jpg',
  `kayit_tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(30) NOT NULL,
  PRIMARY KEY (`uye_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Tablo döküm verisi `uye`
--

INSERT INTO `uye` (`uye_id`, `ad`, `sifre`, `email`, `resim`, `kayit_tarih`, `ip`) VALUES
(1, 'Riza ÇELİK', '81dc9bdb52d04dc20036dbd8313ed055', 'rizacelik@gmail.com', '1.jpg', '2012-06-18 21:34:24', '127.0.0.1'),
(2, 'Zeynep ÇELİK', '81dc9bdb52d04dc20036dbd8313ed055', 'zeynep@msn.com', '2.jpg', '2012-06-18 21:34:24', '127.0.0.11'),
(3, 'Ceren GEZER', '81dc9bdb52d04dc20036dbd8313ed055', 'ceren@live.com', '3.jpg', '2012-06-18 21:34:24', '127.0.0.12'),
(8, 'Mihriban Erdem', '81dc9bdb52d04dc20036dbd8313ed055', 'merdem@gmail.com', '1345937530.jpg', '2012-08-26 02:28:15', '127.0.0.1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorum`
--

CREATE TABLE IF NOT EXISTS `yorum` (
  `yorum_id` int(11) NOT NULL AUTO_INCREMENT,
  `yorum` text NOT NULL,
  `gunce_id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `tarih` varchar(30) NOT NULL,
  PRIMARY KEY (`yorum_id`),
  KEY `gunce_id` (`gunce_id`),
  KEY `uye_id` (`uye_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Tablo döküm verisi `yorum`
--

INSERT INTO `yorum` (`yorum_id`, `yorum`, `gunce_id`, `uye_id`, `tarih`) VALUES
(1, 'Zeynepciğim ne güzel :)', 2, 3, '2012-06-18 21:47:47'),
(2, 'Zeynep yazmışsın yine...', 2, 1, '2012-06-18 21:47:47'),
(3, 'Minik tavşanım benim :)', 3, 3, '2012-08-26T19:39:24+03:00'),
(5, 'selam zeynep abla', 4, 8, '2012-08-27T02:22:44+03:00'),
(6, '<a href=''http://www.5min.com/Video/How-to-Create-a-Balloon-Sword-and-a-Flying-Mouse-516994648'' target=''_blank''>http://www.5min.com/Video/How-to-Create-a-Balloon-Sword-and-a-Flying-Mouse-516994648</a> <br /><![CDATA[<div style=''text-align:center''><iframe width="300" height="200"''401'' frameborder=''0'' webkitAllowFullScreen mozallowfullscreen allowFullScreen src=''http://embed.5min.com/PlayerSeed/?playList=516994648&autoStart=true''></iframe><br/><a href=''http://www.5min.com/Video/How-to-Create-a-Balloon-Sword-and-a-Flying-Mouse-516994648'' style=''font-family: Verdana;font-size: 10px;'' target=''_blank''>How to Create a Balloon Sword and a Flying Mouse</a></div>]]><br/>', 3, 3, '2012-08-27T16:11:57+03:00');

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `arkadas`
--
ALTER TABLE `arkadas`
  ADD CONSTRAINT `FK_arkadas_1` FOREIGN KEY (`uye_id`) REFERENCES `uye` (`uye_id`),
  ADD CONSTRAINT `FK_arkadas_2` FOREIGN KEY (`arkadas_id`) REFERENCES `uye` (`uye_id`);

--
-- Tablo kısıtlamaları `gunce`
--
ALTER TABLE `gunce`
  ADD CONSTRAINT `gunce_ibfk_1` FOREIGN KEY (`uye_id`) REFERENCES `uye` (`uye_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `yorum`
--
ALTER TABLE `yorum`
  ADD CONSTRAINT `yorum_ibfk_1` FOREIGN KEY (`uye_id`) REFERENCES `uye` (`uye_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yorum_ibfk_2` FOREIGN KEY (`gunce_id`) REFERENCES `gunce` (`gunce_id`) ON DELETE CASCADE ON UPDATE CASCADE;
