CREATE TABLE IF NOT EXISTS `#__ajaxquiz_answer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `qid` int(11) unsigned NOT NULL,
  `title` mediumtext NOT NULL,
  `right_answer` tinyint(1) NOT NULL,
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `jos_ajaxquiz_question`
--


CREATE TABLE IF NOT EXISTS `#__ajaxquiz_question` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) unsigned NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(4) NOT NULL,
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL,
  `ordering` int(11) NOT NULL,
  `access` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



--
-- Table structure for table `jos_ajaxquiz_catgory`
--

CREATE TABLE IF NOT EXISTS `#__ajaxquiz_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `timer` tinyint(1) NOT NULL,
  `duration` time NOT NULL,
  `attempt` int(11) NOT NULL DEFAULT '0',
  `numques` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL,
  `ordering` int(11) NOT NULL,
  `access` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


--
-- Table structure for table `jos_ajaxquiz_result`
--

CREATE TABLE IF NOT EXISTS `#__ajaxquiz_result` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
  `userid` int(11) unsigned NOT NULL,	
  `catid` int(11) unsigned NOT NULL,
  `catname` varchar(255) NOT NULL,    
  `name` varchar(255) NOT NULL,    
  `email` varchar(255) NOT NULL,    
  `summery` varchar(255) NOT NULL,    
  `score` int(11) unsigned NOT NULL,    
  `result` longtext NOT NULL,
  `totaltime` text NOT NULL,
  `remaintime` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table structure for table `jos_ajaxquiz_template`
--

CREATE TABLE IF NOT EXISTS `#__ajaxquiz_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,      
  `assignuser` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `home` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `#__ajaxquiz_template` (
`id`, `assignuser`, `title`, `description`, `home`, `ordering`
) VALUES( 
5, 'User', 'Theme 1', '<p>Hello {name},</p>\r\n<p>your score is {score}.</p>\r\n<p>{resultdata}</p>', 1, 0
),(
6, 'Administrator', 'Theme 2', '<p>hello Admin,</p>\r\n<p>User {name} attempt quiz and his score is {score}.</p>\r\n<p>Here all description -</p>\r\n<p>{resultdata}</p>\r\n<p> </p>', 1, 1);