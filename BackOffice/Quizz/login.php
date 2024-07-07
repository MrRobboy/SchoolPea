<?php
// login.php
session_start();

$dsn = 'mysql:host=localhost;dbname=PA';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id_USER, pass FROM USER WHERE email = :email";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['pass'])) {
        $_SESSION['user_id'] = $user['id_USER']; // Set session variable upon successful login
        $redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php';
        unset($_SESSION['redirect_url']); // Clear the redirect URL after using it
        header("Location: $redirectUrl");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
