--
-- scromega blog CMS
-- Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
--
-- Structure of database
--

CREATE TABLE `entries` (
  `id` int(11) unsigned not null auto_increment,
  `slug` varchar(255),
  `title` varchar(255),
  `content` longtext,
  `date` int(10) unsigned,
  `mini` enum('y','n') default 'n',
  `status` enum('v','r','h') default 'v',
  `comments` enum('y','n','c') default 'y',
  `trackback` enum('y','n') default 'y',
  primary key (`id`)
) character set utf8 collate utf8_unicode_ci;

CREATE TABLE `pages` (
  `id` int(11) unsigned not null auto_increment,
  `slug` varchar(255),
  `title` varchar(255),
  `content` longtext,
  `status` enum('v','r','h') default 'v',
  `comments` enum('y','n','c') default 'n',
  `trackback` enum('y','n') default 'n',
  primary key (`id`)
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
  `date` int(10) unsigned,
  `ip` varchar(100),
  `useragent` longtext,
  `status` enum('v','h','n') default 'n',
  primary key (`id`)
) character set utf8 collate utf8_unicode_ci;

CREATE TABLE `trackbacks` (
  `id` int(11) unsigned not null auto_increment,
  `parentid` int(11) unsigned,
  `parenttype` enum('e','p') default 'e',
  `title` varchar(255),
  `url` varchar(255),
  `blog_name` varchar(255),
  `expert` longtext,
  `date` int(11) unsigned,
  `approved` enum('y','n') default 'n',
  primary key (`id`)
) character set utf8 collate utf8_unicode_ci;
