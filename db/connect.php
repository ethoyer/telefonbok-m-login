<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'telefonbok';

$db_server = new mysqli($host, $user, $pass, $db) or die("Could not connect!");
?>