<?php
/* CREATE ADMIN TABLE */
mysql_query("CREATE TABLE `admin` (
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
/* INSERT TO ADMIN TABLE */
mysql_query("INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'nghiametrai');");
/* CREATE POST TABLE */
mysql_query("CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `approval` int(1) NOT NULL,
  `time` datetime NOT NULL,
  `time_approval` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
/* SET `id` IS PRIMARY KEY FOR POST TABLE */
mysql_query("ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);");
/* SET AUTO_INCREMENT FOR POST TABLE */
mysql_query("ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");