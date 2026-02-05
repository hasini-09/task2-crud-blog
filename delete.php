<?php
session_start();
include "db.php";

// Check login
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Check if id exists
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM posts WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: index.php");
}
?>
