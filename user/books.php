<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Query untuk mengambil daftar buku dari database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
$books = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Fungsi untuk meminjam buku
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $user_id = $_SESSION['user']['id'];

    // Cek status buku
    $sql = "SELECT status FROM books WHERE id='$book_id'";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();

    if ($book['status'] === 'available') {
        $borrow_date = date('Y-m-d');
        $return_date = date('Y-m-d', strtotime('+7 days'));

        // Simpan transaksi peminjaman
        $sql = "INSERT INTO transactions (user_id, book_id, borrow_date, return_date, status) 
                VALUES ('$user_id', '$book_id', '$borrow_date', '$return_date', 'borrowed')";

        if ($conn->query($sql) === TRUE) {
            // Update status buku menjadi dipinjam
            $sql_update = "UPDATE books SET status='borrowed' WHERE id='$book_id'";
            if ($conn->query($sql_update) === TRUE) {
                $success_message = "Book borrowed successfully.";
            } else {
                $error_message = "Error updating book status: " . $conn->error;
            }
        } else {
            $error_message = "Error borrowing book: " . $conn->error;
        }
    } else {
        $error_message = "The book is already borrowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .card {
            height: 100%;
            display: flex;
            flex-direction: column; /* Tampilkan gambar di atas */
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .book-card {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
        }
        .book-image-frame {
            width: 100%; /* Lebar frame buku */
            height: 300px; /* Tinggi frame buku */
            overflow: hidden; /* Hindari gambar yang terlalu besar */
            border-radius: 10px; /* Sudut bulat pada gambar */
            margin-bottom: 10px; /* Spasi bawah antara setiap card */
        }
        .book-image {
            width: auto; /* Biarkan gambar menyesuaikan tinggi frame */
            height: 100%; /* Gambar penuh tinggi frame */
            object-fit: cover; /* Memastikan gambar memenuhi frame */
            transform: rotate(0deg); /* Reset rotasi */
            transition: transform 0.3s ease-in-out; /* Animasi transisi */
        }
        .book-card:hover .book-image {
            transform: rotate(5deg); /* Efek miring saat hover */
        }
    </style>
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
                        <a class="nav-link active" href="books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="return_book.php">Return Book</a>
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
        <h2>Books List</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?= $success_message ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="book-card">
                            <div class="book-image-frame">
                                <img src="../book_images/<?= $book['image'] ?>" class="book-image img-fluid" alt="<?= $book['title'] ?>">
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $book['title'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= $book['author'] ?></h6>
                            <p class="card-text"><strong>Rack:</strong> <?= $book['rack'] ?></p>
                            <p class="card-text"><strong>Status:</strong> <?= $book['status'] === 'available' ? 'Available' : 'Not Available' ?></p>
                            <?php if ($book['status'] === 'available'): ?>
                                <form method="post" action="books.php">
                                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">Borrow</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>Borrowed</button>
                            <?php endif; ?>
                            <a href="view_book.php?id=<?= $book['id'] ?>" class="btn btn-info btn-sm">View</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
