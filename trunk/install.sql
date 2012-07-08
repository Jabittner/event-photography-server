-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 25, 2009 at 12:31 PM
-- Server version: 5.0.41
-- PHP Version: 5.2.5

-- 
-- Database: `EventPhoto`
-- 
DROP DATABASE IF EXISTS `EventPhoto`; 
CREATE DATABASE `EventPhoto`; 
USE `EventPhoto`;
-- --------------------------------------------------------

-- 
-- Table structure for table `orders`
-- 

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `itemnum` int(11) NOT NULL auto_increment,
  `phone` varchar(12) default NULL,
  `event` varchar(200) NOT NULL default '',
  `photo` varchar(255) NOT NULL default '',
  `format` varchar(50) NOT NULL default '',
  `orderid` int(11) NOT NULL default '0',
  `status` varchar(200) default 'created',
  PRIMARY KEY  (`itemnum`)
) TYPE=MyISAM  AUTO_INCREMENT=152 ;

-- 
-- Dumping data for table `orders`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `stats`
-- 

DROP TABLE IF EXISTS `stats`;
CREATE TABLE IF NOT EXISTS `stats` (
  `imageid` int(11) NOT NULL auto_increment,
  `event` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `count` int(11) NOT NULL default '0',
  `date` date NOT NULL,
  PRIMARY KEY  (`imageid`)
) TYPE=MyISAM  AUTO_INCREMENT=44 ;

-- 
-- Dumping data for table `stats`
-- 


