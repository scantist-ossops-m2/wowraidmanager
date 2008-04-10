<?php
/***************************************************************************
 *                               locations.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2005 Kyle Spraggs
 *   email                : spiffyjr@gmail.com
 *
 *   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
// commons
define("IN_PHPRAID", true);	
require_once('./common.php');

// page authentication
define("PAGE_LVL","locations");
require_once($phpraid_dir.'includes/authentication.php');

// show the form
if($_GET['mode'] == 'view')
{
	$loc = array();
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result))
	{
		$edit = '<a href="locations.php?mode=update&id='.$data['location_id'].'"><img src="templates/' . $phpraid_config['template'] . 
				'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] . '\')"; onMouseout="hideddrivetip()"></a>';
			

		$delete = '<a href="locations.php?mode=delete&n='.$data['name'].'&id='.$data['location_id'].'"><img src="templates/' . 
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['delete'] . '\')"; 
					onMouseout="hideddrivetip()"></a>';

		
		array_push($loc, 
			array(
				'id'=>$data['location_id'],
				'name'=>$data['name'],
				'location'=>$data['location'],
				'min_lvl'=>$data['min_lvl'],
				'max_lvl'=>$data['max_lvl'],
				'max_chars'=>$data['max'],
				'dr'=>$data['dr'],
				'hu'=>$data['hu'],
				'ma'=>$data['ma'],
				'pa'=>$data['pa'],
				'pr'=>$data['pr'],
				'ro'=>$data['ro'],
				'sh'=>$data['sh'],
				'wk'=>$data['wk'],
				'wa'=>$data['wa'],
				''=>$edit . $delete,
			)
		);
	}
	
	// setup output for data
	setup_output();
	$report->showRecordCount(true);
	$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&Base=');
	$report->setListRange($_GET['Base'], 25);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());
	
	//Default sorting
	if(!$_GET['Sort'])
	{
		$report->allowSort(true, 'location', 'ASC', 'locations.php?mode=view');
	}
	else
	{
		$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'locations.php?mode=view');
	}
	
	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('id',$phprlang['id'],'','center');
	$report->addOutputColumn('name',$phprlang['name'],'','center');
	$report->addOutputColumn('location',$phprlang['location'],'','center');
	$report->addOutputColumn('min_lvl',$phprlang['min_lvl'],'','center');
	$report->addOutputColumn('max_lvl',$phprlang['max_lvl'],'','center');
	$report->addOutputColumn('dr', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/druid_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['druid'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('hu', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/hunter_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['hunter'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('ma', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/mage_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['mage'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('pa', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/paladin_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['paladin'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('pr', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/priest_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['priest'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('ro', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/rogue_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['rogue'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('sh', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/shaman_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['shaman'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('wk', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/warlock_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['warlock'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('wa', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/warrior_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['warrior'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('max_chars',$phprlang['max_raiders'],'','center');
	$report->addOutputColumn('','','','right');
	$loc = $report->getListFromArray($loc);
	
	$page->set_file(array(
		'output' => $phpraid_config['template'] . '/locations.htm')
	);
	
	$page->set_var('locs',$loc);
	$page->set_var('header',$phprlang['locations_header']);
	
	$page->parse('output','output');
}
elseif($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')
{
	// form submitted, check for errors
	// assume no errors
	$form_error = 0;
		
	// slashes
	$name =$_POST['name'];
	$loc = $_POST['location'];
		
	$min_lvl = $_POST['min_lvl'];
	$max_lvl = $_POST['max_lvl'];
	$dr = $_POST['dr'];
	$hu = $_POST['hu'];
	$ma = $_POST['ma'];
	$pa = $_POST['pa'];
	$pr = $_POST['pr'];
	$ro = $_POST['ro'];
	$sh = $_POST['sh'];
	$wk = $_POST['wk'];
	$wa = $_POST['wa'];
	$max = $_POST['max'];
	
	if($_GET['mode'] == 'new')
	{
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "locations (`location`,`min_lvl`,`max_lvl`,
		`name`,`dr`,`hu`,`ma`,`pa`,`pr`,`ro`,`sh`,`wk`,`wa`,`max`) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
		quote_smart($loc),quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($name),quote_smart($dr),quote_smart($hu),
		quote_smart($ma),quote_smart($pa),quote_smart($pr),quote_smart($ro),quote_smart($sh),quote_smart($wk),quote_smart($wa),quote_smart($max));
		
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		
		log_create('location',mysql_insert_id(),$name);
	}
	elseif($_GET['mode'] == 'edit');
	{
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id = '';
		
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "locations SET name=%s,max=%s,dr=%s,hu=%s,ma=%s,pa=%s,pr=%s,ro=%s,sh=%s,wk=%s,
		wa=%s,min_lvl=%s,max_lvl=%s,location=%s WHERE location_id=%s",quote_smart($name),quote_smart($max),quote_smart($dr),
		quote_smart($hu),quote_smart($ma),quote_smart($pa),quote_smart($pr),quote_smart($ro),quote_smart($sh),quote_smart($wk),quote_smart($wa),quote_smart($min_lvl),
		quote_smart($max_lvl),quote_smart($loc),quote_smart($id));
		
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	
	header("Location: locations.php?mode=view");
}
elseif($_GET['mode'] == 'delete')
{
	$id = $_GET['id'];
	$n = $_GET['n'];
	
	if($_SESSION['priv_locations'] == 1) {
		if(!isset($_POST['submit'])) {			
			$form_action = 'locations.php?mode=delete&n='.$n.'&id=' . $id;
			$confirm_button = '<input type="submit" value="Confirm" name="submit" class="post">';
			
			$page->set_file('output',$phpraid_config['template'] . '/delete.htm');
			
			$page->set_var(
				array(
					'form_action'=>$form_action,
					'confirm_button'=>$confirm_button,
					'delete_header'=>$phprlang['delete_header'],
					'delete_msg'=>$phprlang['delete_msg'],
				)
			);
			$page->parse('output','output');
		} else {
			log_delete('location',$n);
			
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "locations WHERE location_id=%s",quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			header("Location: locations.php?mode=view");
		}
	} else {
		if($_SESSION['priv_locations'] == 1)
			header("Location: locations.php?mode=view");
		else
			header("Location: index.php");
	}
}

if($_GET['mode'] != 'delete')
{
	if($_GET['mode'] == 'view')
	{
		// setup new form information
		$form_action = 'locations.php?mode=new';
		$name = '<input name="name" type="text" id="name" class="post">';
		$location = '<input name="location" type="text" id="name" class="post">';
		$min_lvl = '<input name="min_lvl" type="text" class="post" style="width:20px" maxlength="2">';
		$max_lvl = '<input name="max_lvl" type="text" class="post" style="width:20px" maxlength="2">';
		$dr = '<input name="dr" type="text" class="post" style="width:20px" maxlength="2">';
		$hu = '<input name="hu" type="text" class="post" style="width:20px" maxlength="2">';
		$ma = '<input name="ma" type="text" class="post" style="width:20px" maxlength="2">';
		$pa = '<input name="pa" type="text" class="post" style="width:20px" maxlength="2">';
		$pr = '<input name="pr" type="text" class="post" style="width:20px" maxlength="2">';
		$ro = '<input name="ro" type="text" class="post" style="width:20px" maxlength="2">';
		$sh = '<input name="sh" type="text" class="post" style="width:20px" maxlength="2">';
		$wk = '<input name="wk" type="text" class="post" style="width:20px" maxlength="2">';
		$wa = '<input name="wa" type="text" class="post" style="width:20px" maxlength="2">';
		$max = '<input name="max" type="text" class="post" style="width:20px" maxlength="2">';
		$buttons = '<input type="submit" value="Submit" name="submit" class="mainoption"> <input type="reset" value="Reset" name="reset" class="liteoption">';
	}
	elseif($_GET['mode'] == 'update')
	{
		$id = $_GET['id'];
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE location_id=%s",quote_smart($id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result);
		
		// it's an edit... joy
		$form_action = "locations.php?mode=edit&id=$id";
		$name = '<input name="name" type="text" id="name" value="' . $data['name'] . '" class="post">';
		$location = '<input name="location" type="text" id="name" value="' . $data['location'] . '"  class="post">';
		$min_lvl = '<input name="min_lvl" type="text" value="' . $data['min_lvl'] . '"  class="post" style="width:20px" maxlength="2">';
		$max_lvl = '<input name="max_lvl" type="text" value="' . $data['max_lvl'] . '"  class="post" style="width:20px" maxlength="2">';
		$dr = '<input name="dr" type="text" value="' . $data['dr'] . '"  class="post" style="width:20px" maxlength="2">';
		$hu = '<input name="hu" type="text" value="' . $data['hu'] . '"  class="post" style="width:20px" maxlength="2">';
		$ma = '<input name="ma" type="text" value="' . $data['ma'] . '"  class="post" style="width:20px" maxlength="2">';
		$pa = '<input name="pa" type="text" value="' . $data['pa'] . '"  class="post" style="width:20px" maxlength="2">';
		$pr = '<input name="pr" type="text" value="' . $data['pr'] . '"  class="post" style="width:20px" maxlength="2">';
		$ro = '<input name="ro" type="text" value="' . $data['ro'] . '"  class="post" style="width:20px" maxlength="2">';
		$sh = '<input name="sh" type="text" value="' . $data['sh'] . '"  class="post" style="width:20px" maxlength="2">';
		$wk = '<input name="wk" type="text" value="' . $data['wk'] . '"  class="post" style="width:20px" maxlength="2">';
		$wa = '<input name="wa" type="text" value="' . $data['wa'] . '"  class="post" style="width:20px" maxlength="2">';
		$max = '<input name="max" type="text" value="' . $data['max'] . '"  class="post" style="width:20px" maxlength="2">';
		$buttons = '<input type="submit" value="Update" name="submit" class="mainoption"> <input type="reset" value="Reset" name="reset" class="liteoption">';			
	}
	
	$page->set_file('new_loc',$phpraid_config['template'] . '/locations_new.htm');
	$page->set_var(
		array(
			'form_action'=>$form_action,
			'name'=>$name,
			'location'=>$location,
			'min_lvl'=>$min_lvl,
			'max_lvl'=>$max_lvl,
			'dr'=>$dr,
			'hu'=>$hu,
			'ma'=>$ma,
			'pa'=>$pa,
			'pr'=>$pr,
			'ro'=>$ro,
			'sh'=>$sh,
			'wk'=>$wk,
			'wa'=>$wa,
			'max'=>$max,
			'buttons'=>$buttons,
			'druid_name'=>$phprlang['druid'],
			'hunter_name'=>$phprlang['hunter'],
			'mage_name'=>$phprlang['mage'],
			'paladin_name'=>$phprlang['paladin'],
			'priest_name'=>$phprlang['priest'],
			'rogue_name'=>$phprlang['rogue'],
			'shaman_name'=>$phprlang['shaman'],
			'warlock_name'=>$phprlang['warlock'],
			'warrior_name'=>$phprlang['warrior'],
			'newlocation_header'=>$phprlang['locations_new'],
			'shortname_text'=>$phprlang['locations_short'],
			'location_text'=>$phprlang['locations_long'],
			'minlvl_text'=>$phprlang['locations_min_lvl'],
			'maxlvl_text'=>$phprlang['locations_max_lvl'],
			'maxattendees_text'=>$phprlang['locations_raid_max'],
			'limits_header'=>$phprlang['locations_limits_header'],
		)
	);
		
	$page->parse('output','new_loc',true);
}

//
// Start output of page
//
require_once('includes/page_header.php');

$page->p('output','output');

require_once('includes/page_footer.php');
?>