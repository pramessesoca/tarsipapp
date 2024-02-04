<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Enkripsi password dengan bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO user (username, password_hash) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            $error = "Error during registration";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<h2>Register</h2>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br>
    <input type="submit" value="Register">
</form>

</body>
</html>
