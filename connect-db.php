<?php

$host = 'localhost';
$user = 'root';
$pass = '123456';
$dbname = 'records';

$mysqli = new mysqli($host, $user, $pass, $dbname);
mysqli_report(MYSQLI_REPORT_ERROR);

?>