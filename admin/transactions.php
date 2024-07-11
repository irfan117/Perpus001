<?php
// Sesuaikan dengan session start dan validasi role jika diperlukan
session_start();
require_once '../includes/db.php';

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

// Ambil data transaksi dari database
$sql = "SELECT transactions.*, users.name, books.title 
        FROM transactions 
        JOIN users ON transactions.user_id = users.id 
        JOIN books ON transactions.book_id = books.id 
        ORDER BY transactions.borrow_date DESC";
$result = $conn->query($sql);
$transactions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

// Handle konfirmasi pengembalian buku
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_return'])) {
    $transaction_id = $_POST['transaction_id'];
    $return_date = date('Y-m-d');

    $updateSql = "UPDATE transactions SET return_date='$return_date', status='Returned' WHERE id='$transaction_id'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Pengembalian buku berhasil dikonfirmasi.'); window.location='transactions.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Admin</title>
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
                    <li class="nav-item">
                        <a class="nav-link" href="manage_members.php">Manage Members</a>
                    </li>
                    <li class="nav-item active">
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
        <h1>Transactions</h1>
        <!-- Tabel untuk menampilkan daftar transaksi -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Book</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?= $transaction['id'] ?></td>
                        <td><?= $transaction['name'] ?></td>
                        <td><?= $transaction['title'] ?></td>
                        <td><?= $transaction['borrow_date'] ?></td>
                        <td><?= $transaction['return_date'] ?></td>
                        <td><?= $transaction['status'] ?></td>
                        <td>
                            <?php if ($transaction['status'] === 'Borrowed'): ?>
                                <form action="" method="post">
                                    <input type="hidden" name="transaction_id" value="<?= $transaction['id'] ?>">
                                    <button type="submit" class="btn btn-success btn-sm" name="confirm_return">Confirm Return</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
