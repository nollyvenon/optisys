<?php
include_once('connvar.php');
  $q=addslashes($_GET["q"]);

	$sql1=mysql_query("SELECT * FROM stocks WHERE itemid = \"$q\"");
		while($fet=mysql_fetch_array($sql1)){
		$Cost_Price=$fet['Cost_Price'];
		echo "<input type=\"text\" class=\"validate[required]\" value=\"$Cost_Price\" name=\"price\" id=\"price\"/>";
		}

//echo $q;
?> 