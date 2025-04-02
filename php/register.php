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
    <div class="box">
    <div class="img">
            <img src="../assets/cms.png" alt="" width=90px>
        </div>
        <div class="login">
    <form action="register.php" method="POST">
        <label for="username">Nazwa użytkownika:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Hasło:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Potwierdź hasło:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <button type="submit">Zarejestruj się</button>
    </form>

    <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
</div>

</div>
</main>
</body>
</html>