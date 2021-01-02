<?php
 session_start();
 $mnuid=408;
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 ?>
<link href="test.css" rel="stylesheet" type="text/css" />
<script src="./js/code_regen.js"></script> 
<script language="JavaScript">
function ConfirmAdd()
{
answer = confirm("Are You Sure To Add Data ?")
if (answer !=0)
{
window.submit();
}
}	



function validate_pro(thisform)
{
with (thisform)
  {
  if (validate_required(name,"Error On Name Field!")==false){name.focus();return false;}
  if (validate_required(owner,"Error On Dealer Name Field!")==false){owner.focus();return false;}
  if (validate_required(address,"Error On Address Field!")==false){address.focus();return false;}  
  if (validate_required(mobile,"Error On Mobile Field!")==false){mobile.focus();return false;}
  if (validate_required(area,"Error On Area Field!")==false){area.focus();return false;}
  if (validate_required(sp,"Error On SP Field!")==false){sp.focus();return false;}
 
  //if (validate_required(image,"Error On Image Field!")==false){image.focus();return false;}
  //if (validate_required(wife,"Error On Dealer Wife Name Field!")==false){wife.focus();return false;}  
  //if (validate_required(wmobile,"Error On Wife Mobile Field!")==false){wmobile.focus();return false;}
  //if (validate_required(wimage,"Error On Wife Image Field!")==false){wimage.focus();return false;}
  if (validate_required(child,"Error On Child Field!")==false){child.focus();return false;}

  
  }
}

function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {alert(alerttxt);return false;}
  }
}
</script>


<?php
//define a maxim size for the uploaded images in Kb
 define ("MAX_SIZE","900"); 

//This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

//This variable is used as a flag. The value is initialized with 0 (meaning no error  found)  
//and it will be changed to 1 if an errro occures.  
//If the error occures the file will not be uploaded.
 $errors=0;
//checks if the form has been submitted
// Child Add




// Dealer Info
 if(isset($_POST['Submit'])) 
 {
 	//reads the name of the file the user submitted for uploading
 	$image=$_FILES['image']['name'];
 	$wimage=$_FILES['wimage']['name'];
 	//if it is not empty
 	if (($image) & ($wimage)) 
 	{
 	//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['image']['name']);
 	//get the extension of the file in a lower case format
  	$extension = getExtension($filename);
 		$extension = strtolower($extension);
 		
 		$wfilename = stripslashes($_FILES['wimage']['name']);
 		
     $wextension = getExtension($wfilename);
 		 $wextension = strtolower($wextension);
 		
 	//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
	//otherwise we will do more tests
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($wextension != "jpg") && ($wextension != "jpeg") && ($wextension != "png") && ($wextension != "gif")  ) 
 		{
		//print error message
 			echo 'Unknown extension!';
 			$errors=1;
 		}
 		else
 		{
//get the size of the image in bytes
 //$_FILES['image']['tmp_name'] is the temporary filename of the file
 //in which the uploaded file was stored on the server
 $size=filesize($_FILES['image']['tmp_name']);
 $wsize=filesize($_FILES['wimage']['tmp_name']);
//compare the size with the maxim size we defined and print error if bigger
if (($size > MAX_SIZE*9024) or ($wsize > MAX_SIZE*9024)) 
{
	echo '<h1>You have exceeded the size limit!</h1>';
	$errors=1;
}

//we will give an unique name, for example the time in unix time format
$image_name=$_SESSION[userName].time().'.'.$extension;
$wimage_name='w'.$_SESSION[userName].time().'.'.$extension;
//the new name will be containing the full path where will be stored (images folder)
//$newname="images/".$image_name;
 $newname=$image_name;
 $wnewname=$wimage_name;

$_SESSION[name]=$newname;
$_SESSION[wname]=$wnewname;
//we verify if the image has been uploaded, and print error instead
$copied = copy($_FILES['image']['tmp_name'], 'profile/'.$newname);
$wcopied = copy($_FILES['wimage']['tmp_name'], 'profile/'.$wnewname);
if (!$copied) 
{	
	$errors=1;
}}}}




