<?php
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function register_user($nim, $name, $password, $role, $conn) {
    $nim = sanitize_input($nim);
    $name = sanitize_input($name);
    $password = password_hash(sanitize_input($password), PASSWORD_BCRYPT);
    $role = sanitize_input($role);

    $sql = "INSERT INTO users (nim, name, password, role) VALUES ('$nim', '$name', '$password', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

function login_user($nim, $password, $conn) {
    $nim = sanitize_input($nim);
    $password = sanitize_input($password);

    $sql = "SELECT * FROM users WHERE nim='$nim'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            return $row;
        } else {
            return "Invalid password.";
        }
    } else {
        return "No user found with that NIM.";
    }
}

function check_admin($nim, $conn) {
    $nim = sanitize_input($nim);
    $sql = "SELECT role FROM users WHERE nim='$nim'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['role'] == 'admin';
    } else {
        return false;
    }
}
?>
