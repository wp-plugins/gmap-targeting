CREATE TABLE IF NOT EXISTS `gmap_targeting_map_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `info` text COLLATE utf8_unicode_ci NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `zoom` int(2) NOT NULL DEFAULT '4',
  `type` enum('SATELLITE','HYBRID','TERRAIN','ROADMAP') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ROADMAP',
  `position` enum('left','right','none') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `info` (`info`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;