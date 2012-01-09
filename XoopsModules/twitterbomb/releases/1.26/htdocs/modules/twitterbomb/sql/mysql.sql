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
  PRIMARY KEY  (`baseid`),
  KEY `COMMON` (`cid`,`catid`,`base1`,`base2`,`base3`,`base4`,`base5`,`base6`,`base7`,`uid`,`created`)
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
  PRIMARY KEY  (`kid`),
  KEY `COMMON` (`cid`,`catid`,`base`,`keyword`(15),`uid`,`created`)
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
  PRIMARY KEY  (`sid`),
  KEY `COMMON` (`cid`,`catid`,`mode`,`pre`(15),`text`(15),`search`(15),`replace`(15),`strip`(15),`pregmatch`(15),`pregmatch_replace`(15),`uid`,`hits`,`rank`,`when`,`tweeted`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_log` (
  `lid` int(13) unsigned NOT NULL auto_increment,
  `provider` enum('bomb','scheduler','retweet') default 'bomb',
  `uid` int(13) unsigned default '0',
  `sid` int(13) unsigned default '0',
  `oid` int(13) unsigned default '0',
  `tid` int(13) unsigned default '0',
  `alias` varchar(64) default NULL,
  `tweet` varchar(140) default NULL,
  `url` varchar(500) default NULL,
  `date` int(13) unsigned default '0',
  `cid` int(13) unsigned default '0',
  `catid` int(13) unsigned default '0',
  `hits` int(13) unsigned default '0',
  `rank` int(13) unsigned default '0',
  `active` int(13) unsigned default '0',
  `tags` varchar(255) default NULL,
  `id` varchar(128) default NULL,
  `rid` int(13) unsigned default '0',
  `about_id` int(13) unsigned default '0',
  PRIMARY KEY  (`lid`),
  KEY `COMMON` (`provider`,`alias`,`tweet`(15),`url`(15),`date`,`cid`,`catid`,`hits`,`rank`,`active`,`tags`(25),`id`(15),`rid`,`about_id`),
  KEY `COMMON_INDEX` (`lid`,`provider`,`uid`,`sid`,`oid`,`tid`,`cid`,`catid`,`hits`,`rank`,`active`,`id`(15),`rid`)
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
  PRIMARY KEY  (`urlid`),
  KEY `COMMON` (`cid`,`catid`,`surl`(25),`name`(25),`uid`,`created`)
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
  PRIMARY KEY  (`tid`),
  KEY `COMMON` (`cid`,`oid`,`catid`,`screen_name`(15),`id`(12),`name`(25),`uid`,`indexed`,`followed`)
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
  PRIMARY KEY  (`catid`),
  KEY `COMMON` (`pcatdid`,`name`(15),`hits`,`uid`,`created`,`updated`,`active`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_campaign` (
  `cid` int(13) unsigned NOT NULL auto_increment,
  `catid` int(13) unsigned default NULL,
  `name` varchar(64) default NULL,
  `description` varchar(255) default NULL,
  `start` int(13) unsigned default '0',
  `end` int(13) unsigned default '0',
  `timed` tinyint(4) unsigned default '0',
  `hits` int(13) unsigned default '0',
  `uid` int(13) unsigned default '0',
  `created` int(13) unsigned default '0',
  `updated` int(13) unsigned default '0',
  `active` int(13) unsigned default '0',
  `type` enum('bomb','scheduler','retweet') default 'bomb',
  `cron` int(13) unsigned default '0',
  `rids` varchar(1000) default '',
  PRIMARY KEY  (`cid`),
  KEY `COMMON` (`catid`,`name`(15),`start`,`end`,`timed`,`hits`,`uid`,`created`)
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
  PRIMARY KEY  (`oid`),
  KEY `COMMON` (`cids`(25),`catids`(25),`mode`,`consumer_key`(15),`consumer_secret`(15),`oauth_token`(15),`oauth_token_secret`(15),`username`(15),`id`(15),`ip`(15),`netbios`(15),`uid`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_following` (
  `fid` int(20) unsigned NOT NULL auto_increment,
  `id` varchar(128) default NULL,
  `flid` varchar(128) default NULL,
  `followed` int(13) unsigned default '0',
  `created` int(13) unsigned default '0',
  `updated` int(13) unsigned default '0',
  `actioned` int(13) unsigned default '0',
  PRIMARY KEY  (`fid`),
  KEY `COMMON` (`id`(25),`flid`(25),`followed`),
  KEY `SECONDARY` (`id`(12),`flid`(12),`followed`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `twitterbomb_retweet` (
  `rid` int(20) unsigned NOT NULL auto_increment,
  `search` varchar(128) default NULL,
  `skip` varchar(128) default 'RT',
  `geocode` tinyint(1) unsigned default '0',
  `longitude` decimal(10,6) default '0.000000',
  `latitude` decimal(10,6) default '0.000000',
  `radius` int(13) unsigned default '0',
  `measurement` enum('mi','km') default 'km',
  `language` enum('aa','ab','af','am','ar','AS','ay','az','ba','be','bg','bh','bi','bn','bo','br','ca','co','cs','cy','da','de','dz','el','en','eo','es','et','eu','fa','fi','fj','fo','fr','fy','ga','gd','gl','gn','gu','ha','he','hi','hr','hu','hy','ia','id','ie','ik','IS','it','iu','ja','jw','ka','kk','kl','km','kn','ko','ks','ku','ky','la','LN','lo','lt','lv','mg','mi','mk','ml','mn','mo','mr','ms','mt','my','na','ne','nl','NO','oc','om','OR','pa','pl','ps','pt','qu','rm','rn','ro','ru','rw','sa','sd','sg','sh','si','sk','sl','sm','sn','so','sq','sr','ss','st','su','sv','sw','ta','te','tg','th','ti','tk','tl','tn','TO','tr','ts','tt','tw','ug','uk','ur','uz','vi','vo','wo','xh','yi','yo','za','zh','zu') default 'en',
  `type` enum('mixed','recent','popular') default 'mixed',
  `uid` int(13) unsigned default '0',
  `retweets` int(13) unsigned default '0',
  `searched` int(13) unsigned default '0',
  `created` int(13) unsigned default '0',
  `updated` int(13) unsigned default '0',
  `actioned` int(13) unsigned default '0',
  `retweeted` int(13) unsigned default '0',
  PRIMARY KEY  (`rid`),
  KEY `COMMON` (`search`(15),`skip`(15),`geocode`,`longitude`,`latitude`,`radius`,`measurement`,`language`,`type`,`uid`,`retweets`,`searched`,`created`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;