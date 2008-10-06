<?php
/***************************************************************************
 *                             auth_phpbb3.php
 *                            -------------------
 *   begin                : July 22, 2008
 *	 Dev                  : Carsten Hölbing
 *	 email                : hoelbin@gmx.de
 *
 *	 based on 			  : auth_e107.php @ Douglas Wagner
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw0@yahoo.com
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

if ( !defined('IN_PHPRAID'))
	print_error("Hacking Attempt", "Invalid access detected", 1);

if(isset($_GET['phpraid_dir']) || isset($_POST['phpraid_dir']))
	die("Hacking attempt detected!");

// THIS IS SAFE TO TURN ON.
$BridgeSupportPWDChange = FALSE;

/*********************************************** 
 * Table and Column Names - change per CMS.
 ***********************************************/
// Column Name for the ID field for the User.
$db_user_id = "id_member";
// Column Name for the ID field for the Group the User belongs to.
$db_group_id = "id_group";
// Column Name for the UserName field.
$db_user_name = "member_name";
// Column Name for the User's E-Mail Address
$db_user_email = "email_address";
// Column Name for the User's Password
$db_user_password = "passwd";

$db_table_user_name = "members";
$db_table_group_name = "members";
$table_prefix = $phpraid_config['smf_table_prefix'];
$auth_user_class = $phpraid_config['smf_auth_user_class'];
$auth_alt_user_class = $phpraid_config['smf_alt_auth_user_class'];

//change password in WRM DB

// NOTE for Joomla the password produced here should exactly match Joomla's password schema.
function db_password_change($profile_id, $dbusernewpassword)
{
	global $db_user_id, $db_group_id, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name; 
	global $db_table_group_name, $auth_user_class, $auth_alt_user_class, $table_prefix, $db_raid, $phpraid_config;

	// SMF Specific Password Mangling
	/* 
	 * For SMF, to create a password we use the sha1 hashing algorithm but we pre-pend the username
	 * onto the beginning of the password.  The final password looks like: 
	 * sha1(strtolower($user).$password); 
	 */
	
	// Get the username:
	$sql = sprintf(	"SELECT ".$db_user_name." FROM " . $table_prefix . $db_table_user_name . 
					" WHERE ".$db_user_id." = %s", 
					quote_smart($profile_id)
			);
			
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	if (mysql_num_rows($result) != 1) {
		//user not found in WRM DB
		return 2;
	}
	$data_username = $db_raid->sql_fetchrow($result, true);
	$username = $data_username[$db_user_name];

	//Create the password:	
	$dbusernewpassword = sha1(strtolower($username).$dbusernewpassword);

	/*********************************************************************
	 * Do not modify anything below here.
	 *********************************************************************/
	//check: is profile_id in CMS DB
	$sql = sprintf(	"SELECT ".$db_user_id." FROM " . $table_prefix . $db_table_user_name . 
					" WHERE ".$db_user_id." = %s", 
					quote_smart($profile_id)
			);
			
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	if (mysql_num_rows($result) != 1) {
		//user not found in WRM DB
		return 2;
	}

	// Profile ID Exists, Update CMS with new password.
	$sql = sprintf(	"UPDATE " . $table_prefix . $db_table_user_name . 
					" SET ".$db_user_password." = %s WHERE " . $db_user_id . " = %s", 
					quote_smart($dbusernewpassword), quote_smart($profile_id)
			);

	if (($db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1)) == true)
	{
		//pwd change
		return 1;
	}
	else
	{
		//pwd NOT change
		return 0;
	} 
}

//compare password
//return value -> 0 equal ;1 Not equal
function password_check($oldpassword, $profile_id)
{
	global $db_user_id, $db_group_id, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name; 
	global $db_table_group_name, $auth_user_class, $auth_alt_user_class, $table_prefix, $db_raid, $phpraid_config;
	global $pwd_hasher;

	$sql_passchk = sprintf("SELECT " . $db_user_password . " FROM " . $table_prefix . $db_table_user_name . 
						" WHERE " . $db_user_id . " = %s", quote_smart($profile_id)
			);
	$result_passchk = $db_raid->sql_query($sql_passchk) or print_error($sql_passchk, mysql_error(), 1);

	if (mysql_num_rows($result_passchk) != 1)
	{
		//user not found in CMS DB, Fail
		return 2;
	}

	$data_passchk = $db_raid->sql_fetchrow($result_passchk, true);
	$db_pass = $data_passchk[$db_user_password];
	
	//We have the password now, now for SMF Specific Password Mangling
	/* 
	 * For SMF, we need to obtain the username and use a sha1 hash with the username and the input password
	 * to check against what's in the DB.
	 */
	$sql_user = sprintf("SELECT " . $db_user_name . " FROM " . $table_prefix . $db_table_user_name . 
						" WHERE " . $db_user_id . " = %s", quote_smart($profile_id)
			);
	$result_user = $db_raid->sql_query($sql_user) or print_error($sql_user, mysql_error(), 1);

	$data_username = $db_raid->sql_fetchrow($result_user, true);
	$username = $data_username[$db_user_name];

	$dbusernewpassword = sha1(strtolower($username).$oldpassword);

	if ($dbusernewpassword == $db_pass)
		$testVal = TRUE;
	else
		$testVal = FALSE;
	
	if ($testVal)
		return 1;
	else
		return 0;
}

