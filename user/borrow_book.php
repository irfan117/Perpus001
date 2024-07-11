<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

// Ambil daftar buku yang tersedia untuk dipinjam
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Handle peminjaman buku
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $book_id = $_POST['book_id'];
    $borrow_date = date('Y-m-d');
    $return_date = date('Y-m-d', strtotime('+7 days')); // Contoh: peminjaman selama 7 hari

    // Periksa apakah buku sudah dipinjam oleh pengguna
    $checkSql = "SELECT * FROM transactions WHERE user_id='$user_id' AND book_id='$book_id' AND return_date IS NULL";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Anda sudah meminjam buku ini.');</script>";
    } else {
        // Lakukan peminjaman buku
        $insertSql = "INSERT INTO transactions (user_id, book_id, borrow_date, return_date) VALUES ('$user_id', '$book_id', '$borrow_date', '$return_date')";
        if ($conn->query($insertSql) === TRUE) {
            echo "<script>alert('Peminjaman buku berhasil.'); window.location='profile.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Book</title>
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
        <h2>Borrow Book</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <th scope="row"><?= $book['id'] ?></th>
                        <td><?= $book['title'] ?></td>
                        <td><?= $book['author'] ?></td>
                        <td>
                            <form method="post" action="borrow_book.php">
                                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                <button type="submit" name="borrow" class="btn btn-primary">Borrow</button>
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
