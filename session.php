<?php
session_start();

$_SESSION['parameter'] = $_POST['formParameter'];
$_SESSION['type'] = $_POST['formType'];

//go back to statewise.php
//header('Location: statewise.php');
?>