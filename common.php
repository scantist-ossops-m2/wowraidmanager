<?php
/***************************************************************************
*                                common.php
*                            -------------------
*   begin                : Saturday, Jan 16, 2005
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: common.php,v 2.00 2007/11/23 14:45:33 psotfx Exp $
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
*
****************************************************************************/

if ( !defined('IN_PHPRAID'))
	print_error("Hacking Attempt", "Invalid access detected", 1);

if(isset($_GET['phpraid_dir']) || isset($_POST['phpraid_dir']))
	die("Hacking attempt detected!");

// force reporting
error_reporting(E_ALL ^ E_NOTICE);

// feel free to set this to absolute if necessary
$phpraid_dir = './';

// Sanity Check the Config File
require_once($phpraid_dir."sanity.php");

// redirect to setup if it exists
if(file_exists($phpraid_dir.'install/')) {
	header("Location: install/install.php");
}

// Get list of Includes and Add them to ini_set for include path.
$include_list .= $phpraid_dir . "auth/";
$include_list .= ":" . $phpraid_dir . "db/";
$include_list .= ":" . $phpraid_dir . "includes/";
$include_list .= ":" . ini_get('include_path');

ini_set('include_path',  $include_list);

// Class require_onces
require_once($phpraid_dir.'version.php');
require_once($phpraid_dir.'config.php');
require_once($phpraid_dir.'db/mysql.php');
require_once($phpraid_dir.'includes/functions.php');
require_once($phpraid_dir.'includes/functions_auth.php');
require_once($phpraid_dir.'includes/functions_date.php');
require_once($phpraid_dir.'includes/functions_logging.php');
require_once($phpraid_dir.'includes/functions_users.php');
require_once($phpraid_dir.'includes/report.php');
require_once($phpraid_dir.'includes/template.php');
require_once($phpraid_dir.'includes/ubb.php');

// reports for all data listing
global $report;
$report = &new ReportList;

// database connection
global $db_raid, $errorTitle, $errorMsg, $errorDie;
$db_raid = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);

if(!$db_raid->db_connect_id)
{
	die('<div align="center"><strong>There appears to be a problem with the database server.<br>We should be back up shortly.</strong></div>');
}

// unset database password for security reasons
// we won't use it after this point
unset($phpraid_config['db_pass']);

//
// Populate the $phpraid_config array
//
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
while($data = $db_raid->sql_fetchrow($result, true))
{
	$phpraid_config["{$data['0']}"] = $data['1'];
}

// templates
$page = &new wrmTemplate();
$page->set_root($phpraid_dir.'templates');

// Setup the Include for the Language Files.
$include_list = $phpraid_dir . "language/lang_" . $phpraid_config['language'] . "/";
$include_list .= ":" . ini_get('include_path');
ini_set('include_path',  $include_list);

if(!is_file($phpraid_dir."language/lang_{$phpraid_config['language']}/lang_main.php"))
{
	die("The language file <i>" . $phpraid_config['language'] . "</i> could not be found!");
	$db_raid->sql_close();
}
else
{
	require_once($phpraid_dir."language/lang_{$phpraid_config['language']}/lang_main.php");
}

//foreach($phprlang as $key => $value)
//{
//	$phprlang[$key] = htmlentities($value, ENT_QUOTES, "UTF-8", false);
//}

// get auth type
require_once($phpraid_dir.'auth/auth_' . $phpraid_config['auth_type'] . '.php');
get_permissions();

if($phpraid_config['disable'] == 1 && $_SESSION['priv_configuration'] == 0)
{
	$errorTitle = $phprlang['maintenance_header'];
	$errorMsg = $phprlang['maintenance_message'];
	$errorDie = 1;
}

?>