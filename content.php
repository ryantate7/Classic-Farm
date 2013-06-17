<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php  confirm_logged_in();//will redirect them to the log-in screen if they are not logged in ?>
<?php find_selected_page();//figure out what has been chosen ?>
<?php include("includes/header.php") ?>

<table id="structure">
	<tr>
		<td id="navigation">
				
			<?php echo navigation($sel_subject, $sel_page); ?>
				
		</td>
		<td id="page">
			<?php if(!is_null($sel_subject))//subject selected
			{
				echo "<h2>" . $sel_subject["menu_name"] . "</h2>";
			}
			elseif(!is_null($sel_page))//page selected
			{
				echo "<h2>{$sel_page["menu_name"]}</h2>";
				echo "<div class='page-content'>" . $sel_page['content'] . "</div><br>";
				$item_set = get_items_for_page($sel_page['id']);
				echo "<ul>";
				while($item = mysql_fetch_array($item_set))//list out items belonging to the selected page
				{
					echo "<li><a class='item' href=\"edit_item.php?item=" . urlencode($item['id']) . "\">{$item['menu_name']}</a></li><br><br>";
				}
				echo "</ul>";
				echo "<br><a href=\"edit_page.php?page=" . urlencode($sel_page['id']) . "\">Edit Page</a><br><br>";
				echo "<a href=\"new_item.php?page=" . urlencode($sel_page['id']) . "\">+Add New Item to Page</a>";
			}
			
			else//nothing selected
			{
				echo "<h2>Select a subject or a page to edit</h2>"; 
			}
			?>
		</td>
	</tr>
</table>
<?php require("includes/footer.php")?>