function phpraid_login() 
{
	global $db_user_id, $db_group_id, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name; 
	global $db_table_group_name, $auth_user_class, $auth_alt_user_class, $table_prefix, $db_raid, $phpraid_config;

	$wrmuserpassword = $username = $password = "";

	if(isset($_POST['username'])){
		$username = scrub_input(strtolower(utf8_decode($_POST['username'])));
		$password = $_POST['password'];
	} elseif(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		$username = scrub_input(strtolower($_COOKIE['username']));
		$password = scrub_input($_COOKIE['password']);
	} else {
		phpraid_logout();
	}

	// from site/page/.. change pwd (testing)
	//if(isset($_POST['username2'])){
	//	$username = scrub_input(strtolower($_POST['username2']));
		//$password = $pwd_hasher->HashPassword($_POST['password2']);
	//	$password = md5($_POST['password2']);
	//}

	//database
	$sql = sprintf(	"SELECT ".$db_user_id.",". $db_user_name .",".$db_user_email.",".$db_user_password.
					" FROM " . $table_prefix . $db_table_user_name. 
					" WHERE ".$db_user_name." = %s", quote_smart($username)
			);

	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	//WRM database
	//$sql = sprintf("SELECT username, password FROM " . $phpraid_config['db_prefix'] . "profile WHERE username = %s",
	//				quote_smart($username)
	//		);
	//$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	//if ($data2 = $db_raid->sql_fetchrow($result2))
	//{
	//	$wrmuserpassword = $data2['password'];
	//}

	while($data = $db_raid->sql_fetchrow($result, true)) {
		//$testVal = password_check($password, $data[$db_user_id]);
		//echo "<br>Processing: " . $data[$db_user_name] . " : Password Check: " . $testVal;
		if( ($username == strtolower($data[$db_user_name])) && (password_check($password, $data[$db_user_id])) ) 
		{
			// Password Deconstruction:
			// Before we store the password, we really want to de-convert it from the "advanced" passwords
			// that are used by phpBB.  We'll take the entered password (since it checks and MD5 it for the
			// db.
			$wrmuserpassword = md5($password);

			// The user has a matching username and proper password in the phpbb database.
			// We need to validate the users group.  If it does not contain the user group that has been set as
			//	authorized to use WRM, we need to fail the login with a proper message.
			
			if ($auth_user_class != 0)
			{
				$FoundUserInGroup = FALSE;

				$sql = sprintf( "SELECT " . $db_user_id. "," .$db_group_id ." FROM " . $table_prefix . $db_table_group_name. 
								" WHERE ".$db_user_id." = %s", quote_smart($data[$db_user_id])
						);
				$resultgroup = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				while($datagroup = $db_raid->sql_fetchrow($resultgroup, true)) {
					if( ($datagroup[$db_group_id] == $auth_user_class) or ($datagroup[$db_group_id] == $auth_alt_user_class) )
					{	
						$FoundUserInGroup = TRUE;
					}
				}

				if ($FoundUserInGroup == FALSE){
					phpraid_logout();
					return -1;
				}
			}


			// User is properly logged in and is allowed to use WRM, go ahead and process his login.
			$autologin = scrub_input($_POST['autologin']);
			if(isset($autologin)) {
				// they want automatic logins so set the cookie
				// set to expire in one month
				setcookie('username', $data[$db_user_name], time() + 2629743);
				setcookie('password', $password, time() + 2629743);
			}

			// set user profile variables
			$_SESSION['username'] = strtolower(utf8_decode($data[$db_user_name]));
			$_SESSION['session_logged_in'] = 1;
			$_SESSION['profile_id'] = $data[$db_user_id];
			$_SESSION['email'] = $data[$db_user_email];

			if($phpraid_config['default_group'] != 'nil')
				$user_priv = $phpraid_config['default_group'];
			else
				$user_priv = '0';
				
			// User is all logged in and setup, the session is initialized properly.  Now we need to create the users
			//    profile in the WRM database if it does not already exist.
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id = %s",
							quote_smart($_SESSION['profile_id'])
					);
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			if ($data = $db_raid->sql_fetchrow($result))
			{
				//We found the profile in the database, update.
				$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET email = %s, password = %s, last_login_time = %s WHERE profile_id = %s",
							quote_smart($_SESSION['email']),quote_smart($wrmuserpassword),
							quote_smart(time()),quote_smart($_SESSION['profile_id'])
						);
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
			else
			{
				//Profile not found in the database or DB Error, insert.
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile VALUES (%s, %s, %s, %s, %s, %s)",
							quote_smart($_SESSION['profile_id']), quote_smart($_SESSION['email']), quote_smart($wrmuserpassword),
							quote_smart($user_priv), quote_smart(strtolower($_SESSION['username'])), quote_smart(time())
						);
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
			
			get_permissions();
			
			//security fix
			unset($username);
			unset($password);
			unset($wrmuserpassword);

			return 1;
		}
	}
	return 0;
}

function phpraid_logout()
{
	// unset the session and remove all cookies
	clear_session();
	setcookie('username', '', time() - 2629743);
	setcookie('password', '', time() - 2629743);
}

// good ole authentication
session_start();
$_SESSION['name'] = "WRM-SMF2";

// set session defaults
if (!isset($_SESSION['initiated'])) {
	if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		phpraid_login();
	} else {
		session_regenerate_id();
		$_SESSION['initiated'] = true;
		$_SESSION['username'] = 'Anonymous';
		$_SESSION['session_logged_in'] = 0;
		$_SESSION['profile_id'] = -1;
	}
}

?>