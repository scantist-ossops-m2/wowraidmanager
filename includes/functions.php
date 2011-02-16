<?php
/***************************************************************************
*                               functions.php
*                            -------------------
*   begin                : Saturday, Jan 16, 2005
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: functions.php,v 2.00 2008/03/03 14:18:34 psotfx Exp $
*
***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2008 Douglas Wagner
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
****************************************************************************/
if (!function_exists("htmlspecialchars_decode")) {
    function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT) {
        return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
    }
}

function email($to, $subject, $message) {
	global $phpraid_config;

	$message .= "\n\n" . $phpraid_config['email_signature'];

	$mheaders = 'From: ' . $phpraid_config['site_name'] . '<' . $phpraid_config['admin_email'] . '>' . "\r\n" .
		   'Reply-To: '  . $phpraid_config['admin_email'] . "\r\n" .
		   'Return-Path: <' . $phpraid_config['admin_email'] . "\r\n" .
		   'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $mheaders);
}

function print_error($type, $error, $die) {
	global $phprlang, $phpraid_config;

	$errorMsg = '<html><link rel="stylesheet" type="text/css" href="templates/'.$phpraid_config['template'].'/style/stylesheet.css"><body>';
	$errorMsg .= '<div align="center">'.$phprlang['print_error_msg_begin'];

	if($die == 1)
		$errorMsg .= $phprlang['print_error_critical'];
	else
		$errorMsg .= $phprlang['print_error_minor'];

	$errorMsg .= '<br><br><b>'.$phprlang['print_error_page'].':</b> ' . $_SERVER['PHP_SELF'];
	$errorMsg .= '<br><br><b>'.$phprlang['print_error_query'].':</b> ' . $type;
	$errorMsg .= '<br><br><b>'.$phprlang['print_error_details'].':</b><br>' . $error['code'] . ": " . $error['message'];
	$errorMsg .= '<br><br><b>'.$phprlang['print_error_msg_end'].'</b></div></body></html>';
	$errorTitle = $phprlang['print_error_title'];

	echo '<div align="center"><div class="errorHeader" style="width:600px">'.$errorTitle .'</div>';
	echo '<div class="errorBody" style="width:600px">'.$errorMsg.'</div>';

	if($die == 1)
		exit;
}

function quote_smart_old($value)
{
   // Stripslashes
   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }
   // Quote if not a number or a numeric string
   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value) . "'";
   }
   return $value;
}

function quote_smart($value = "", $nullify = false, $conn = null)
{
	//reset default if second parameter is skipped
	$nullify = ($nullify === null) ? (false) : ($nullify);
	//undo slashes for poorly configured servers
	$value = (get_magic_quotes_gpc()) ? (stripslashes($value)) : ($value);
	//check for null/unset/empty strings (takes advantage of short-circuit evals to avoid a warning)
	if ((!isset($value)) || (is_null($value)) || ($value === ""))
	{
		$value = ($nullify) ? ("NULL") : ("''");
	}
	else
	{
		if (is_string($value))
		{
			//value is a string and should be quoted; determine best method based on available extensions
			if (function_exists('mysql_real_escape_string'))
			{
				$value = "'" . (((isset($conn)) && (is_resource($conn))) ? (mysql_real_escape_string($value, $conn)) : (mysql_real_escape_string($value))) . "'";
			}
			else
			{
				$value = "'" . mysql_escape_string($value) . "'";
			}
		}
		else
		{
			//value is not a string; if not numeric, bail with error
			$value = (is_numeric($value)) ? ($value) : ("'ERROR: unhandled datatype in quote_smart'");
		}
	}
	return $value;
}

function scrub_input($value = "", $html_allowed = false)
{
	$value=strip_tags($value, '<br><a>');

	if (!$html_allowed)
		$value = htmlspecialchars($value);

	return $value;
}


//Note: Reverse: reverses the color.  Normally the check is if count > count_max set to red, in the case where the 
//			counts are used as MINIMUM values (config:class_as_min) if count < count_max set to red. 
function get_color($text, $count, $max_count, $reverse)
{
	$class = '';

	if($count < $max_count)
		if($reverse)
			$class = 'badcolor'; //Red
		else
			$class = 'goodcolor'; //Green
	
	if($count == $max_count)
		$class = 'evencolor'; //Black
	
	if($count > $max_count)
		if($reverse)
			$class = 'evencolor'; //Black
		else
			$class = 'badcolor'; //Red 
			
	return $class ? '<span class="' . $class . '">' . $text . '</span>' : $text;
}

function get_coloredcount($signedup, $count, $max_count, $onqueue, $reverse = false)
{
	return '<!-- ' . $signedup . ' -->' . get_color($count . "/" . $max_count . ($onqueue ? '(+' . $onqueue . ')' : ''), $count, $max_count, $reverse);
}

function linebreak_to_br($str) {
  $str = preg_replace("/(\r\n?)|(\n\r?)/s", "<br />", $str);
  return $str;
}

function linebreak_to_bslash_n($str) {
  $str = preg_replace("/(\r\n?)|(\n\r?)/s", "\\n", $str);
  return $str;
}

