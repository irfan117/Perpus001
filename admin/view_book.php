<?php
// Sesuaikan dengan session start dan validasi role jika diperlukan
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Verifikasi bahwa pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data buku berdasarkan ID yang diberikan
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $sql = "SELECT * FROM books WHERE id = $book_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        header("Location: manage_books.php"); // Redirect jika buku tidak ditemukan
        exit();
    }
} else {
    header("Location: manage_books.php"); // Redirect jika parameter ID buku tidak ada
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book - Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        /* Custom CSS styles */
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Library Admin</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="manage_books.php">Manage Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_members.php">Manage Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transactions.php">Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="container mt-4">
        <h1>View Book</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $book['title'] ?></h5>
                <p class="card-text"><strong>Description:</strong> <?= $book['description'] ?></p>
                <p class="card-text"><strong>Rack:</strong> <?= $book['rack'] ?></p>
                <a href="manage_books.php" class="btn btn-primary">Back to Manage Books</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
