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
			<h2>Add Subject</h2>
			<form action="create_subject.php" method="post">
				<p>Subject Name: <input type="text" name="menu_name" value="" id="menu_name" /></p>
					<p>Position:
						<select name="position">
							<?php 
								$item_set = get_all_items();
								$item_count = mysql_num_rows($item_set);
								for($count=1; $count <= $item_count+1; $count++)
								{
									echo "<option value=\"{$count}\">{$count}</option>";
								
								}
							?>	
						</select>
					</p>
					<p>Visible:
						<input type="radio" name="visible" value="0" />No
						&nbsp;
						<input type="radio" name="visible" value="1" />Yes
					</p>
					<input type="submit" value="Add Item" />
			</form>
			<br>
			<a href="content.php">Cancel</a>
		</td>
	</tr>
</table>
<?php require("includes/footer.php")?>
