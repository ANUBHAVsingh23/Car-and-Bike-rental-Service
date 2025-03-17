<?php
session_start(); // Start the session
require_once 'db_connect.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input (basic example, you should add more robust validation)
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Email and password are required.";
        header('Location: login.php');
        exit;
    }

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare("SELECT customer_id, email, password FROM Customers WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();


    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, set session variables
        $_SESSION['customer_id'] = $user['customer_id'];
        $_SESSION['email'] = $user['email'];

        // Redirect to a protected page (e.g., the home page)
        header('Location: index.php'); // Change 'index.php' to your desired page
        exit;
    } else {
        // Invalid credentials
        $_SESSION['login_error'] = "Invalid email or password.";
        header('Location: login.php');
        exit;
    }
} else {
    // If not a POST request, redirect to login page
    header('Location: login.php');
    exit;
}

?>