<?php
session_start();
require_once 'db_connect.php';

$registration_error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
	$address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // --- Validation (add more as needed) ---
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $registration_error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $registration_error = "Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $registration_error = "Invalid email format.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT customer_id FROM Customers WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $registration_error = "Email already registered.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the SQL query to insert the new user
            $stmt = $pdo->prepare("INSERT INTO Customers (first_name, last_name, email, phone,address, password) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$first_name, $last_name, $email, $phone,$address, $hashed_password]);
            if ($result) {
                // Registration successful, you can redirect to login or auto-login
                header('Location: login.php'); // Or auto-login and redirect to index.php
                exit;
            }
             else {
                $registration_error = "Error registering user. Please try again.";
				error_log("Database error: " . $stmt->errorInfo()[2]);

            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css"> </head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <?php if ($registration_error): ?>
            <p class="error-message"><?php echo htmlspecialchars($registration_error); ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone">
            </div>
			<div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        		 <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>