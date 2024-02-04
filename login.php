<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['username'] = $username;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<h2>Login</h2>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
