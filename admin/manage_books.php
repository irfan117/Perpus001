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

// Verifikasi bahwa pengguna memiliki role admin
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php"); // atau halaman lain yang sesuai untuk user biasa
    exit();
}

// Ambil data buku dari database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        /* Custom CSS styles */
    </style>
</head>
<body>
    <!-- Navigation -->
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
                <li class="nav-item active">
                    <a class="nav-link" href="manage_books.php">Manage Books</a>
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
    <div class="row">
        <div class="col">
            <h1>Manage Books</h1>
        </div>
        <div class="col text-right">
            <a href="add_book.php" class="btn btn-primary">Add Book</a>
        </div>
    </div>

    <!-- Daftar buku -->
    <div class="card mt-3">
        <div class="card-body">
            <!-- Tabel untuk menampilkan daftar buku -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Rack</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Isi tabel dengan data buku -->
                    <!-- PHP Loop untuk menampilkan data buku dari database -->
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= $book['id'] ?></td>
                            <td><?= $book['title'] ?></td>
                            <td><?= $book['description'] ?></td>
                            <td><?= $book['rack'] ?></td>
                            <td>
                                <!-- Tambahkan tombol Edit dan Delete jika perlu -->
                                <a href="edit_book.php?id=<?= $book['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="delete_book.php?id=<?= $book['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
