<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php")?>
<?php require_once("includes/functions.php")?>
<?php  confirm_logged_in();//will redirect them to the log-in screen if they are not logged in?>
<?php
  //form validation
	$errors = array();
	$required_fields = array('menu_name', 'position', 'visible');
	foreach($required_fields as $fieldname)
	{
		if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname]))
			{
				$errors[] = $fieldname;
			}
	}
	
	$fields_with_lengths = array('menu_name' => 30);
	foreach($fields_with_lengths as $fieldname => $maxlength)
	{
		if(strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength)
		{
			$errors[] = $fieldname;
		}
	}
		
	if(!empty($errors))
	{
		redirect_to("new_page.php");
	}
?>
<?php 
	$subj_id = mysql_prep($_GET['subj']);
	$menu_name = mysql_prep($_POST['menu_name']);
	$position = mysql_prep($_POST['position']);
	$visible = mysql_prep($_POST['visible']);
	$content = mysql_prep($_POST['content']);
	?>
<?php
	$query = "INSERT INTO pages(subj_id, menu_name, position, visible, content) VALUES({$subj_id}, '{$menu_name}', {$position}, {$visible}, '{$content}')";
	
	if(mysql_query($query, $connection))
	{
		//success
		$last_id = mysql_insert_id();
		redirect_to("content.php?page=" . urlencode($last_id) . "");
	}
	else
	{
		//display error message
		echo "<p>Page creation failed!</p>";
		echo "<p>" . mysql_error() . "</p>";
	}
?>
<?php mysql_close($connection); ?>
