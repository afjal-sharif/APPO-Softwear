<?php
  session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";

?>

<?
/*
 $sql="DROP VIEW IF EXISTS `apollow`.`view_stock_sales`;";
 db_query($sql) or die(mysql_error());
 echo "1. View Drop<br>";
 
 $sql="CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_stock_sales` AS select `view_stock_details_base`.`donumber` AS `donumber`,`view_stock_details_base`.`catid` AS `catid`,`view_stock_details_base`.`product` AS `product`,`view_stock_details_base`.`catname` AS `catname`,`view_stock_details_base`.`pname` AS `pname`,`view_stock_details_base`.`unit` AS `unit`,sum(`view_stock_details_base`.`qty`) AS `qty`,sum(`view_stock_details_base`.`bundle`) AS `bundle`,avg(((`view_stock_details_base`.`rate` + `view_stock_details_base`.`dfcost`) + `view_stock_details_base`.`locost`)) AS `grate` from `view_stock_details_base` group by `view_stock_details_base`.`donumber`,`view_stock_details_base`.`product` having (sum(`view_stock_details_base`.`qty`) >0.5) order by `view_stock_details_base`.`product`,`view_stock_details_base`.`dt`,`view_stock_details_base`.`donumber`,`view_stock_details_base`.`rate`;";
 db_query($sql) or die(mysql_error());
 echo "2. Create View Sales Stock<br>";
   
 $sql="CREATE TABLE IF NOT EXISTS `tbl_customer_price` (
  `id` int(10) NOT NULL auto_increment,
  `cust_id` int(10) NOT NULL,
  `product` int(5) NOT NULL,
  `price` double(10,2) NOT NULL default '0.00',
  `status` int(1) NOT NULL default '0' COMMENT '0-active;1-Inactive',
  `user` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cust_id` (`cust_id`,`product`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
 db_query($sql) or die(mysql_error());
 echo "3. Create Customer Price Table <br>";
 
 
 $sql="CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_customer_price` AS select `tbl_customer_price`.`id` AS `id`,`tbl_customer_price`.`cust_id` AS `cust_id`,`tbl_customer_price`.`product` AS `product`,`tbl_customer_price`.`price` AS `price`,`tbl_customer_price`.`status` AS `status`,`tbl_customer_price`.`user` AS `user`,`tbl_customer_price`.`date_time` AS `date_time` from `tbl_customer_price` where (`tbl_customer_price`.`status` = 0);";
 db_query($sql) or die(mysql_error());
 echo "4. View Customer Price<br>";
 
 $sql="CREATE TABLE IF NOT EXISTS `tbl_daily_sales` (
  `id` int(10) NOT NULL auto_increment,
  `cust_id` int(10) NOT NULL,
  `product` int(5) NOT NULL,
  `qty` int(6) NOT NULL,
  `rate` double(10,2) NOT NULL,
  `cost` double(10,2) NOT NULL,
  `status` int(1) NOT NULL default '0',
  `user` varchar(20) NOT NULL,
  `stock` int(10) NOT NULL default '0',
  `product_name` varchar(40) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
 db_query($sql) or die(mysql_error());
 echo "5. Daily Sales Table Created<br>"; 
 
 
 
 $sql="ALTER TABLE  `tbl_sales` ADD  `scid` INT( 8 ) NULL COMMENT  'Secondary Customer ID';";
 db_query($sql) or die(mysql_error());
 echo "1. Sales Table Alter Successfully.<br>";
 
 $sql="CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_secon_sales` AS select `tbl_sales`.`id` AS `id`,`tbl_sales`.`invoice` AS `invoice`,`tbl_sales`.`donumber` AS `donumber`,`tbl_sales`.`customerid` AS `customerid`,`tbl_sales`.`product` AS `product`,`tbl_sales`.`rate` AS `rate`,`tbl_sales`.`comission` AS `comission`,`tbl_sales`.`date` AS `date`,`tbl_sales`.`type` AS `type`,`tbl_sales`.`user` AS `user`,`tbl_sales`.`qty` AS `qty`,`tbl_sales`.`bundle` AS `bundle`,`tbl_sales`.`dateandtime` AS `dateandtime`,`tbl_sales`.`factor` AS `factor`,`tbl_sales`.`unit` AS `unit`,`tbl_sales`.`df` AS `df`,`tbl_sales`.`truckno` AS `truckno`,`tbl_sales`.`soid` AS `soid`,`tbl_sales`.`remarks` AS `remarks`,`tbl_sales`.`customername` AS `customername`,`tbl_sales`.`autoinvoice` AS `autoinvoice`,`tbl_sales`.`loadcost` AS `loadcost`,`tbl_sales`.`otherscost` AS `otherscost`,`tbl_sales`.`refid` AS `refid`,`tbl_sales`.`project` AS `project`,`tbl_sales`.`destination` AS `destination`,`tbl_sales`.`orginalqty` AS `orginalqty`,`tbl_sales`.`coldate` AS `coldate`,`tbl_sales`.`freeqty` AS `freeqty`,`tbl_sales`.`sp` AS `sp`,`tbl_sales`.`adjamount` AS `adjamount`,`tbl_sales`.`status` AS `status`,`tbl_sales`.`bdestination` AS `bdestination`,`tbl_sales`.`scid` AS `scid`,`tbl_customer`.`name` AS `cname`,`tbl_product`.`name` AS `pname` from ((`tbl_sales` join `tbl_customer` on((`tbl_sales`.`customerid` = `tbl_customer`.`id`))) join `tbl_product` on((`tbl_product`.`id` = `tbl_sales`.`product`))) where (`tbl_sales`.`scid` is not null);
      ";
 db_query($sql) or die(mysql_error());
 echo "1. View Secondary Sales Created.<br>";
 
 
 $sql="ALTER TABLE  `tbl_delete_log` CHANGE  `remarks`  `remarks` VARCHAR( 300 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL";
 db_query($sql) or die(mysql_error());
 echo "2. Alter Delete Log Table.<br>";
 
 $sql="CREATE TABLE IF NOT EXISTS `tbl_stock` (
  `id` int(10) NOT NULL auto_increment,
  `stockdt` date NOT NULL,
  `donumber` varchar(12) NOT NULL,
  `product` int(6) NOT NULL,
  `stock` double(10,2) NOT NULL default '0.00',
  `user` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";
 db_query($sql) or die(mysql_error());
 echo "1. Stock Table Created.<br>";

 
 $sql="CREATE TABLE IF NOT EXISTS `tbl_daily_cash_sales` (
  `id` int(10) NOT NULL auto_increment,
  `custid` int(8) NOT NULL,
  `cash` double(10,2) NOT NULL default '0.00',
  `bank` double(10,2) NOT NULL,
  `discount` double(6,2) NOT NULL default '0.00',
  `depositebank` varchar(20) NOT NULL,
  `remarks` varchar(60) NOT NULL,
  `user` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
"; 
 db_query($sql) or die(mysql_error());
 echo "1. Cash Sales Table Created.<br>";


$sql="DROP VIEW IF EXISTS `apollow`.`view_cust_stat_base`;";
db_query($sql) or die(mysql_error());
echo "1. Drop View<br>";

$sql="CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_cust_stat_base` AS select 2 AS `porder`,_utf8'Payment' AS `ttype`,`tbl_dir_receive`.`customerid` AS `custid`,`tbl_dir_receive`.`mrno` AS `refno`,`tbl_dir_receive`.`date` AS `dt`,`tbl_dir_receive`.`paytype` AS `paytype`,0 AS `qty`,(`tbl_dir_receive`.`hcash` + `tbl_dir_receive`.`discount`) AS `cash`,`tbl_dir_receive`.`cash` AS `bank`,`tbl_dir_receive`.`amount` AS `athand`,`tbl_dir_receive`.`chequeno` AS `cheqno`,`tbl_dir_receive`.`remarks` AS `remarks`,`tbl_dir_receive`.`cstatus` AS `status`,0 AS `salesvalue` from `tbl_dir_receive` where (`tbl_dir_receive`.`cstatus` <> _latin1'W') union all
      select 1 AS `porder`,_utf8'Sales' AS `ttype`,`tbl_sales`.`customerid` AS `custid`,`tbl_sales`.`invoice` AS `refno`,`tbl_sales`.`date` AS `dt`,_utf8'Sales' AS `paytype`,sum(`tbl_sales`.`qty`) AS `qty`,0 AS `cash`,0 AS `bank`,0 AS `athand`,_latin1'-' AS `cheqno`,coalesce(`tbl_secondary_customer`.`name`,tbl_sales.remarks)  AS `remarks`,_latin1'-' AS `status`,sum(((((`tbl_sales`.`rate` + `tbl_sales`.`df`) + `tbl_sales`.`loadcost`) * `tbl_sales`.`qty`) + `tbl_sales`.`adjamount`)) AS `salesvalue` from (`tbl_sales` left join `tbl_secondary_customer` on((`tbl_sales`.`scid` = `tbl_secondary_customer`.`id`))) group by `tbl_sales`.`customerid`,`tbl_sales`.`invoice`
      order by dt desc"; 
db_query($sql) or die(mysql_error());
echo "2. Create View<br>";

$sql="drop table tbl_retailer_target";
db_query($sql) or die(mysql_error());
echo "3. Drop Table Retailer Target<br>";


$sql="CREATE TABLE IF NOT EXISTS `tbl_retailer_target` (
  `id` int(11) NOT NULL auto_increment,
  `year` int(2) NOT NULL,
  `customer` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `company` int(3) NOT NULL,
  `target` double(8,2) NOT NULL,
  `actual` double(8,2) NOT NULL,
  `user` varchar(15) NOT NULL,
  `dateandtime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `year` (`year`,`customer`,`month`,`company`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";
db_query($sql) or die(mysql_error());
echo "4. Create Table<br>";

$sql="ALTER TABLE  `tbl_order` ADD  `ref_no` VARCHAR( 12 ) NULL COMMENT  'Holcim- Order Ref No';";
db_query($sql) or die(mysql_error());
echo "5. Alter Order Table- Ref No<br>";


$sql="ALTER TABLE  `tbl_order` ADD  `customer` INT( 4 ) NULL ;";
db_query($sql) or die(mysql_error());
echo "6. Alter Order Table- Customer<br>";
 

$sql="CREATE TABLE IF NOT EXISTS `tbl_daily_order` (
  `id` int(10) NOT NULL auto_increment,
  `company` int(3) NOT NULL,
  `ref_no` varchar(12) NOT NULL,
  `cust_id` int(10) NOT NULL,
  `product` int(5) NOT NULL,
  `qty` int(6) NOT NULL,
  `rate` decimal(6,2) NOT NULL default '0.00',
  `status` int(1) NOT NULL default '0',
  `user` varchar(20) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `cust_name` varchar(40) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;
";
db_query($sql) or die(mysql_error());
echo "7. Create Table Daily Order.<br>";

  
   
   $sql="ALTER TABLE  `tbl_sales` ADD  `payincentive` TINYINT( 1 ) NOT NULL DEFAULT  '0',ADD  `inbatch` VARCHAR( 40 ) NOT NULL ;";
   db_query($sql);
   echo "1. ALTER SALES TABLE<br>";

   $sql="CREATE TABLE IF NOT EXISTS `tbl_temp_incentive` (
          `id` int(10) NOT NULL auto_increment,
          `company` int(4) NOT NULL,
          `customer` int(4) NOT NULL,
          `year` int(4) NOT NULL,
          `month` int(2) NOT NULL,
          `qty` int(8) NOT NULL,
          `rate` int(4) NOT NULL,
          `user` varchar(20) NOT NULL,
          `date_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
          `remarks` varchar(255) NOT NULL,
          PRIMARY KEY  (`id`),
          UNIQUE KEY `company` (`company`,`customer`,`year`,`month`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
        ";
   db_query($sql);
   echo "2. TEMP INCENTIVE<br>";
   
   

   $sql="DROP TABLE  `tbl_incentive_rate`"; 
   db_query($sql);
   echo "2. DROP INCENTIVE TABLE<br>";
   
   $sql="CREATE TABLE IF NOT EXISTS `tbl_incentive_rate` (
          `id` int(10) NOT NULL auto_increment,
          `productid` int(10) NOT NULL,
          `customer` int(4) default NULL,
          `year` int(4) default '2014',
          `month` int(2) default NULL,
          `rate` float(5,2) NOT NULL,
          `user` varchar(20) NOT NULL,
          PRIMARY KEY  (`id`),
          UNIQUE KEY `productid` (`productid`,`customer`,`year`,`month`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=544 ;
        ";
    db_query($sql) or die(mysql_error());
    echo "3. CREATE TABLE INCENTIVE RATE<br>";
   
   
   $sql="ALTER TABLE  `tbl_retailer_target` ADD  `date` DATE NOT NULL;";
   db_query($sql) or die(mysql_error());
   echo "1. ALTER TABLE RETAILER TRAGET<br>";
   $sql="ALTER TABLE  `tbl_temp_incentive` CHANGE  `date_from`  `date_from` VARCHAR( 4 ) NOT NULL ,
         CHANGE  `date_to`  `date_to` VARCHAR( 4 ) NOT NULL";
   db_query($sql) or die(mysql_error());
   echo "1. TEMP TABLE ALTER TABLE<br>";       

   $sql="DROP TABLE `tbl_temp_incentive`";
   db_query($sql) or die(mysql_error());
   echo "1. DROP TEMP INCENTIVE TABLE<br>";

   $sql="CREATE TABLE IF NOT EXISTS `tbl_temp_incentive` (
          `id` int(10) NOT NULL auto_increment,
          `company` int(4) NOT NULL,
          `customer` int(4) NOT NULL,
          `date_from` varchar(4) NOT NULL,
          `date_to` varchar(4) NOT NULL,
          `qty` int(8) NOT NULL,
          `rate` int(4) NOT NULL,
          `user` varchar(20) NOT NULL,
          `date_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
          `remarks` varchar(255) NOT NULL,
          `addition` decimal(8,2) NOT NULL default '0.00',
          PRIMARY KEY  (`id`),
          UNIQUE KEY `company` (`company`,`customer`,`date_from`,`date_to`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
    db_query($sql) or die(mysql_error());
    echo "2. CREATE TEMP INCENTIVE TABLE<br>";
   
   */

  $sql="ALTER TABLE  `tbl_customer` ADD  `com_id` INT( 4 ) NOT NULL DEFAULT  '0'";
  db_query($sql) or die(mysql_error());
  echo "1. ALTER CUSTOMER TABLE<br>";

   
   
   
   
       
?>
            
<?php
 include "footer.php";
?>



