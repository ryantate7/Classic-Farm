<?php 
require("constants.php");

//Create a DB Connection 
$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if(!$connection)
{
  die("Database connection falied: " . mysql_error());
}
	
//Select the database to use
$db_select = mysql_select_db(DB_NAME,$connection);
if(!$db_select)
{
	die("Database selection falied: " . mysql_error());
}
?>
