-- phpMyAdmin SQL Dump
-- version 4.1.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-06-02 12:25:21
-- 服务器版本： 5.6.15
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tuishudan`
--

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT '' COMMENT '用户名',
  `password` varchar(32) DEFAULT '' COMMENT '密码',
  `email` varchar(100) DEFAULT '' COMMENT '邮箱',
  `phone` int(11) unsigned DEFAULT NULL COMMENT '电话',
  `name` varchar(20) DEFAULT '' COMMENT '姓名',
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `phone`, `name`, `reg_time`) VALUES
(1, 'sdfsdf', '9590811e519ded9321ba4854fe2dd135', '303429874@qq.com', NULL, '', '2014-01-15 02:51:51'),
(2, 'abc', '9590811e519ded9321ba4854fe2dd135', 'sdfdf@sfsd.com', NULL, 'sdfa', '2014-01-15 02:57:11'),
(3, 'x303429874', '9590811e519ded9321ba4854fe2dd135', 'x303429874@qq.com', NULL, 'qqq', '2014-03-05 10:25:11'),
(4, 'x303429874a', '9590811e519ded9321ba4854fe2dd135', 'xxx@163.com', NULL, 'xxx', '2014-05-19 15:32:34'),
(5, 'x3034a', '9db06bcff9248837f86d1a6bcf41c9e7', 'x3034a@163.com', NULL, 'xxx', '2014-05-19 15:34:28'),
(6, 'x3034b', '9db06bcff9248837f86d1a6bcf41c9e7', 'x3034b@162.com', NULL, 'bbb', '2014-05-19 15:38:39'),
(7, 'x3034c', '9db06bcff9248837f86d1a6bcf41c9e7', 'x3034c@162.com', NULL, 'ccc', '2014-05-19 15:40:32');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- 表的结构 `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL,
  `tag_name` int(11) NOT NULL COMMENT '标签名字',
  `book_id` int(11) NOT NULL COMMENT '书ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='书标签表';

