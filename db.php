<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "php_co_ban";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
  } catch(PDOException $e) {    
    echo "Connection failed: " . $e->getMessage();
  }
  ?>


