CREATE TABLE IF NOT EXISTS `gmap_targeting_coordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `latitude` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;