<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in();//will redirect them to the log-in screen if they are not logged in ?>
<?php include("includes/header.php");?>

<div id="structure">
		<div id="navigation">
			<?php echo navigation($sel_subject, $sel_page); ?>
		</div>
		<div id="page">
			<h2>Add Subject</h2>
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
			
			<form action="create_subject.php" method="post">
			<?php $new_subject = true;?>
			<?php include("subject_form.php");?>
			<div class="actions"><input type="submit" name="submit" value="Add Subject" /></div>
			</form>
			<br>
			<a href="content.php">Cancel</a>
		</div>
</div>
<?php require("includes/footer.php")?>
