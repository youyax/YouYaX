
CREATE TABLE IF NOT EXISTS `{prefix}admin` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}big_block`
--

CREATE TABLE IF NOT EXISTS `{prefix}big_block` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `bzone` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}mark1`
--

CREATE TABLE IF NOT EXISTS `{prefix}mark1` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `tid` smallint(4) NOT NULL,
  `marker` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `count` tinyint(4) NOT NULL,
  `content` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}mark2`
--

CREATE TABLE IF NOT EXISTS `{prefix}mark2` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `rid` smallint(4) NOT NULL,
  `tid` smallint(4) NOT NULL,
  `marker` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `count` tinyint(4) NOT NULL,
  `content` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}reply`
--

CREATE TABLE IF NOT EXISTS `{prefix}reply` (
  `id2` int(4) NOT NULL AUTO_INCREMENT,
  `zuozhe1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `content1` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rid` int(4) DEFAULT NULL,
  `fuzhuid` int(4) DEFAULT NULL,
  `num2` int(4) NOT NULL COMMENT '回复次数',
  `time2` datetime NOT NULL,
  `face1` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timezc2` datetime NOT NULL,
  `fatieshu2` smallint(4) NOT NULL,
  `parentid2` int(4) NOT NULL,
  PRIMARY KEY (`id2`),
  KEY `rid` (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `{prefix}reply`
--

INSERT INTO `{prefix}reply` (`id2`, `zuozhe1`, `content1`, `rid`, `fuzhuid`, `num2`, `time2`, `face1`, `timezc2`, `fatieshu2`, `parentid2`) VALUES
(1, NULL, NULL, NULL, 1, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}small_block`
--

CREATE TABLE IF NOT EXISTS `{prefix}small_block` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `szone` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `mark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bid` int(4) NOT NULL,
  `ssort` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}online`
--

CREATE TABLE IF NOT EXISTS `{prefix}online` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `lasttime` int(4) NOT NULL,
  `user` varchar(20) NOT NULL,
  `zone` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}talk`
--

CREATE TABLE IF NOT EXISTS `{prefix}talk` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `zuozhe` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `num1` int(4) NOT NULL DEFAULT '0',
  `timeup` datetime NOT NULL,
  `time1` datetime NOT NULL,
  `face` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timezc1` datetime NOT NULL,
  `fatieshu1` smallint(4) NOT NULL,
  `parentid` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}user`
--

CREATE TABLE IF NOT EXISTS `{prefix}user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `complete` int(4) NOT NULL,
  `face` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `fatieshu` smallint(4) NOT NULL,
  `codes` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}vote`
--

CREATE TABLE IF NOT EXISTS `{prefix}vote` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `rid` int(4) NOT NULL,
  `comb` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}vote_ips`
--

CREATE TABLE IF NOT EXISTS `{prefix}vote_ips` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `vid` int(4) NOT NULL,
  `ips` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--
--
-- 表的结构 `{prefix}message`
--

CREATE TABLE IF NOT EXISTS `{prefix}message` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `mfrom` varchar(20) NOT NULL,
  `mto` varchar(20) NOT NULL,
  `mcon` varchar(40) NOT NULL,
  `time` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}message_status`
--

CREATE TABLE IF NOT EXISTS `{prefix}message_status` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `muser` varchar(20) NOT NULL,
  `mstatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for table `{prefix}reply`
--
ALTER TABLE `{prefix}reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `{prefix}talk` (`id`) ON DELETE CASCADE;
  
--
-- Constraints for table `{prefix}vote_ips`
--
ALTER TABLE `{prefix}vote_ips`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`vid`) REFERENCES `{prefix}vote` (`id`) ON DELETE CASCADE;