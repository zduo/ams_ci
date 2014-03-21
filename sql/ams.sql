-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1:3306
-- 生成日期: 2014 年 03 月 21 日 02:16
-- 服务器版本: 5.1.28
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ams`
--

-- --------------------------------------------------------

--
-- 表的结构 `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('e676f35ee3886e91b8236bb43cf60fbd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36', 1395368018, 'a:2:{s:9:"user_data";s:0:"";s:10:"flexi_auth";a:8:{s:15:"user_identifier";s:15:"admin@admin.com";s:9:"user_name";s:5:"admin";s:7:"user_id";s:1:"2";s:5:"admin";b:1;s:5:"group";a:1:{i:2;s:12:"管理员组";}s:10:"privileges";a:14:{i:18;s:7:"add_idc";i:19;s:10:"add_server";i:20;s:8:"list_idc";i:21;s:11:"list_server";i:22;s:7:"del_idc";i:23;s:10:"del_server";i:1;s:8:"add_user";i:3;s:9:"add_group";i:4;s:9:"del_group";i:5;s:13:"add_privilege";i:6;s:13:"del_privilege";i:11;s:9:"list_user";i:12;s:10:"list_group";i:13;s:14:"list_privilege";}s:22:"logged_in_via_password";b:1;s:19:"login_session_token";s:40:"9808f022659ddabeeb127d87f9a16fdd5e56a469";}}');

-- --------------------------------------------------------

--
-- 表的结构 `t_idc_info`
--

CREATE TABLE IF NOT EXISTS `t_idc_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idc_name` varchar(50) NOT NULL COMMENT 'IDC名称',
  `idc_location` varchar(50) NOT NULL COMMENT 'IDC地址',
  `idc_desc` varchar(100) NOT NULL COMMENT 'IDC描述',
  `idc_isp` varchar(255) NOT NULL COMMENT 'IDC线路',
  `is_bgp` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='IDC信息表' AUTO_INCREMENT=6 ;

--
-- 导出表中的数据 `t_idc_info`
--

INSERT INTO `t_idc_info` (`id`, `idc_name`, `idc_location`, `idc_desc`, `idc_isp`, `is_bgp`) VALUES
(3, '兆维电信', '北京酒仙桥', '北京酒仙桥兆维电信机房', '联通34', 0),
(4, '测试', '测试', '测试', '测试', 0),
(5, '是等法定', '阿道夫', '单独的', 'retro', 1);

-- --------------------------------------------------------

--
-- 表的结构 `t_server_info`
--

CREATE TABLE IF NOT EXISTS `t_server_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idc_id` int(11) NOT NULL COMMENT '机器所在IDC',
  `server_label` varchar(50) DEFAULT NULL COMMENT '服务器资产编号',
  `server_cabinet` varchar(10) DEFAULT NULL COMMENT '服务器所在机柜',
  `server_oem` varchar(10) DEFAULT NULL COMMENT '服务器品牌',
  `server_height` varchar(10) DEFAULT NULL COMMENT '服务器U数',
  `server_cpu_model` varchar(20) DEFAULT NULL COMMENT '服务器CPU型号',
  `server_cpu_count` int(11) DEFAULT NULL COMMENT '服务器CPU数量',
  `server_memory` int(11) DEFAULT NULL COMMENT '服务器内存大小',
  `server_hd` varchar(100) DEFAULT NULL COMMENT '服务器硬盘',
  `server_powers` varchar(10) DEFAULT NULL COMMENT '服务器电源',
  `server_raid` varchar(100) DEFAULT NULL COMMENT '服务器RAID',
  `server_os` varchar(100) DEFAULT NULL COMMENT '服务器系统',
  `server_desc` varchar(100) DEFAULT NULL COMMENT '服务器用途描述',
  `server_user` varchar(30) DEFAULT NULL COMMENT '服务器维护人员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='服务器信息表' AUTO_INCREMENT=4 ;

--
-- 导出表中的数据 `t_server_info`
--

