<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php  confirm_logged_in();//will redirect them to the log-in screen if they are not logged in ?>
<?php find_selected_page();//figure out what has been chosen ?>
<?php include("includes/header.php");?>

<table id="structure">
  <tr>
		<td id="navigation">
			<?php echo navigation($sel_subject, $sel_page); ?>
		</td>
		<td id="page">
			<h2>Add Item:<?php echo $sel_page['menu_name'];?></h2>
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
			
			<form action="create_item.php?page=<?php echo urlencode($sel_page['id']);?>" method="post">
				<?php $new_item = true;?>	
				<?php include("item_form.php");?>
				<input type="submit" name="submit" value="Add Item" />
			</form>
			<br>
			<a href="content.php">Cancel</a>
		</td>
	</tr>
</table>
<?php require("includes/footer.php")?>
