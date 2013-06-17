<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php")?>
<?php require_once("includes/functions.php")?>
<?php  confirm_logged_in();//will redirect them to the log-in screen if they are not logged in?>
<?php
  if(intval($_GET['page'])==0)
	{
		redirect_to("content.php");
	}
	
	$id = mysql_prep($_GET['page']);
	
	if($page = get_page_by_id($id))
	{
		$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
		$result = mysql_query($query, $connection);
	
		if(mysql_affected_rows()==1)
		{//success
			redirect_to("content.php");
		}
		else
		{//deletion Failed
			echo "<p>Page deletion failed!</p>";
			echo "<p>" . mysql_error() . "</p>";
			echo "<a href=\"content.php\">Return to Main Page</a>";
		}
	}
	else
	{	//subject didn't exist in Database
		redirect_to("content.php");
		
	}
?>
<?php mysql_close($connection); ?>
