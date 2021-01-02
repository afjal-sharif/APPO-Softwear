<?php

  include "./includes/config.php";
  include "./includes/connect.php";

           
function safe_query( $query = "")
{
	if ( empty($query) ) RETURN FALSE;
  
	if( !$result = mysql_query($query) )
	{
		die("
				The query failed<br>"
				. "&middot; errorno=" . mysql_errno() . "<br>"
				. "&middot; error=" . mysql_error() . "<br>"
				 . "<pre>$query</pre>"
			);
	}
	else
	{
		global $query_count;
		$query_count++;
		global $query_count;
		return $result;
	}
}

#
# Database abstract layer functions
#
function db_connect($sql_host, $sql_user, $sql_password) {
        return mysql_connect($sql_host, $sql_user, $sql_password);
}

function db_select_db($sql_db) {
        return mysql_select_db($sql_db) || die("Could not connect to SQL db");
}

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

function db_result($result, $offset) {
        return mysql_result($result, $offset);
}

function db_fetch_row($result) {
        return mysql_fetch_row($result);
}

function db_fetch_array($result, $flag=MYSQL_ASSOC) {
    return mysql_fetch_array($result, $flag);
}

function db_free_result($result) {
        @mysql_free_result($result);
}

function db_num_rows($result) {
       return mysql_num_rows($result);
}

function db_insert_id() {
       return mysql_insert_id();
}

function db_affected_rows() {
	return mysql_affected_rows();
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

#
# Execute mysql query adn store result into associative array with
# column names as keys...
#
function func_query($query) {

        $result = false;
        if ($p_result = db_query($query)) {
 	       while($arr = db_fetch_array($p_result))
				$result[]=$arr;
				db_free_result($p_result);
        }

        return $result;

}

#
# Execute mysql query and store result into associative array with
# column names as keys and then return first element of this array
# If array is empty return array().
#
function func_query_first($query) {

		if ($p_result = db_query($query)) {
			$result = db_fetch_array($p_result);
			db_free_result($p_result);
        }
        return is_array($result)?$result:array();

}

#
# Execute mysql query and store result into associative array with
# column names as keys and then return first cell of first element of this array
# If array is empty return false.
#
function func_query_first_cell($query) {
	if ($p_result = db_query($query)) {
		$result = db_fetch_row($p_result);
		db_free_result($p_result);
	}
	return is_array($result)?$result[0]:false;
}

#
# Function to get backtrace for debugging
#
function func_get_backtrace($skip=0) {
	$result = array();
	if (!function_exists('debug_backtrace')) {
		$result[] = '[func_get_backtrace() is supported only for PHP version 4.3.0 or better]';
		return $result;
	}
	$trace = debug_backtrace();

	if (is_array($trace) && !empty($trace)) {
		if ($skip>0) {
			if ($skip < count($trace))
				$trace = array_splice($trace, $skip);
			else
				$trace = array();
		}

		foreach ($trace as $item) {
			$result[] = $item['file'].':'.$item['line'];
		}
	}

	if (empty($result)) {
		$result[] = '[empty backtrace]';
	}

	return $result;
}




    
?>
