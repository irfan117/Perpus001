<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM books WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $user_id = $_SESSION['user']['id'];
    $sql = "INSERT INTO transactions (user_id, book_id, borrow_date) VALUES ('$user_id', '$id', NOW())";
    if ($conn->query($sql) === TRUE) {
        echo "Book borrowed successfully!";
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
    <title>Book Details</title>
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
                        <a class="nav-link" href="transactions.php">My Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Book Details</h2>
        <div class="card mb-3">
            <img src="book_images/<?= $book['image'] ?>" class="card-img-top" alt="<?= $book['title'] ?>">
            <div class="card-body">
                <h5 class="card-title"><?= $book['title'] ?></h5>
                <p class="card-text"><strong>Author:</strong> <?= $book['author'] ?></p>
                <p class="card-text"><strong>Year:</strong> <?= $book['year'] ?></p>
                <p class="card-text"><strong>Rack:</strong> <?= $book['rack'] ?></p>
                <p class="card-text"><strong>Description:</strong> <?= $book['description'] ?></p>
                <form method="post" action="view_book.php?id=<?= $book['id'] ?>">
                    <button type="submit" name="borrow" class="btn btn-primary">Borrow</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
