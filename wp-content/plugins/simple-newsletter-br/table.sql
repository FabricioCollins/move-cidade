CREATE TABLE IF NOT EXISTS `simplenewsletter_subscriptions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(50) DEFAULT NULL,
	`email` varchar(100) NOT NULL DEFAULT '',
	`hash` varchar(32) NOT NULL DEFAULT '',
	`confirmed` int(1) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `UEmail` (`email`),
	KEY `IEmail` (`email`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;