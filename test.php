<?php

$servername = "localhost";
$username = "cevicher_richard";
$password = "vmf-1w~MY#U@";
$dbname = "cevicher_richardsbd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/*
$encriptedPassword = password_hash('motorizado7', PASSWORD_DEFAULT, ['cost' => 10]);

$sql = "INSERT INTO admin (correo, password)
VALUES ('motorizado7@cevicheriarichards.com', '$encriptedPassword')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
