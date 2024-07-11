<?php
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

// Ambil ID buku dari parameter GET
if (!isset($_GET['id'])) {
    header("Location: manage_books.php");
    exit();
}

$book_id = $_GET['id'];

// Query untuk mengambil informasi buku berdasarkan ID
$sql_book = "SELECT * FROM books WHERE id = '$book_id'";
$result_book = $conn->query($sql_book);

if ($result_book->num_rows > 0) {
    $book = $result_book->fetch_assoc();
} else {
    // Redirect jika ID buku tidak ditemukan
    header("Location: manage_books.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $rack = $_POST['rack'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = '../book_images/' . $image;

    if (!empty($image)) {
        if (move_uploaded_file($image_tmp, $image_folder)) {
            $sql = "UPDATE books SET title='$title', author='$author', year='$year', rack='$rack', description='$description', image='$image' WHERE id='$id'";
        } else {
            $edit_error = "Failed to upload image.";
        }
    } else {
        $sql = "UPDATE books SET title='$title', author='$author', year='$year', rack='$rack', description='$description' WHERE id='$id'";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_books.php");
        exit();
    } else {
        $edit_error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
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

<div class="container mt-5">
    <h2>Edit Book</h2>
    <?php if (isset($edit_error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $edit_error ?>
        </div>
    <?php endif; ?>
    <form method="post" action="edit_book.php?id=<?= $book['id'] ?>" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $book['title'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="<?= $book['author'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="text" class="form-control" id="year" name="year" value="<?= $book['year'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="rack" class="form-label">Rack</label>
            <input type="text" class="form-control" id="rack" name="rack" value="<?= $book['rack'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= $book['description'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Book Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <img src="../book_images/<?= $book['image'] ?>" alt="<?= $book['title'] ?>" class="mt-2" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
