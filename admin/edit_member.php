<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Memastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil NIM anggota dari parameter GET
if (!isset($_GET['nim'])) {
    header("Location: manage_members.php");
    exit();
}

$member_nim = $_GET['nim'];

// Query untuk mengambil informasi anggota berdasarkan NIM
$sql_member = "SELECT * FROM users WHERE nim = '$member_nim'";
$result_member = $conn->query($sql_member);

if ($result_member->num_rows > 0) {
    $member = $result_member->fetch_assoc();
} else {
    // Redirect jika NIM anggota tidak ditemukan
    header("Location: manage_members.php");
    exit();
}

// Update anggota jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $active = isset($_POST['active']) ? 1 : 0; // Checkbox untuk status aktif atau tidak

    $sql_update = "UPDATE users SET name='$name', active='$active' WHERE nim='$member_nim'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: manage_members.php");
        exit();
    } else {
        $edit_error = "Error: " . $sql_update . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>
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
                        <a class="nav-link" href="manage_books.php">Manage Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="manage_members.php">Manage Members</a>
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
        <h2>Edit Member</h2>
        <?php if (isset($edit_error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $edit_error ?>
            </div>
        <?php endif; ?>
        <form method="post" action="edit_member.php?nim=<?= $member['nim'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $member['name'] ?>" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" <?= $member['active'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="active">Active</label>
            </div>
            <button type="submit" class="btn btn-primary">Update Member</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
