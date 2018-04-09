<?php
$hostname_conn = "localhost";
$database_conn = "optisys";
$username_conn = "root";
$password_conn = "";
$db = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db('optisys');
?>