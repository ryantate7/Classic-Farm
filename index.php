<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php find_selected_page()//figure out what has been chosen;?>
<?php include("includes/header.php")?>
<table id="structure">
  <tr>
		<td id="navigation">		
		<?php echo public_navigation($sel_subject, $sel_page); ?>
		</td>
		<td id="page">
			<?php if(!is_null($sel_subject))//subject selected
			{
				echo "<h2>" . $sel_subject["menu_name"] . "</h2>";
			}
			elseif(!is_null($sel_page))//page selected
			{
				echo "<h2>{$sel_page["menu_name"]}</h2>";
				$item_set = get_items_for_page($sel_page["id"], $public=true);
				$item_count = mysql_num_rows($item_set);
				if($item_count > 0)//display items if there are any
				{
					echo "<table border=\"1\">";
					while($item = mysql_fetch_array($item_set))//list out items belonging to the selected page
					{
						echo "<tr>";
						echo "<td>" . $item['menu_name'] . "</td>";
						echo "<td>$" . $item['price'] . "</td>";
						echo "<td><img src=\"images/{$item['image']}\" alt=\"No Picture Available at this time.\" height=\"100\" width=\"200\"></td>";
						echo "<td>" . $item['description'] . "</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
				else//display page content if there aren't any items to display
				{
					echo "<p>{$sel_page["content"]}</p>";
				}
			}
			else//nothing selected
			{
				echo "<h2>Welcome to Classic Farm!</h2>";
				echo "<td><image src=\"images/ClassicFarmLogo.jpg\"align=\"left\"></td>";//move image over if nothing selected
			}
			?>
		</td>		
		<?php
		if(!is_null($sel_subject) || !is_null($sel_page))
		{
			echo "<td><image src=\"images/ClassicFarmLogo.jpg\" align=\"right\"></td>";//move image out of the way if something gets selected
		}
		?>
	</tr>
	
</table>
<?php require("includes/footer.php")?>
