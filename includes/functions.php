<?php  	
	function mysql_prep($value)
	{
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists("mysql_real_escape_string");//i.e. PHP >= v4.3.0
		if($new_enough_php)// PHP v4.3.0 or higher
			//undo any magic quote effects so mysql_real_escape_string can do the work
		{
			if($magic_quotes_active)
			{
				$value = stripslashes($value);
			}
			$value = mysql_real_escape_string($value);
		}
			else// before PHP v4.3.0
			{
				//if magic quotes aren't already on, then add slashes manually
				if(!$magic_quotes_active)
				{
					$value = addslashes($value);
				}
				//if magic quotes are active, then the slashes already exist
			}
			return $value;
	}
	
	function redirect_to($location = NULL)
	{
		if($location != NULL)
		{
			header("Location:{$location}");
			exit;
		}
	}	
	
	function confirm_query($result_set)
	{
		if(!$result_set)
		{
			die("Database query falied: " . mysql_error());
		}	
	}
	
	function get_all_subjects($public)
	{
		global $connection;
		$query = "SELECT * "; 
		$query .= "FROM subjects ";
		if($public){
			$query .= "WHERE visible = 1 ";			
		}
		$query .= "ORDER BY position ASC";
		$subject_set = mysql_query($query, $connection);
		confirm_query($subject_set);
		return $subject_set;
	}
	
	function get_all_pages()
	{
		global $connection;
		$query = "SELECT * 
					FROM pages 
					ORDER BY position ASC";
		$page_set = mysql_query($query, $connection);
		confirm_query($page_set);
		return $page_set;
	}
	
	function get_all_items()
	{
		global $connection;
		$query = "SELECT * 
					FROM items 
					ORDER BY position ASC";
		$item_set = mysql_query($query, $connection);
		confirm_query($item_set);
		return $item_set;
	}	
	
	function get_pages_for_subject($subject_id)
	{
		global $connection;
		$query = "SELECT * 
					FROM pages  
					WHERE subj_id = {$subject_id}
					ORDER BY position ASC";
		$page_set = mysql_query($query, $connection);		
		confirm_query($page_set);
		return $page_set;
	}
	
	function get_items_for_page($page_id, $public=false)
	{
		
		global $connection;
			$query = 	"SELECT * "; 
			$query .=	"FROM items " ;
			$query .=	"WHERE page_id = {$page_id} ";
		if($public == true)
		{
			$query .=	"AND visible = 1 ";
		}
			$query .=	"ORDER BY position ASC";
		$item_set = mysql_query($query, $connection);		
		confirm_query($item_set);
		return $item_set;
	}
	
	function get_subject_by_id($subject_id)
	{
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id=" . $subject_id ." ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		//REMEMBER:if no rows are returned, fetch_array will return false
		if($subject = mysql_fetch_array($result_set))
		{
			return $subject;
		}
		else
		{
			return NULL;
		}
	}
	
	function get_page_by_id($page_id)
	{
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id=". $page_id . " ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		//REMEMBER:if no rows are returned, fetch_array will return false
		if($page = mysql_fetch_array($result_set))
		{
			return $page;
		}
		else
		{
			return NULL;
		}
	}
	
	function get_item_by_id($item_id)
	{
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM items ";
		$query .= "WHERE id=". $item_id . " ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		//REMEMBER:if no rows are returned, fetch_array will return false
		if($item = mysql_fetch_array($result_set))
		{
			return $item;
		}
		else
		{
			return NULL;
		}
	}
	
	function find_selected_page() 
	{		
		global $sel_subject;
		global $sel_page;
		global $sel_item;
		
		if(isset($_GET['subj']))
		{
			$sel_subject = get_subject_by_id($_GET['subj']);
			$sel_page = NULL;
			$sel_item = NULL;
		}
	
		elseif(isset($_GET['page']))
		{
			$sel_subject = NULL;
			$sel_page = get_page_by_id($_GET['page']);
			$sel_item = NULL;
		}
		elseif(isset($_GET['item']))
		{
			$sel_subject = NULL;
			$sel_page = NULL;
			$sel_item = get_item_by_id($_GET['item']);
		}
		
		else
		{		
			$sel_subject = NULL;
			$sel_page = NULL;
			$sel_item = NULL;
		}
	}
	
	function navigation($sel_subject, $sel_page, $public = false)
	{
	$output = "<ul class=\"subjects\">";
			
			
			$subject_set = get_all_subjects($public=false);
								
			while($subject = mysql_fetch_array($subject_set))
			{
						
				$output .= "<li";
				if($subject["id"] == $sel_subject["id"])
				{
					$output .= " class=\"selected\"";
				}				
				$output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
				$page_set = get_pages_for_subject($subject["id"], $public);
				$output .= "<ul class=\"pages\">";
				
				while($page = mysql_fetch_array($page_set))
				{
					$output .= "<li";
					if($page["id"] == $sel_page["id"])
					{
						$output .= " class=\"selected\"";
					}
					$output .= "><a href=\"content.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</a></li>";
				
				}
				$output .= "</ul>";
			}
			
	$output .= "</ul><br>";	
	$output .=	"<a href=\"new_subject.php\">+ Add a new subject</a>";
	$output .= "<br><br>";
	$output .= "<a href=\"staff.php\">Staff Menu</a>";
	return $output;
	}			

	
	function public_navigation($sel_subject, $sel_page, $public = true)
	{
	$output = "<ul class=\"subjects\">";
			
			
			$subject_set = get_all_subjects($public=true);
								
			while($subject = mysql_fetch_array($subject_set))
			{
						
				$output .= "<li";
				if($subject["id"] == $sel_subject["id"])
				{
					$output .= " class=\"selected\"";
				}				
				$output .= "><a href=\"index.php?subj=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
				if($subject["id"] == $sel_subject["id"])
				{
					$page_set = get_pages_for_subject($subject["id"], $public);
					$output .= "<ul class=\"pages\">";
				
					while($page = mysql_fetch_array($page_set))
					{
						$output .= "<li";
						if($page["id"] == $sel_page["id"])
						{
							$output .= " class=\"selected\"";
						}
						$output .= "><a href=\"index.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</a></li>";
				
					}
					$output .= "</ul>";
				}
			}
			
	$output .= "</ul>";
	$output .= "<br><br>";
	$output .= "<a href=\"log_in.php\">Log In</a>";
	return $output;
	}
?>
