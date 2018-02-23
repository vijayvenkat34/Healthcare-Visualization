<?php

$servername = "localhost";
$username = "vmware";
$password = "cloudera";

// Create connection
$conn =  mysql_connect($servername, $username, $password);
// Check connection
if (!$conn) {
    die('Connection failed: ' . mysql_error());
}
