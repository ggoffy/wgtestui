# SQL Dump for wgtestui module
# PhpMyAdmin Version: 4.0.4
# https://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Wed Mar 01, 2023 to 06:40:15
# Server version: 5.5.5-10.4.12-MariaDB
# PHP Version: 8.0.0

#
# Structure table for `wgtestui_tests` 9
#

CREATE TABLE `wgtestui_tests` (
  `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(500) NOT NULL DEFAULT '',
  `module` VARCHAR(255) NOT NULL DEFAULT '',
  `area` INT(10) NOT NULL DEFAULT '0',
  `type` INT(10) NOT NULL DEFAULT '0',
  `resultcode` INT(10) NOT NULL DEFAULT '0',
  `resulttext` VARCHAR(255) NOT NULL DEFAULT '',
  `fatalerrors` INT(10) NOT NULL DEFAULT '0',
  `errors` INT(10) NOT NULL DEFAULT '0',
  `deprecated` INT(10) NOT NULL DEFAULT '0',
  `infotext` TEXT NOT NULL ,
  `tplsource` VARCHAR(255) NOT NULL DEFAULT '',
  `datetest` INT(11) NOT NULL DEFAULT '0',
  `datecreated` INT(11) NOT NULL DEFAULT '0',
  `submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