function strip_linebreaks($str) {
  $str = preg_replace("/(\r\n?)+|(\n\r?)+/s", " ", $str);
  
  return $str;
}

// properly escapes HTML characters in Javascript popups so they don't break javascript
function escapePOPUP($arg) {
    $arg = str_replace("'", "\'", $arg);
    return $arg;
} 

// Sanitizes data for entry into the database. Escapes special
// characters and encodes html entities.
function sanitize($array) {
  $retarr_keys = array_keys($array);
  $retarr_values = array_values($array);
  
  for ($i = 0; $i < count($retarr_keys) - 1; $i++)
  {
  	if (is_string($retarr_values[$i]))
  	{
		$retarr_values[$i] = addslashes($retarr_values[$i]);
		$retarr_values[$i] = htmlspecialchars($retarr_values[$i]);
  	}

  	$array[$retarr_keys[$i]] = $retarr_values[$i];
  }

  return $array;
}

// Reverses database sanitization by removing escape backslashes
// and decoding html entities.
function desanitize($array) {
  $retarr_keys = array_keys($array);
  $retarr_values = array_values($array);
  
  for ($i = 0; $i < count($retarr_keys) - 1; $i++)
  {
  	if (is_string($retarr_values[$i]))
  	{
		$retarr_values[$i] = stripslashes($retarr_values[$i]);
		$retarr_values[$i] = htmlspecialchars_decode($retarr_values[$i]);
  	}

  	$array[$retarr_keys[$i]] = $retarr_values[$i];
  }

  return $array;
}

function magic_quotes_on() {
  if ((get_magic_quotes_gpc() == '0') OR (strtolower(get_magic_quotes_gpc()) == 'off')) {
    return false;
  }
  
  return true;
}

function get_dupesignup_symbol()
{
	return '<font color="' . '#cc0000' . '"><b>!</b></font>';
}

function generate_expanding_box($title, $info)
{
	// Include exp_content.html in the main HTML page at the point where the box should reside. 
	global $expboxid;
	
	$expboxid++;
	
	$wrmsmarty->assign('expbox', 
		array (
			'id'=>$expboxid,
			'title'=>$title,
			'info'=>$info,
		)
	);
}

/**
 * Recursively delete files in directory (but not the directories themselves).
 *
 * @param string $dir Directory name
 * @param boolean $deleteRootToo Delete specified top-level directory as well
 */
function unlinkRecursive($dir, $deleteRootToo=FALSE)
{
    if(!$dh = @opendir($dir))
    {
        return;
    }
    while (false !== ($obj = readdir($dh)))
    {
        if($obj == '.' || $obj == '..' || $obj == '.gitignore')
        {
            continue;
        }

        if (!@unlink($dir . '/' . $obj))
        {
            unlinkRecursive($dir.'/'.$obj, $deleteRootToo);
        }
    }

    closedir($dh);
   
    if ($deleteRootToo)
    {
        @rmdir($dir);
    }
   
    return;
} 

// UTF8 Oh how I hate you. - This code SHOULD force a UTF8 Connection between client and server.
//   From this point on, everything sent from the client to the server or returned from
//     the server to the client should now be multi-byte aware.
function set_WRM_DB_utf8()
{
	global $phpraid_config,$db_raid;
	
	if (($phpraid_config['wrm_db_utf8_support'] == "yes") or 
		!isset($phpraid_config['wrm_db_utf8_support']) )
	{
		$sql = "SET NAMES 'utf8'";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$sql = "SET CHARACTER SET 'utf8'";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);		
	}
}

/**
 * get mysql version from phpinfo()
 * this function is a copy from install/includes/function.php
 * 
 * @return boolean
 */
function get_mysql_client_version_from_phpinfo()
{
	ob_start();
	phpinfo(INFO_MODULES);
	$info = ob_get_contents();
	ob_end_clean();
	$info = stristr($info, 'Client API version');
	preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $info, $match);
	$gd = $match[0];

	return $gd;
}

/**
 * get mysql version from mysql()
 *
 * @return boolean
 */
function get_mysql_version_from_mysql()
{
	$a = mysql_get_server_info();
	$mysql_version = substr($a, 0, strpos($a, "-"));
		
	return $mysql_version;
}

/*********************************************
 * 		DATABASE STATISTICS SECTION
 *********************************************/
//that will do but i didn't have a version to test it (4.xx)
function get_db_size()
{
	global $db_raid,$phpraid_config;
	$gd = get_mysql_version_from_mysql();
	
	if (strnatcmp($gd,'4.2.0') >= 0)
	{	
		// MySQL Database Size
		$dbsize = 0;
		$sql = "SHOW TABLE STATUS WHERE name LIKE '". $phpraid_config['db_prefix'] . "%'";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true)) 
		{  
			$dbsize += $data[ "Data_length" ] + $data[ "Index_length" ];
		}
		
		$dbsize = round($dbsize / 1024, 2); //(Kilobytes)
	}
	else 
	{
		$dbsize = "N/A";
	}
	
	return $dbsize; //(Kilobytes)
}

?>