<?php
require 'dbconnect.php';
$parameter = [];

mysql_select_db("frontend", $conn);

$sql = "select distinct(parameter) from $domain";
$result = mysql_query($sql);
			
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
	$parameterArray[$i] = $row['parameter'];
	$i++;
}
?>
