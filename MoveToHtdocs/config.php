<!-- This file is used for connecting to database! -->
<?php
  $host = "localhost";  //IP Address
  $username = "root"; // Your Username
  $password = ""; //Your Password
  $port = "3306"; //Port Number: Defualt is 3306
  $dbname = "Pandemic"; //The database name if you did not use Pandemic

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
