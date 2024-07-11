<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

// Query untuk mengambil informasi pengguna
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Handle pengembalian buku
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_book'])) {
    $transaction_id = $_POST['transaction_id'];

    // Update status transaksi menjadi 'returned'
    $update_transaction_sql = "UPDATE transactions SET status='returned' WHERE id='$transaction_id'";
    if ($conn->query($update_transaction_sql) === TRUE) {
        // Ambil ID buku yang dikembalikan
        $get_book_id_sql = "SELECT book_id FROM transactions WHERE id='$transaction_id'";
        $book_id_result = $conn->query($get_book_id_sql);
        if ($book_id_result->num_rows > 0) {
            $book_id_row = $book_id_result->fetch_assoc();
            $book_id = $book_id_row['book_id'];

            // Update status buku menjadi 'available'
            $update_book_sql = "UPDATE books SET status='available' WHERE id='$book_id'";
            if ($conn->query($update_book_sql) === TRUE) {
                // Redirect untuk memuat ulang halaman
                header("Location: profile.php");
                exit();
            } else {
                echo "Error updating book record: " . $conn->error;
            }
        } else {
            echo "Error fetching book ID: " . $conn->error;
        }
    } else {
        echo "Error updating transaction record: " . $conn->error;
    }
}

// Query untuk mengambil daftar buku yang dipinjam oleh pengguna
$sql_borrowed = "SELECT transactions.id AS transaction_id, books.id AS book_id, books.title, books.author, transactions.borrow_date, transactions.return_date 
        FROM transactions 
        JOIN books ON transactions.book_id = books.id 
        WHERE transactions.user_id='$user_id' AND transactions.status='borrowed'";
$result_borrowed = $conn->query($sql_borrowed);
$borrowed_books = [];

if ($result_borrowed->num_rows > 0) {
    while ($row = $result_borrowed->fetch_assoc()) {
        $borrowed_books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Library System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Welcome, <?= $user['name'] ?></h2>
        <p>NIM: <?= $user['nim'] ?></p>
        <h3>Borrowed Books</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowed_books as $book): ?>
                    <tr>
                        <td><?= $book['title'] ?></td>
                        <td><?= $book['author'] ?></td>
                        <td><?= $book['borrow_date'] ?></td>
                        <td><?= $book['return_date'] ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="transaction_id" value="<?= $book['transaction_id'] ?>">
                                <button type="submit" name="return_book" class="btn btn-primary">Return</button>
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
