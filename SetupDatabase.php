<?php

//Creating variables for database connection
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE notes";

$result = mysqli_query($conn, $sql);
if ($conn) {
    echo "Database created successfully";
    $database = "notes";
    $conn = mysqli_connect($servername, $username, $password, $database);
} else {
    echo "Error creating database: " . $conn->error;
}

echo "<br>";

// sql to create table
$sql = "CREATE TABLE notes (
    sno INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL, 
    description TEXT(300) NOT NULL,
    tstamp DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

$result = mysqli_query($conn, $sql);

if($result) {
    echo "Table notes created successfully";
} 
else {
    echo "Error creating table: " . mysqli_connect_error();
}

$conn->close();
?>

<!-- INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES ('1', 'Harry', 'Hey, Harry Go to buy fruits.', current_timestamp()); -->
<!-- INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Buy Books', 'Please buy books from the store.', current_timestamp()); -->