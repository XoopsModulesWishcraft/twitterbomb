CREATE TABLE `twitterbomb_base_matrix` (
  `baseid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0', 
  `catid` INT(13) UNSIGNED DEFAULT '0', 
  `base1` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT '',
  `base2` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT '',
  `base3` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT '',
  `base4` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT '',
  `base5` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT '',
  `base6` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT '',
  `base7` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT '',
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

CREATE TABLE `twitterbomb_scheduler` (
  `sid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0', 
  `catid` INT(13) UNSIGNED DEFAULT '0', 
  `mode` ENUM('direct','filtered','pregmatch','strip','pregmatchstrip','strippregmatch','filteredstrip','stripfiltered','filteredpregmatch','pregmatchfiltered','filteredpregmatchstrip','filteredstrippregmatch','pregmatchfilteredstrip','pregmatchstripfiltered','strippregmatchfiltered','stripfilteredpregmatch','mirc') DEFAULT 'direct',
  `pre` VARCHAR(35) DEFAULT NULL,
  `text` VARCHAR(500) DEFAULT NULL,
  `search` VARCHAR(1000) DEFAULT NULL,
  `replace` VARCHAR(1000) DEFAULT NULL,
  `strip` VARCHAR(1000) DEFAULT NULL,
  `pregmatch` VARCHAR(500) DEFAULT NULL,
  `pregmatch_replace` VARCHAR(500) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `hits` INT(13) UNSIGNED DEFAULT '0',
  `rank` INT(13) UNSIGNED DEFAULT '0',
  `when` INT(13) UNSIGNED DEFAULT '0', 
  `tweeted` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `actioned` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0', 
  PRIMARY KEY (`sid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_log` (
  `lid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider` ENUM('bomb', 'scheduler') DEFAULT 'bomb',
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `sid` INT(13) UNSIGNED DEFAULT '0',
  `oid` INT(13) UNSIGNED DEFAULT '0',
  `tid` INT(13) UNSIGNED DEFAULT '0',
  `alias` VARCHAR(64) DEFAULT NULL,
  `tweet` VARCHAR(140) DEFAULT NULL,
  `url` VARCHAR(500) DEFAULT NULL,
  `date` INT(13) UNSIGNED DEFAULT '0',
  `cid` INT(13) UNSIGNED DEFAULT '0',
  `catid` INT(13) UNSIGNED DEFAULT '0',
  `hits` INT(13) UNSIGNED DEFAULT '0',
  `rank` INT(13) UNSIGNED DEFAULT '0',
  `active` INT(13) UNSIGNED DEFAULT '0',
  `tags` VARCHAR(255) DEFAULT NULL, 
  `id` VARCHAR(128) DEFAULT NULL, 
  PRIMARY KEY (`lid`)
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
  `oid` INT(13) UNSIGNED DEFAULT '0',
  `catid` INT(13) UNSIGNED DEFAULT '0',
  `screen_name` VARCHAR(64) DEFAULT NULL,
  `id` VARCHAR(128) DEFAULT NULL,
  `avarta` VARCHAR(255) DEFAULT NULL,
  `name` VARCHAR(128) DEFAULT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `indexed` INT(13) UNSIGNED DEFAULT '0',
  `followed` INT(13) UNSIGNED DEFAULT '0',
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  `type` ENUM('bomb','scheduler') DEFAULT 'bomb',
  `tweeted` INT(13) UNSIGNED DEFAULT '0',
  `source_nick` VARCHAR(64) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_category` (
  `catid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pcatdid` INT(13) UNSIGNED DEFAULT '0', 
  `name` VARCHAR(128) DEFAULT NULL,
  `hits` INT(13) UNSIGNED DEFAULT '0', 
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0',   
  `active` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`catid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_campaign` (
  `cid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `catid` INT(13) UNSIGNED DEFAULT NULL,
  `name` VARCHAR(64) DEFAULT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `start` INT(13) UNSIGNED DEFAULT '0',
  `end` INT(13) UNSIGNED DEFAULT '0',
  `timed` TINYINT(4) UNSIGNED DEFAULT '0',
  `hits` INT(13) UNSIGNED DEFAULT '0',
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `active` INT(13) UNSIGNED DEFAULT '0',
  `type` ENUM('bomb','scheduler') DEFAULT 'bomb',
  PRIMARY KEY (`cid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_oauth` (
  `oid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cids` VARCHAR(1000) DEFAULT NULL, 
  `catids` VARCHAR(1000) DEFAULT NULL, 
  `mode` ENUM('valid','invalid','expired','disabled','other') DEFAULT NULL,
  `consumer_key` VARCHAR(255) DEFAULT NULL,
  `consumer_secret` VARCHAR(255) DEFAULT NULL,
  `oauth_token` VARCHAR(255) DEFAULT NULL,
  `oauth_token_secret` VARCHAR(255) DEFAULT NULL,
  `username` VARCHAR(64) DEFAULT NULL,
  `id` VARCHAR(255) DEFAULT '0',
  `ip` VARCHAR(64) DEFAULT NULL,
  `netbios` VARCHAR(255) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `actioned` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `tweeted` INT(13) UNSIGNED DEFAULT '0',  
  `friends` INT(13) UNSIGNED DEFAULT '0',
  `mentions` INT(13) UNSIGNED DEFAULT '0',
  `tweets` INT(13) UNSIGNED DEFAULT '0',  
  `calls` INT(13) UNSIGNED DEFAULT '0',
  `remaining_hits` INT(13) UNSIGNED DEFAULT '0',
  `hourly_limit` INT(13) UNSIGNED DEFAULT '0',
  `api_resets` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`oid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_following` (
  `fid` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id` VARCHAR(128) DEFAULT NULL,
  `flid` VARCHAR(128) DEFAULT NULL,
  `followed` INT(13) UNSIGNED DEFAULT '0',
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`fid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;