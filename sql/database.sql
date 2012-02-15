--
-- Structure of database
--

CREATE TABLE `entries` (
  `id` int(11) unsigned not null auto_increment,
  `slug` varchar(255),
  `title` varchar(255),
  `content` longtext,
  `date` int(11) unsigned,
  `mini` enum('y','n') default 'n',
  `status` enum('v','d','h') default 'v',
  `comments` enum('y','n','c') default 'y',
  `trackbacks` enum('y','n') default 'y',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) character set utf8 collate utf8_unicode_ci;

CREATE TABLE `pages` (
  `id` int(11) unsigned not null auto_increment,
  `slug` varchar(255),
  `title` varchar(255),
  `content` longtext,
  `status` enum('v','d','h') default 'v',
  `comments` enum('y','n','c') default 'n',
  `trackbacks` enum('y','n') default 'n',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) character set utf8 collate utf8_unicode_ci;

CREATE TABLE `comments` (
  `id` int(11) unsigned not null auto_increment,
  `parentid` int(11) unsigned,
  `parenttype` enum('e','p') default 'e',
  `order` int(11) unsigned,
  `nick` varchar(255),
  `email` varchar(50),
  `web` varchar(255),
  `content` longtext,
  `date` int(11) unsigned,
  `ip` varchar(100),
  `useragent` longtext,
  `status` enum('v','h','n') default 'n',
  `meta_value` longtext,
  PRIMARY KEY (`id`),
  KEY `parentid` (`parentid`)
) character set utf8 collate utf8_unicode_ci;

CREATE TABLE `trackbacks` (
  `id` int(11) unsigned not null auto_increment,
  `parentid` int(11) unsigned,
  `parenttype` enum('e','p') default 'e',
  `title` varchar(255),
  `url` varchar(255),
  `blog_name` varchar(255),
  `excerpt` longtext,
  `date` int(11) unsigned,
  `approved` enum('y','n') default 'n',
  PRIMARY KEY (`id`),
  KEY `parentid` (`parentid`)
) character set utf8 collate utf8_unicode_ci;
