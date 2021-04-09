<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cp476_TP";


$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
else echo "Connected successfully";



//  creare a database
$sql = "CREATE DATABASE IF NOT EXISTS".$dbname;
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error: " . $conn->error;
}

// create a table

$sql = "CREATE TABLE IF NOT EXISTS users (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    username char(50), 
    password char(50)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table created successfully";
} else {
  echo "Error: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS chats (
    chatid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT
)";
if ($conn->query($sql) === TRUE) {
  echo "Table created successfully";
} else {
  echo "Error: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS messages (
    messageid INT AUTO_INCREMENT PRIMARY KEY,
    chatid INT
    message char(250)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table created successfully";
} else {
  echo "Error: " . $conn->error;
}


$conn->close();

?>