<?php
$db = @mysql_connect("localhost", "onemedpl_hcid", "219eastred")
		or die("Temporarily unable to connect with the database."); 
mysql_select_db("onemedpl_HCIDS",$db); 
?>