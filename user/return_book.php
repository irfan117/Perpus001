<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

// Ambil daftar buku yang sedang dipinjam oleh pengguna
$sql = "SELECT transactions.*, books.title, books.author 
        FROM transactions 
        JOIN books ON transactions.book_id = books.id 
        WHERE user_id='$user_id' AND return_date IS NULL";

$result = $conn->query($sql);
$transactions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

// Handle pengembalian buku
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return'])) {
    $transaction_id = $_POST['transaction_id'];
    $return_date = date('Y-m-d');

    $updateSql = "UPDATE transactions SET return_date='$return_date' WHERE id='$transaction_id'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Buku berhasil dikembalikan.'); window.location='profile.php';</script>";
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
    <title>Return Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Return Book</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Book Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Borrow Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <th scope="row"><?= $transaction['id'] ?></th>
                        <td><?= $transaction['title'] ?></td>
                        <td><?= $transaction['author'] ?></td>
                        <td><?= $transaction['borrow_date'] ?></td>
                        <td>
                            <form method="post" action="return_book.php">
                                <input type="hidden" name="transaction_id" value="<?= $transaction['id'] ?>">
                                <button type="submit" name="return" class="btn btn-primary">Return</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