INSERT INTO `t_server_info` (`id`, `idc_id`, `server_label`, `server_cabinet`, `server_oem`, `server_height`, `server_cpu_model`, `server_cpu_count`, `server_memory`, `server_hd`, `server_powers`, `server_raid`, `server_os`, `server_desc`, `server_user`) VALUES
(2, 3, '1', '2', '3', '4', '5', 6, 7, '8', '9', '10', '11', '12', '13'),
(3, 4, '5467', '也一样', '样', '3', 'rere36', 32, 32, '10000', '推推推', '665', '电饭锅', '金口诀', '热天');

-- --------------------------------------------------------

--
-- 表的结构 `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `uacc_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uacc_group_fk` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uacc_email` varchar(100) NOT NULL DEFAULT '',
  `uacc_username` varchar(15) NOT NULL DEFAULT '',
  `uacc_password` varchar(60) NOT NULL DEFAULT '',
  `uacc_ip_address` varchar(40) NOT NULL DEFAULT '',
  `uacc_salt` varchar(40) NOT NULL DEFAULT '',
  `uacc_activation_token` varchar(40) NOT NULL DEFAULT '',
  `uacc_forgotten_password_token` varchar(40) NOT NULL DEFAULT '',
  `uacc_forgotten_password_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uacc_update_email_token` varchar(40) NOT NULL DEFAULT '',
  `uacc_update_email` varchar(100) NOT NULL DEFAULT '',
  `uacc_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uacc_suspend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uacc_fail_login_attempts` smallint(5) NOT NULL DEFAULT '0',
  `uacc_fail_login_ip_address` varchar(40) NOT NULL DEFAULT '',
  `uacc_date_fail_login_ban` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Time user is banned until due to repeated failed logins',
  `uacc_date_last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uacc_date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`uacc_id`),
  UNIQUE KEY `uacc_id` (`uacc_id`),
  KEY `uacc_group_fk` (`uacc_group_fk`),
  KEY `uacc_email` (`uacc_email`),
  KEY `uacc_username` (`uacc_username`),
  KEY `uacc_fail_login_ip_address` (`uacc_fail_login_ip_address`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `user_accounts`
--

INSERT INTO `user_accounts` (`uacc_id`, `uacc_group_fk`, `uacc_email`, `uacc_username`, `uacc_password`, `uacc_ip_address`, `uacc_salt`, `uacc_activation_token`, `uacc_forgotten_password_token`, `uacc_forgotten_password_expire`, `uacc_update_email_token`, `uacc_update_email`, `uacc_active`, `uacc_suspend`, `uacc_fail_login_attempts`, `uacc_fail_login_ip_address`, `uacc_date_fail_login_ban`, `uacc_date_last_login`, `uacc_date_added`) VALUES
(2, 2, 'admin@admin.com', 'admin', '$P$BPSYjd6qBFgu6d9f8xikvZsG6EnNaG/', '127.0.0.1', 'SVVpGSV6g2', '', '', '0000-00-00 00:00:00', '', '', 1, 0, 0, '', '0000-00-00 00:00:00', '2014-03-21 01:36:19', '2014-03-20 02:14:13');

-- --------------------------------------------------------

--
-- 表的结构 `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `ugrp_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `ugrp_name` varchar(20) NOT NULL DEFAULT '',
  `ugrp_desc` varchar(100) NOT NULL DEFAULT '',
  `ugrp_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ugrp_id`),
  UNIQUE KEY `ugrp_id` (`ugrp_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 导出表中的数据 `user_groups`
--

