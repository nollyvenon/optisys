<?php
include_once('connvar.php');
  $q=addslashes($_GET["q"]);

	$sql1=mysql_query("SELECT * FROM services WHERE ServiceID = \"$q\" order by ServiceID LIMIT 1");
		while($fet=mysql_fetch_array($sql1)){
		$Cost_Price=$fet['Price'];
		echo "<input type=\"text\" class=\"validate[required]\" value=\"$Cost_Price\" name=\"price\" id=\"price\"/>";
		}

//echo $q;
?> 