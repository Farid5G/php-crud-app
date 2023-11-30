<?php
require 'components/dbconnection.php';
$id = $_GET['title'];

// Retrieve the record from the database
$query = "SELECT * FROM notes WHERE ntitle = '$id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Display the edit form
    echo "<form >";
    echo "<label class = 'title' for='title'>Title:</label>";
    echo "<input id = 'title' type='text' name='name' value='" . $row['ntitle'] . "'><br>";
    echo "<label class = 'ip for='ip'>Email:</label>";
    echo "<input id = 'ip' type='text' name='email' value='" . $row['ndesc'] . "'><br>";
    echo "</form>";
} else {
    echo "Record not found.";
}     echo "hello".$conn. "how are you";
?>