INSERT INTO `user_groups` (`ugrp_id`, `ugrp_name`, `ugrp_desc`, `ugrp_admin`) VALUES
(1, '普通用户', '查看权限', 0),
(2, '管理员组', '管理用户', 1),
(3, '新用户', '没有任何权限', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user_login_sessions`
--

CREATE TABLE IF NOT EXISTS `user_login_sessions` (
  `usess_uacc_fk` int(11) NOT NULL DEFAULT '0',
  `usess_series` varchar(40) NOT NULL DEFAULT '',
  `usess_token` varchar(40) NOT NULL DEFAULT '',
  `usess_login_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`usess_token`),
  UNIQUE KEY `usess_token` (`usess_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `user_login_sessions`
--

INSERT INTO `user_login_sessions` (`usess_uacc_fk`, `usess_series`, `usess_token`, `usess_login_date`) VALUES
(2, '', '9808f022659ddabeeb127d87f9a16fdd5e56a469', '2014-03-21 02:16:03'),
(2, '', 'b3a67d7ceb9ea4e2a73fcb5a37cb837058c91567', '2014-03-20 11:12:36');

-- --------------------------------------------------------

--
-- 表的结构 `user_privileges`
--

CREATE TABLE IF NOT EXISTS `user_privileges` (
  `upriv_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_name` varchar(20) NOT NULL DEFAULT '',
  `upriv_desc` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`upriv_id`),
  UNIQUE KEY `upriv_id` (`upriv_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 导出表中的数据 `user_privileges`
--

INSERT INTO `user_privileges` (`upriv_id`, `upriv_name`, `upriv_desc`) VALUES
(1, 'add_user', '添加用户'),
(3, 'add_group', '添加用户组'),
(4, 'del_group', '删除用户组'),
(5, 'add_privilege', '添加权限'),
(6, 'del_privilege', '删除权限'),
(11, 'list_user', '用户列表'),
(12, 'list_group', '用户组列表'),
(13, 'list_privilege', '权限列表'),
(18, 'add_idc', '添加idc'),
(19, 'add_server', '添加server'),
(20, 'list_idc', '查看idc'),
(21, 'list_server', '查看server'),
(22, 'del_idc', '删除idc'),
(23, 'del_server', '删除server');

-- --------------------------------------------------------

--
-- 表的结构 `user_privilege_groups`
--

CREATE TABLE IF NOT EXISTS `user_privilege_groups` (
  `upriv_groups_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `upriv_groups_ugrp_fk` smallint(5) unsigned NOT NULL DEFAULT '0',
  `upriv_groups_upriv_fk` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`upriv_groups_id`),
  UNIQUE KEY `upriv_groups_id` (`upriv_groups_id`) USING BTREE,
  KEY `upriv_groups_ugrp_fk` (`upriv_groups_ugrp_fk`),
  KEY `upriv_groups_upriv_fk` (`upriv_groups_upriv_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- 导出表中的数据 `user_privilege_groups`
--

INSERT INTO `user_privilege_groups` (`upriv_groups_id`, `upriv_groups_ugrp_fk`, `upriv_groups_upriv_fk`) VALUES
(31, 1, 20),
(32, 1, 21),
(33, 2, 18),
(34, 2, 19),
(35, 2, 20),
(36, 2, 21),
(37, 2, 22),
(38, 2, 23),
(39, 2, 1),
(40, 2, 3),
(41, 2, 4),
(42, 2, 5),
(43, 2, 6),
(44, 2, 11),
(45, 2, 12),
(46, 2, 13);

-- --------------------------------------------------------

--
-- 表的结构 `user_privilege_users`
--

CREATE TABLE IF NOT EXISTS `user_privilege_users` (
  `upriv_users_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_users_uacc_fk` int(11) NOT NULL DEFAULT '0',
  `upriv_users_upriv_fk` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`upriv_users_id`),
  UNIQUE KEY `upriv_users_id` (`upriv_users_id`) USING BTREE,
  KEY `upriv_users_uacc_fk` (`upriv_users_uacc_fk`),
  KEY `upriv_users_upriv_fk` (`upriv_users_upriv_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 导出表中的数据 `user_privilege_users`
--

INSERT INTO `user_privilege_users` (`upriv_users_id`, `upriv_users_uacc_fk`, `upriv_users_upriv_fk`) VALUES
(1, 2, 18),
(2, 2, 19),
(3, 2, 20),
(4, 2, 21),
(5, 2, 22),
(6, 2, 23),
(7, 2, 1),
(8, 2, 3),
(9, 2, 4),
(10, 2, 5),
(11, 2, 6),
(12, 2, 11),
(13, 2, 12),
(14, 2, 13);
