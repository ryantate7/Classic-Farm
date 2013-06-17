<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php  confirm_logged_in();//will redirect them to the log-in screen if they are not logged in?>
<?php
  if(intval($_GET['subj'])==0)
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
		$required_fields = array('menu_name', 'position', 'visible');
		$errors = array_merge($errors, check_required_fields($required_fields));
	
		$fields_with_lengths = array('menu_name' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
		
		//clean up the form data before putting into the database
		$id = mysql_prep($_GET['subj']);
		$menu_name = trim(mysql_prep($_POST['menu_name']));
		$position = mysql_prep($_POST['position']);
		$visible = mysql_prep($_POST['visible']);
		
		//no errors-perfom the update
		if(empty($errors))
		{
			$query = 	"UPDATE subjects SET
							menu_name = '{$menu_name}', 
							position = {$position}, 
							visible = {$visible}
						WHERE id = {$id}";
			
			$result = mysql_query($query, $connection);
			//test to see if the update occured
			if(mysql_affected_rows() == 1)
			{	//success
				$message = "The subject was successfully udpated!";
			
			}
			else
			{	//failed
				$message = "The subject udpate failed!";
				$message .= "<br>" . mysql_error();
			}
		}
		//errors occured
		else
		{
			
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
	//end form processing
?>
<?php find_selected_page();?>
<?php include("includes/header.php")?>

<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($sel_subject, $sel_page); ?>
		</td>
		<td id="page">
			<h2>Edit Subject:<?php echo $sel_subject['menu_name'];?></h2>
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
			<form action="edit_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>" method="post">
				<p>Subject Name: <input type="text" name="menu_name" value="<?php echo $sel_subject['menu_name'];?>" id="menu_name" /></p>
					<p>Position:
						<select name="position">
							<?php
								$subject_set = get_all_subjects();
								$subject_count = mysql_num_rows($subject_set);
								for($count=1; $count <= $subject_count+1; $count++)
								{
									echo "<option value=\"{$count}\"";
									if($sel_subject['position'] == $count)
									{
										echo " selected";
									}
									echo ">{$count}</option>";
								
								}
							?>		
						</select>
					</p>
					<p>Visible:
					<input type="radio" name="visible" value="0"<?php
					if($sel_subject['visible']==0)
					{
						echo " checked";
					}
					?>/>No
														
					<input type="radio" name="visible" value="1"<?php 
					if($sel_subject['visible']==1)
					{
						echo " checked";
					}
					?>/>Yes
							
					</p>
					<input type="submit" name="submit" value="Update Subject" />
					&nbsp;&nbsp;
			</form>
		<a href="delete_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>" onclick="return confirm('Are you sure?');">-Delete this Subject</a>
		<br>
		<a href="content.php">Cancel</a>
		<br><br><br><br>
		<p>Pages within this subject:<br>
		<?php
			$page_set = get_pages_for_subject($_GET['subj']);
			$page_count = mysql_num_rows($page_set);
			echo "<ul class=\"page\">";
			while($page = mysql_fetch_array($page_set))
				
				{
					echo "<li><a class='page' href=\"content.php?page=" . urlencode($page['id']) . "\">{$page['menu_name']}</a></li><br>";
				}
			echo "</ul>";
		?>
		</p>
		<a href="new_page.php?subj=<?php echo urlencode($sel_subject['id']); ?>">+ Add a new page to this Subject</a>
		</td>
	</tr>
</table>
<?php require("includes/footer.php")?>
