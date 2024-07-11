<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$members = [];
$sql = "SELECT * FROM users WHERE role='user'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
}

// Menghapus anggota jika parameter nim terkirim melalui GET
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];
    $sql_delete = "DELETE FROM users WHERE nim='$nim'";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: manage_members.php");
        exit();
    } else {
        echo "Error deleting member: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
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
                        <a class="nav-link" href="manage_books.php">Manage Books</a>
                    </li>
                    <li class="nav-item active">
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
                <h1>Manage Members</h1>
            </div>
        </div>

        <!-- Daftar anggota -->
        <div class="card mt-3">
            <div class="card-body">
                <!-- Tabel untuk menampilkan daftar anggota -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Isi tabel dengan data anggota -->
                        <!-- PHP Loop untuk menampilkan data anggota dari database -->
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td><?= $member['nim'] ?></td>
                                <td><?= $member['name'] ?></td>
                                <td>
                                    <!-- Tambahkan tombol Edit, Status, dan Delete -->
                                    <a href="edit_member.php?nim=<?= $member['nim'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="status_member.php?nim=<?= $member['nim'] ?>" class="btn btn-sm btn-info">Status</a>
                                    <a href="manage_members.php?nim=<?= $member['nim'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this member?')">Delete</a>
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
