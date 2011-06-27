CREATE TABLE `twitterbomb_base_matrix` (
  `baseid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0', 
  `catid` INT(13) UNSIGNED DEFAULT '0', 
  `base1` ENUM('for','when','clause','then','over','under','their','there','') DEFAULT '',
  `base2` ENUM('for','when','clause','then','over','under','their','there','') DEFAULT '',
  `base3` ENUM('for','when','clause','then','over','under','their','there','') DEFAULT '',
  `base4` ENUM('for','when','clause','then','over','under','their','there','') DEFAULT '',
  `base5` ENUM('for','when','clause','then','over','under','their','there','') DEFAULT '',
  `base6` ENUM('for','when','clause','then','over','under','their','there','') DEFAULT '',
  `base7` ENUM('for','when','clause','then','over','under','their','there','') DEFAULT '',
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0', 
  PRIMARY KEY (`baseid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_keywords` (
  `kid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0', 
  `catid` INT(13) UNSIGNED DEFAULT '0', 
  `base` ENUM('for','when','clause','then','over','under','their','there') DEFAULT NULL,
  `keyword` VARCHAR(35) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `actioned` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0', 
  PRIMARY KEY (`kid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_urls` (
  `urlid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0', 
  `catid` INT(13) UNSIGNED DEFAULT '0',
  `surl` VARCHAR(255) DEFAULT NULL,
  `name` VARCHAR(64) DEFAULT NULL,
  `description` VARCHAR(255) DEFAULT NULL,  
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0',   
  PRIMARY KEY (`urlid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_usernames` (
  `tid` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0', 
  `catid` INT(13) UNSIGNED DEFAULT '0',
  `twitter_username` VARCHAR(64) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0',   
  PRIMARY KEY (`tid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_category` (
  `catid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pcatdid` INT(13) UNSIGNED DEFAULT '0', 
  `name` VARCHAR(128) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0',   
  PRIMARY KEY (`catid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_campaign` (
  `cid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) DEFAULT NULL,
  `description` VARCHAR(255) DEFAULT NULL,  
  `start` INT(13) UNSIGNED DEFAULT '0', 
  `end` INT(13) UNSIGNED DEFAULT '0',   
  `timed` TINYINT(4) UNSIGNED DEFAULT '0', 
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0',   
  PRIMARY KEY (`cid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;