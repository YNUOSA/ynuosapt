CREATE TABLE `pre_ynuosapt_tid_files` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT NULL,
  `downloadcount` int(11) DEFAULT '0',
  `hash_info` varchar(40) DEFAULT NULL,
  `uploadtime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
