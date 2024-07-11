<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_book'])) {
    $transaction_id = $_POST['transaction_id'];
    $return_date = date('Y-m-d');

    // Update status transaksi menjadi 'returned'
    $sql_update_transaction = "UPDATE transactions SET return_date='$return_date', status='returned' WHERE id='$transaction_id'";
    if ($conn->query($sql_update_transaction) === TRUE) {
        // Ambil ID buku dari transaksi
        $sql_get_book_id = "SELECT book_id FROM transactions WHERE id='$transaction_id'";
        $result_get_book_id = $conn->query($sql_get_book_id);
        $row = $result_get_book_id->fetch_assoc();
        $book_id = $row['book_id'];

        // Update status buku menjadi 'available'
        $sql_update_book_status = "UPDATE books SET status='available' WHERE id='$book_id'";
        if ($conn->query($sql_update_book_status) === TRUE) {
            $success_message = "Book returned successfully.";
        } else {
            $error_message = "Error updating book status: " . $conn->error;
        }
    } else {
        $error_message = "Error updating transaction status: " . $conn->error;
    }
}

$user_id = $_SESSION['user']['id'];

// Query untuk mengambil informasi pengguna
$sql_user = "SELECT * FROM users WHERE id='$user_id'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();

// Query untuk mengambil daftar buku yang dipinjam oleh pengguna
$sql_borrowed = "SELECT transactions.id AS transaction_id, books.title, books.author, transactions.borrow_date, transactions.return_date, transactions.status 
                FROM transactions 
                JOIN books ON transactions.book_id = books.id 
                WHERE transactions.user_id='$user_id' AND transactions.status IN ('borrowed', 'returned')";
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
    <title>Member Status</title>
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
                        <a class="nav-link" href="transactions.php">Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Member Status</h2>
        <h3>Welcome, <?= $user['name'] ?></h3>

        <h4>Borrowed Books:</h4>
        <?php if (empty($borrowed_books)): ?>
            <p>No books borrowed yet.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
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
                            <td><?= $book['status'] ?></td>
                            <td>
                                <?php if ($book['status'] === 'borrowed'): ?>
                                    <form method="post" action="status_member.php">
                                        <input type="hidden" name="transaction_id" value="<?= $book['transaction_id'] ?>">
                                        <button type="submit" name="return_book" class="btn btn-sm btn-primary">Return</button>
                                    </form>
                                <?php else: ?>
                                    Returned
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