//If no errors registred, print the success message
 if(isset($_POST['Submit']) && !$errors) 
 {
 	
 	
 	$dealer=$_POST[name];
 	$owner=$_POST[owner];
 	$address=$_POST[address];
 	$mobile=$_POST[mobile];
 	$DOB=$_POST[demo12];
 	$image=$_SESSION[name];
 	$area=$_POST[area];
 	$sp=$_POST[sp];
 	$code=$_POST[code];
 	
 	$wife=$_POST[wife];
 	$WDOB=$_POST[demo13];
 	$WDOM=$_POST[demo14];
 	$wmobile=$_POST[wmobile];
 	$wimage=$_SESSION[wname];
  $com_id=$_POST[company]; 	
 	
 	$sql="insert into tbl_customer (codeno,name,owner,address,mobile,tnt,user,area,type,btype,email,remarks,customerbangla,sp,dob,wife_name,w_mobile,w_dob,aniversery,picture,w_picture,tin,trade_lic,com_id)
         value('$_POST[code]', '$_POST[name]','$owner','$_POST[address]','$_POST[mobile]','$_POST[tnt]',
             '$_SESSION[userName]','$_POST[area]','$_POST[type]','$_POST[btype]','$_POST[email]','$_POST[remarks]','$_POST[bangla_text]','$_POST[sp]','$DOB','$wife','$wmobile','$WDOB','$WDOM','$image','$wimage','$_POST[tin]','$_POST[trade]','$com_id')"; 
 	
 	//$sql="insert into dealer_database(dealership,owner,address,imagename,mobile,dob,wife,wmobile,wdob,marrage,wimage,child,user)values('$dealer','$owner','$address','$image','$mobile','$DOB','$wife','$wmobile','$WDOB','$WDOM','$wimage',$child,'$_SESSION[userName]')";
  db_query($sql) or die(mysql_error());	
 	
   echo "<img src=image/right.jpeg width=25 height=25 alt='Success'><b> Customer Information Insert Successfully!</b><br>";
 	$flag=true;
 }
 if(!$flag)
  {
   
      $user_query="SELECT max(id)+1 as cust_id FROM `tbl_customer`";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $cust_id=$row_sql[cust_id];
      
      $cust_id=str_pad($cust_id,4, "0",STR_PAD_LEFT);
      
  
?>
 <!--next comes the form, you must set the enctype to "multipart/frm-data" and use an input type "file" -->
 <form name="newad" method="post" enctype="multipart/form-data"  action="" onsubmit="return validate_pro(this)">
 
 <table align="center" width="90%" style="Border-collapse:Collapse" border="1" bgcolor="#FFFFFF" bordercolor="#EEFFCC"  cellspacing="5" cellpadding="5">
  <tr bgcolor="#FFCCEE" id="trhead" height="20px">
     <td colspan="2" align="center">New Customer Information.</td>
     
  </tr>
 
  <tr align="left"><td>Name of the Customer:*</td>
      <td>
       <input type="text" name="name" value="" size="40"  />
        
       </td>
  </tr>
 <tr align="left">
  <td colspan="1">
    <a href="guideline.html" target="_blank" title="Click Here To View Bangla Type Help">
    &#2453;&#2494;&#2488;&#2463;&#2507;&#2478;&#2494;&#2480;&#2503;&#2480; &#2472;&#2494;&#2478;
    </a>
  </td><td>  
    <textarea name="bangla_text" id="bangla" cols="30" rows="1" onfocus="" style="font-family:vrinda; font-size: 15px; width: 500px; height: 30px;" ><?=$text?></textarea>
  </td>
  <script>
    makePhoneticEditor('bangla'); //pass the textarea Id
  </script>

 </tr>
   <tr align="left"><td>Customer Code No:*</td>
      <td>
       <input type="text" name="code" value="<?=$cust_id;?>" READONLY size="8"  />
        
       </td>
  </tr>
    
  <tr align="left"><td>Owner Name:*</td>
     <td><input type="text" name="owner" value="" size="40"  /></td>
  </tr>
  
    <tr align="left">
  <td>SP:</td>
  <td>
    <?
           $query_sql = "SELECT  id,shortname,type  FROM tbl_sp order by id desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="sp" style="width: 220px;">          
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["sp"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['shortname']?> :: <?php echo $row_sql['type']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>         
       </td>
   </tr>
  
  <tr align="left"><td>Address:</td>
      <td><textarea name="address" rows="3" cols="80">-</textarea></td>
  </tr>
 
  <tr align="left"><td>Type:*</td>
     <td>
       
       <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=2 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="type" style="width: 220px;">          
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($_POST["type"]==$row_sql['area_name']) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
     </td>
  </tr>  
  

 <tr align="left"><td>Business Type:*</td>
     <td>
       
        <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=4 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="btype" style="width: 220px;">          
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($_POST["btype"]==$row_sql['area_name']) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
     </td>
  </tr>  
    
  
  <tr align="left"><td>Area:*</td>
     <td>
       
       <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=0 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="area" style="width: 220px;">          
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($_POST["area"]==$row_sql['area_name']) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
     </td>
  </tr>  
   
  
  <tr align="left"><td>Mobile:*</td>
     <td><input type="text" name="mobile" value="-" size="12"  /></td>
  </tr>  
  
  <tr align="left"><td>T & T:</td>
     <td><input type="text" name="tnt" value="" size="12"  /></td>
  </tr>  
  <tr align="left"><td>E-Mail:</td>
     <td><input type="text" name="email" value="" size="12"  /></td>
  </tr>  
  
  <tr align="left"><td>TIN</td>
     <td><input type="text" name="tin" value="" size="20"  /></td>
  </tr>  
  
  <tr align="left"><td>Trade Licence:</td>
     <td><input type="text" name="trade" value="" size="20"  /></td>
  </tr>  
  
  
  
  
 <tr align="left"><td>Date Of Birth:</td>
 <td> 
   <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
         <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
         <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
     
  </td>
 </tr>
 
  <tr align="left"><td align="left">Picture</td>
     <td><input type="file" size="40" name="image"></td></tr>
     
  <tr align="left"><td align="left">Remarks</td>
     <td><input type="text" size="60" name="remarks"></td>
  </tr>
  
  <tr>
       <td colspan="1">
         COMPANY
       </td>
       <td>   
          <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company"  style="width: 250px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($cat==$row_sql['id']) echo "SELECTED"; if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>

  
     
 	
 	<tr id="trhead" bgcolor="#FFCCEE" height="20px"><td colspan="2" align="center">Customer's Wife Information.</td></tr>
 	
 
   
   <tr align="left"><td>Wife Name:</td>
     <td><input type="text" name="wife" value="" size="40"  /></td>
  </tr>
  <tr align="left"><td>Date Of Birth:</td>
 <td> 
   <input type="Text" id="demo13" maxlength="15" size="15" value="<?=isset($_POST["demo13"])?$_POST["demo13"]:date('Y-m-d')?>" name="demo13"  onchange="javascript: document.senditem.submit()";>
         <a href="javascript: NewCssCal('demo13','yyyymmdd','dropdown')"> 
         <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
     
  </td>
 </tr>
 
  <tr align="left"><td>Date Of Marriage:</td>
 <td> 
   <input type="Text" id="demo14" maxlength="15" size="15" value="<?=isset($_POST["demo14"])?$_POST["demo14"]:date('Y-m-d')?>" name="demo14"  onchange="javascript: document.senditem.submit()";>
         <a href="javascript: NewCssCal('demo14','yyyymmdd','dropdown')"> 
         <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
     
  </td>
 </tr>

  <tr align="left"><td>Mobile:</td>
     <td><input type="text" name="wmobile" value="" size="12"  /></td>
  </tr>  
  <tr align="left"><td align="left">Picture</td>
     <td><input type="file" size="40" name="wimage"></td></tr>

  <tr id="trsubhead"><td align="center" colspan="2"><input name="Submit" type="submit"  onclick="ConfirmAdd(); return false;"  value="Save Information"></td></tr>
 </table>	
 </form> 
 <?}
 
  include "footer.php";
?>
