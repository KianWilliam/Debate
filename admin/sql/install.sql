CREATE TABLE IF NOT EXISTS `#__debate` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `catid` int(10) NOT NULL DEFAULT '0',
  `threadid` int(10) NOT NULL DEFAULT '0',
  `userid` int(10) NOT NULL DEFAULT '0',
  `fonderid` int(10) NOT NULL DEFAULT '0',
  `fondermessage` varchar(10) NOT NULL DEFAULT 'No',
  `fonderidea` varchar(10) NOT NULL DEFAULT 'No',
  `message` BLOB,
  `attachment` text,
  `created` text ,
  `title` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',  
  `visual` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__debate_thread_id` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `threadid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__debate_user_ip_address` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) NOT NULL DEFAULT '0',  
  `ipaddress` varchar(255) NOT NULL DEFAULT '',
   `datetime` text NOT NULL,  
  `ordering` int(11) NOT NULL default '0',  
   
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__debate_subscriptions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) NOT NULL DEFAULT '0',
    `threadid` int(10) NOT NULL DEFAULT '0',
   `datetime` text NOT NULL ,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__debate_forum_rules` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rules` text NOT NULL default '',
   `visual` text NOT NULL,

  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__debate_fonders` (
  `id` int(10) unsigned NOT NULL auto_increment,
    `name` varchar(121) NOT NULL default '',
    `email` varchar(121) NOT NULL default '',
    `profession` varchar(121) NOT NULL default '',
    `avatar` text NOT NULL ,
	`jointime` text NOT NULL,
    `userid` int(10) NOT NULL DEFAULT '0', 
	 `published` tinyint(1) NOT NULL default '0',
     `ordering` int(11) NOT NULL default '0',  
	`visual` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__debate_config` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `forumtitle` varchar(255) NOT NULL DEFAULT '',
  `forumemail` varchar(255) NOT NULL DEFAULT '',
  `forumoffline` varchar(12) NOT NULL DEFAULT '',
  `publishrules` varchar(12) NOT NULL DEFAULT '',
  `viewfonderprofile` varchar(12) NOT NULL DEFAULT '',
  `offlinemessage` text NOT NULL,
  `showhistory` varchar(12) NOT NULL DEFAULT '',
  `shownewposts` varchar(12) NOT NULL DEFAULT '',
  `messagereporting` varchar(12) NOT NULL DEFAULT '',
  `showuserstatistics` varchar(12) NOT NULL DEFAULT '',
  `allowsubscriptions` varchar(12) NOT NULL DEFAULT '',
  `showusersonline` varchar(12) NOT NULL DEFAULT '',
  `showjoindate` varchar(12) NOT NULL DEFAULT '',
  `showlastvisitdate` varchar(12) NOT NULL DEFAULT '',

  `published` tinyint(1) NOT NULL default '0', 
   `recnumcat` int(3) NOT NULL DEFAULT '5', 
   `recnummess` int(3) NOT NULL DEFAULT '5', 
   
     `textcolor` varchar(12) NOT NULL DEFAULT '#000000',
     `titlecolor` varchar(12) NOT NULL DEFAULT '#000000',
	      `buttbakcolor` varchar(12) NOT NULL DEFAULT '#000000',
     `fontfamily` varchar(12) NOT NULL DEFAULT 'arial',
     `titlefontsize` varchar(12) NOT NULL DEFAULT '15px',
	      `textfontsize` varchar(12) NOT NULL DEFAULT '12px',
     `titlefontweight` varchar(12) NOT NULL DEFAULT 'bold',
	      `titlefontstyle` varchar(12) NOT NULL DEFAULT 'normal',
		   `textfontweight` varchar(12) NOT NULL DEFAULT 'normal',
	      `textfontstyle` varchar(12) NOT NULL DEFAULT 'normal',
 `framebordercolor` varchar(12) NOT NULL DEFAULT '#000000',
  `frameborderradius` varchar(12) NOT NULL DEFAULT '5px',   
  `visual` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__debate_deprive_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) NOT NULL DEFAULT '0', 
   `reason` text NOT NULL ,
	`deprivedate` text NOT NULL,
    `messageid` int(10) NOT NULL DEFAULT '0', 
	`fonderid` int(10) NOT NULL DEFAULT '0', 
     `ordering` int(11) NOT NULL default '0',  
	`visual` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__debate_badpost_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) NOT NULL DEFAULT '0', 
   `reason` text NOT NULL ,
	`baddate` text NOT NULL ,
    `messageid` int(10) NOT NULL DEFAULT '0', 
	`fonderid` int(10) NOT NULL DEFAULT '0', 
     `ordering` int(11) NOT NULL default '0',  
	`visual` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__debate_edit_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) NOT NULL DEFAULT '0', 
   `reason` text NOT NULL ,
	`editdate` text NOT NULL ,
    `messageid` int(10) NOT NULL DEFAULT '0', 
	`fonderid` int(10) NOT NULL DEFAULT '0', 
     `ordering` int(11) NOT NULL default '0',  
	`visual` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__debate_deprive_list` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) NOT NULL DEFAULT '0', 
   `reason` text NOT NULL ,
	`deprivedate` text NOT NULL ,
    `messageid` int(10) NOT NULL DEFAULT '0', 
	`fonderid` int(10) NOT NULL DEFAULT '0', 
     `ordering` int(11) NOT NULL default '0',  
	`visual` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__debate_view_times` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `threadid` int(10) NOT NULL DEFAULT '0', 
   `views` int(10) NOT NULL DEFAULT '0', 	
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;








