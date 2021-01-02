<?php
 include "includes/functions.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$global['site_name']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" media="screen" rel="stylesheet" type="text/css">
<link href="skin.css" media="screen" rel="stylesheet" type="text/css">

<style type="text/css">
body,td,input,textarea,select {
 font-family: tahoma;
 font-size: 11px;
}

a:link, a:visited {
 color: #4F8DBC;
 text-decoration: none;
}

a:hover { 
 text-decoration: underline;
}

.header {
 font-family: arial;
 color: #4F8DBC;
 font-size: 18px;
}

.hr1{
 color: #CF292A;
 height: 2px; 
}
th{
 background-color: rgb(153,0,0); 
 color: #FFF;
 height: 18px;
}

.evenrow
{
 background-color: #DDDDDD;
}

.oddrow
{
 background-color: #EFEDEE;
}

.table_header{
 background-color: #CC0000;
 color: #FFF;
}

.table_footer{
 background-color: #F7946D;
 color: #FFF;
 height: 20px;
 font-weight: bold;
}


input#box1{
           height: 20px;
           width: 120px;
           background-color: #CEEEFA;
           font-family: Arial,verdana;
           font-size:15px;
           color:#000000;
           border:2px solid red;
         }

</style>
</head>

<body onLoad="document.login.user.focus()">
<div align="center">
<table width="900px" id="deatils">
  <tr>
    <td style="font-size: 22px;" align="left"> <?=$global['site_name']?></td>
    <!--<td height="63" align="right" >&nbsp;</td> -->
    <td height="60" align="right"><IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>"  border="0"></td>
  </tr>
  <tr>
    <td colspan="2" class="hr"><hr size="1" class="hr1"></td>
  </tr> 
  
  <tr>
    <td colspan="2">

