<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM books WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_books.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: manage_books.php");
    exit();
}
?>
