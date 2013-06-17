<?php require_once("includes/session.php"); ?>
<?php include("includes/functions.php"); ?>
<?php  confirm_logged_in();//will redirect them to the log-in screen if they are not logged in ?>
<?php include("includes/header.php"); ?>

<table id="structure">
  <tr>
		<td id="navigation">
			&nbsp;
		</td>
		<td id="page">
			<h2>Staff Menu</h2>
			<p>Welcome to the staff area, <?php echo $_SESSION['username'];?>.</p>
			<ul>
				<li><a href="content.php">Manage Website Content</a></li>
				<li><a href="new_user.php">Add Staff User</a></li>
				<li><a href="log_out.php">Logout</a></li>
			</ul>
		</td>
	</tr>
</table>
<?php include("includes/footer.php")?>
