<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php")?>
<?php require_once("includes/functions.php")?>
<?php  confirm_logged_in();//will redirect them to the log-in screen if they are not logged in?>
<?php
  if(intval($_GET['item'])==0)
	{
		redirect_to("content.php");
	}
	include_once("includes/form_functions.php");
	
	//start form processing
	//only execute this if form processing has been submitted
	if(isset($_POST['submit']))
	{	//initialize an array to hold errors
		$errors = array();
		
		//perform validation on the form data
		$required_fields = array('menu_name', 'position', 'visible', 'price', 'description');
		$errors = array_merge($errors, check_required_fields($required_fields));
	
		$fields_with_lengths = array('menu_name' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
		
		//clean up the form data before putting into the database
		$id = mysql_prep($_GET['item']);
		$menu_name = mysql_prep($_POST['menu_name']);
		$position = mysql_prep($_POST['position']);
		$visible = mysql_prep($_POST['visible']);
		$price = mysql_prep($_POST['price']);
		$description = mysql_prep($_POST['description']);
		$image = mysql_prep($_POST['image']);
		
		//no errors-perfom the update	
		if(empty($errors))
		{
			$query = 	"UPDATE items SET
							menu_name = '{$menu_name}', 
							position = {$position}, 
							visible = {$visible},
							price = '{$price}',
							description = '{$description}',
							image = '{$image}'
						WHERE id = {$id}";
			
			$result = mysql_query($query, $connection);
			//test to see if the update occured
			if(mysql_affected_rows() == 1)
			{//success
				$message = "The page was successfully udpated!";
			
			}
			else
			{//failed
				$message = "The page udpate failed!";
				$message .= "<br>" . mysql_error();
			}
		}
		else
		{
			//errors occured
			if(count($errors) == 1)
			{
				$message = "There was 1 error in the form!";
			}
			else
			{
				$message = "There were" . count($errors) . "in the form!";
			}
		}
	}	
?>
<?php find_selected_page();?>
<?php include("includes/header.php")?>

<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($sel_subject, $sel_page); ?>
		</td>
		<td id="page">
			<h2>Edit Item:<?php echo $sel_item['menu_name'];?></h2>
			<?php 
			if(!empty($message))
			{
				echo "<p class=\"message\">" . $message . "</p>";
			}	
			?>
			<?php
			//output the list of the fields that had errors
			if(!empty($errors))
			{
				display_errors($errors);
			}
			?>
					<form action="edit_item.php?item=<?php echo urlencode($sel_item['id']);?>" method="post">
					<?php include "item_form.php" ?>
					<input type="submit" name="submit" value="Update Item" />
					&nbsp;&nbsp;
					<a href="delete_item.php?item=<?php echo urlencode($sel_item['id']);?>" onclick="return confirm('Are you sure?');">Delete Item</a>
			</form>
			<br>
			<a href="content.php">Cancel</a>
		</td>
	</tr>
</table>
<?php require("includes/footer.php")?>
