CREATE TABLE `role_fn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_token` varchar(100) DEFAULT NULL,
  `op_token` int(11) DEFAULT NULL,
  `res_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_fn_un` (`role_token`,`res_token`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE `role_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) DEFAULT NULL,
  `role_str` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_user_un` (`group_name`,`role_str`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
