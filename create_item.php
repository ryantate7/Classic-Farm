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
		redirect_to("new_item.php");
	}
?>
<?php 
	$page_id = mysql_prep($_GET['page']);
	$menu_name = mysql_prep($_POST['menu_name']);
	$position = mysql_prep($_POST['position']);
	$visible = mysql_prep($_POST['visible']);
	$price = mysql_prep($_POST['price']);
	$description = mysql_prep($_POST['description']);
	$image = mysql_prep($_POST['image']);
	?>
<?php
	$query = "INSERT INTO items(page_id, menu_name, position, visible, price, description, image) VALUES({$page_id}, '{$menu_name}', {$position}, {$visible}, '{$price}', '{$description}', '{$image}')";
	
	if(mysql_query($query, $connection))
	{
		//success
		redirect_to("content.php?page=" . urlencode($page_id) . "");
	}
	else
	{
		//display error message
		echo "<p>Item addition failed!</p>";
		echo "<p>" . mysql_error() . "</p><br>";
		echo "<p>" . $query . "</p><br>";
		echo "<p>Page ID:" . $page_id . "</p>";
	}
?>
<?php mysql_close($connection); ?>
