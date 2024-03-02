<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data from the database
    $query = "SELECT users.id, username, password, role_id, roles.name as role_name FROM users JOIN roles ON users.role_id = roles.id WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            // Start a session and store user information
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role_name'];

            // Redirect based on user role
            if ($_SESSION['role'] == 'admin') {
                header('Location: admin_profile.php');
            } else {
                header('Location: user_profile.php');
            }
            exit();
        }
    }

    // Redirect to login page if login fails
    header('Location: login.html');
    exit();
}
?>
