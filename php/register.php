<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'], $_POST['confirm_password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password === $confirm_password) {
            include 'config.php';

            if ($conn->connect_error) {
                die('Connection failed: ' .$conn->connect_error);
            }

            $sql = "SELECT id FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0) {
                echo "Użytkownik o tej nazwie już istnieje.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $username, $hashed_password);
                $stmt->execute();
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Hasła się nie zgadzają.";
        }
    } else {
        echo "Wszystkie pola są wymagane.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="../css/stylel.css">
</head>
<body>
    <main>
        <div class="wrapper">
            <form action="register.php" method="POST">
                <h1>Register</h1>
                <div class="input-box">
                    <input type="text" id="username" name="username"
                     placeholder="Username" required>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password"
                     placeholder="Password" required>
                </div>
                <div class="input-box">
                    <input type="password" id="confirm_password" name="confirm_password"
                     placeholder="Repeat password" required>
                </div>

                <button type="submit" class="btn">Register</button>

                <div class="register-link">
                    <p>Already have account? <a href="login.php">Log in </a></p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>