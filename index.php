<?php
header("location: login.php");
function db_connect($sql_host, $sql_user, $sql_password) {
        return mysql_connect($sql_host, $sql_user, $sql_password);
}

$con = db_connect('localhost','root','');

  //	
if (!$con) {
   die('Could not connect: ' . mysql_error());
}
 mysql_select_db('holcim',$con);
function db_query($query) {
		global $debug_mode;
		global $mysql_autorepair;

		if(defined("START_TIME")) {
			global $__sql_time;
			$t = func_microtime();
		}
		$result = mysql_query($query);
		if(defined("START_TIME")) {
			$__sql_time += func_microtime()-$t;
		}

		#
		# Auto repair
		#
		if( !$result && $mysql_autorepair && preg_match("/'(\S+)\.(MYI|MYD)/",mysql_error(), $m) ){
			$stm = "REPAIR TABLE $m[1]";
			error_log("Repairing table $m[1]", 0);
			if ($debug_mode == 1 || $debug_mode == 3) {
				$mysql_error = mysql_errno()." : ".mysql_error();
				echo "<B><FONT COLOR=DARKRED>Repairing table $m[1]...</FONT></B>$mysql_error<BR>";
				flush();
			}
			$result = mysql_query($stm);
			if (!$result)
				error_log("Repaire table $m[1] is failed: ".mysql_errno()." : ".mysql_error(), 0);
			else
				$result = mysql_query($query); # try repeat query...
		}
		if (db_error($result, $query) && $debug_mode==1)
			exit;
		return $result;
}

function db_error($mysql_result, $query) {
	global $debug_mode, $error_file_size_limit, $error_file_path, $PHP_SELF;
	global $config, $login, $REMOTE_ADDR, $current_location;
	
	if ($mysql_result)
		return false;
	else {
		$back_trace = func_get_backtrace();

		$mysql_error = mysql_errno()." : ".mysql_error();
		if (@$config["Email_Note"]["admin_sqlerror_notify"]=="Y") {
			x_session_register("login");
			$err_str  = "Date        : ".date("d-M-Y H:i:s")."\n";
			$err_str .= "Site        : ".$current_location."\n";
			$err_str .= "Script      : ".$PHP_SELF."\n";
			$err_str .= "Remote IP   : $REMOTE_ADDR\n";
			$err_str .= "Logged as   : $login\n";
			$err_str .= "SQL query   : $query\n";
			$err_str .= "Error code  : ".mysql_errno()."\n";
			$err_str .= "Description :\n\n".mysql_error()."\n";
			$err_str .= "Backtrace   :\n".implode("\n", $back_trace);
			func_send_simple_mail($config["Company"]["site_administrator"], $config["Company"]["company_name"].": SQL Error notification", $err_str, $config["Company"]["site_administrator"]);
		}
		if ($debug_mode == 1 || $debug_mode == 3) {
			echo "<B><FONT COLOR=DARKRED>INVALID SQL: </FONT></B>$mysql_error<BR>";
			echo "<B><FONT COLOR=DARKRED>SQL QUERY FAILURE:</FONT></B> $query <BR>";
			flush();
		}
		if ($debug_mode == 2 || $debug_mode == 3) {
			$filename = $error_file_path."/x-errors_sql.txt";
			if ($error_file_size_limit!=0 && @filesize($filename)>$error_file_size_limit*1024)
				@unlink($filename);
			if ($fp = @fopen($filename, "a+")) {
				$err_str = date("[d-M-Y H:i:s]")." SQL error: $PHP_SELF\n".$query."\n".$mysql_error;
				$err_str .= "\nBacktrace:\n".implode("\n", $back_trace);
				$err_str .= "\n-------------------------------------------------\n";
				fwrite($fp, $err_str);
				fclose($fp);
			}
		}
	}
	return true;
}


  ob_start(); // Turn on output buffering 
  system('ipconfig /all'); //Execute external program to display output 
  $mycom=ob_get_contents(); // Capture the output into a variable 
  ob_clean(); // Clean (erase) the output buffer  
  $findme = "Physical"; 
  $pmac = strpos($mycom, $findme); // Find the position of Physical text 
  $mac=substr($mycom,($pmac+36),17); // Get Physical Address  
  $ipAddress=$_SERVER['REMOTE_ADDR']; 
  
  $sql="insert into tbl_user_access(ip,mac)values('$ipAddress','$mac')";
  db_query($sql);
    
  
?>
