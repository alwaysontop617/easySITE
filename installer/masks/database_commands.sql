CREATE TABLE `{dbprefix}mytable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT 'dude',
  `desc` text NOT NULL,
  PRIMARY KEY (`id`)
);


CREATE TABLE `{dbprefix}myusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `displayname` varchar(255) NOT NULL,
  `emailaddress` varchar(255) NOT NULL,
  `level` tinyint(2) NOT NULL,
  `hashkey` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `emailaddress` (`emailaddress`)
);