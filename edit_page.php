<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php  confirm_logged_in();//will redirect them to the log-in screen if they are not logged in?>
<?php
	if(intval($_GET['page'])==0)
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
		$required_fields = array('menu_name', 'position', 'visible', 'content');
		$errors = array_merge($errors, check_required_fields($required_fields));
	
		$fields_with_lengths = array('menu_name' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
		
		//clean up the form data before putting into the database
		$id = mysql_prep($_GET['page']);
		$menu_name = trim(mysql_prep($_POST['menu_name']));
		$position = mysql_prep($_POST['position']);
		$visible = mysql_prep($_POST['visible']);
		$content = mysql_prep($_POST['content']);
		
		//no errors-perfom the update	
		if(empty($errors))
		{
			$query = 	"UPDATE pages SET
							menu_name = '{$menu_name}', 
							position = {$position}, 
							visible = {$visible},
							content = '{$content}'
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

<div id="structure">
		<div id="navigation">
			<?php echo navigation($sel_subject, $sel_page); ?>
		</div>
		<div id="page">
			<h2>Edit Page:<?php echo $sel_page['menu_name'];?></h2>
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
					<form action="edit_page.php?page=<?php echo urlencode($sel_page['id']);?>" method="post">
					<?php include "page_form.php" ?>
					<div class="actions"><input type="submit" name="submit" value="Update Page" /></div>
					
			</form>
			<br>
			<a href="delete_page.php?page=<?php echo urlencode($sel_page['id']);?>" onclick="return confirm('Are you sure?');">Delete Page</a>
			<br>
			<a href="content.php">Cancel</a>
			<div id="page_items">
			<!--<p>Items within this page:</p><br>-->
			<?php
				$item_set = get_items_for_page($_GET['page']);
				$item_count = mysql_num_rows($item_set);
				echo "<p>Items within this page:<br>";
				echo "<ul class=\"page\">";
				while($item = mysql_fetch_array($item_set))
				{
					echo "<li><a class='page' href=\"edit_item.php?item=" . urlencode($item['id']) . "\">{$item['menu_name']}</a></li><br>";
				}
				echo "</ul>";
				echo "</p>";
			?>
			
			</div>
		</div>
</div>
<?php require("includes/footer.php")?>
