<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $conn = new mysqli('localhost', 'root', '', 'CMS');

        if ($conn->connect_error) {
            die('Connection failed: ' .$conn->connect_error);
        }

        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $db_username, $db_password, $role);
            $stmt->fetch();

            if (password_verify($password, $db_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $db_username;
                $_SESSION['role'] = $role;

                echo "Zalogowano pomyślnie!";
                header('Location: index.php');
                exit();
            } else {
                echo "Niepoprawne hasło";
            }
        } else {
            echo "Użytkownik o tej nazwie nie istnieje.";
        }

        $stmt->close();
        $conn->close();
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
    <title>Logowanie</title>
</head>
<body>
    <h1>Logowanie</h1>
    <form action="login.php" method="POST">
        <label for="username">Nazwa użytkownika:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Hasło:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Zaloguj się</button>
    </form>

    <p>Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
</body>
</html>