<!-- This file is used for connecting to database! -->
<?php
  $host = "localhost";
  $username = "root";
  $password = "adminData";
  $port = "3307";
  $dbname = "Pandemic";

// Connection
  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>
