<?php //this page is included by new_item.php and edit_item.php?>
<?php if (!isset($new_item)){$new_item = false;}?>
	<div><label for="item_name">Item Name:</label><input name="menu_name" type="text" id="menu_name" size="30" value="<?php echo $sel_item['menu_name'];?>" /></div>
	<div><label for="position">Position:</label><select name="position" id="position">
		<?php
		if(!$new_item)//edit item, only show positions already entered
		{
			$item_set = get_items_for_page($sel_item['page_id']);
			$item_count = mysql_num_rows($item_set);
			
		}	
		else //new item, show positions entered + 1
		{
			$item_set = get_items_for_page($sel_page['id']);
			$item_count = mysql_num_rows($item_set) + 1;		
		}
		for($count=1; $count <= $item_count; $count++)
			{
				echo "<option value=\"{$count}\"";
				if($sel_item['position'] == $count)
				{
					echo " selected";
				}
				echo ">{$count}</option>";
			}
		?>		
		</select></div>
	<div><label for="visible">Visible:</label>
		<input type="radio" name="visible" id="visible" value="0"
		<?php
		if($sel_item['visible']==0)
		{
			echo " checked";
		}
		?>/>No
		<input type="radio" name="visible" value="1"
		<?php 
		if($sel_item['visible']==1)
		{
			echo " checked";
		}
		?>/>Yes
	</div>
	<div><label for="description">Description:</label>
	<textarea name="description" id="description" rows="2" cols="80"><?php echo $sel_item['description'];?></textarea></div>
	<div><label for="price">Price:</label><input type="text" name="price" value="<?php echo $sel_item['price'];?>" id="price" /></div>
	<div><label for="image">Image:</label><input type="text" name="image" value="<?php echo $sel_item['image'];?>" id="image" /></div>
