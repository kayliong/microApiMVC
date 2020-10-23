# create database
CREATE DATABASE IF NOT EXISTS microapimvc_test;

use microapimvc_test;

# create users table
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `given_name` varchar(50) DEFAULT '',
  `surname` varchar(50) DEFAULT '',
  `email` varchar(191) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# create tasks table
DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `user_id` int(3) unsigned DEFAULT NULL,
  `type` tinyint(1) unsigned DEFAULT NULL COMMENT '1:task, 2:bug, 3:story',
  `priority` tinyint(1) DEFAULT NULL COMMENT '1:high, 2:medium, 3:low, 4:trivial',
  `status` tinyint(1) DEFAULT NULL COMMENT '0:open, 1:inprogress, 2:completed',
  `start_date` timestamp NULL DEFAULT NULL COMMENT 'task start date',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tasks_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;