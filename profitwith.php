<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
?> 
 
<html>
<head>
  <title><?=$global['site_name']?></title>
  <link rel="stylesheet" href="style.css" type="text/css" />
  <link href="skin.css" rel="stylesheet" type="text/css" />
</head>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Withdraw Profit ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 


<body bgcolor="#FFFFFF" width="1000px" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
 <?
 $flag=false;
  if(isset($_POST["submit"]) and ($_POST["remarks"]!==''))
   {
    $with= $_POST[withamount];
    $bal= $_POST[balance];
    
    
    if(($with<0) or ($with>$bal))
     {
      $amount=0;
     }
    else
     {
     $amount=$with;
     } 
    
    if($amount>0)
    {
    $sql="insert into tbl_profit (date,remarks,amount,user)
          values('$_POST[demo11]','$_POST[remarks]',$amount,'$_SESSION[userName]')";
    db_query($sql) or die (mysql_error());
    
    
    $strrem="Cash Profit Withdraw By $_SESSION[userName]";
    $sql="insert into tbl_cash(date,remarks,withdraw,user,type)values('$_POST[demo11]','$strrem',$amount,'$_SESSION[userName]',11)";
    db_query($sql) or die(mysql_error());
    echo "<img src='images/active.png'>Profit Withdraw from Cash Successfully.";
    } 
   else
    {
    echo "<img src='images/inactive.png'> Error !! Please Check Amount. ";
    }  
    $flag=true;   
   }
   else
   {
    //echo "<img src='images/inactive.png'> Error !! Please give a remarks ";
   }
 ?>

  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC" id="trsubhead"><b> Profit Withdraw Form </b></td></tr>
     <tr bgcolor="#FFCCAA">  
         <td width="25%" align="center"> 
           Payment Date :
         </td><td align="center">  
           <input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>
 
  
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width="25%">Remarks</td>
         <td align="center">
           <input type="text" name="remarks" size="40"  />
         </td>
      </tr>
      <input type="hidden" name="balance" value=<? echo $_REQUEST[amount];?>>
     <tr  align="center"> 
       <td>Amount</td>
       <td><input type="text"  name="withamount" size="10" value="<?=$_REQUEST[amount];?>"  /></td>
      </tr>
    </table>
 
 
    <table width="80%"  border="1" cellspacing="1" bgcolor="#FFCCEE" cellpadding="5" align="center" style="border-collapse:collapse;">
       <tr align="center">
        <td id="trhead"><input type="submit" name="submit" value="  Save  " onclick="ConfirmChoice(); return false;"></td>
       </tr> 
     </table>
    </form>

 <br>
 <?
  $sql="select * from tbl_profit order by id desc";
  $users = mysql_query($sql);
  $total = mysql_num_rows($users);    
  if ($total>0)
      {
 ?>
   <table width="80%"  border="1" cellspacing="1"  cellpadding="5" align="center" style="border-collapse:collapse;">
    <tr id="trhead">
       <td>Date</td>
       
       <td>Remarks</td>
       <td>Amount</td>
       <td>User</td>
    </tr>
   <?
      $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr align="center">
          <td><?=$value[date]?> </td>
          
          <td><?=$value[remarks]?> </td>
          <td><?=number_format($value[amount],0);?> </td>
          <td><?=$value[user]?> </td>
       </tr>
       <?
        $totalamount=$totalamount+$value[amount];
       }
       ?>
       <tr>
         <td colspan="4"  id="trsubhead" align="right"> Total Amount: &nbsp; <? echo number_format($totalamount,0);?> Tk.</td>
       </tr> 
   </table>
   <?
   }
   ?>

   
</body>
</html>
