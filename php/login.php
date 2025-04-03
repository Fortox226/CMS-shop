<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        include 'config.php';

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
    <link rel="stylesheet" href="../css/stylel.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <main>
        <div class="wrapper">
            <form action="login.php" method="POST">
                <h1>Zaloguj się</h1>
                <div class="input-box">
                    <input type="text" id="username" name="username"
                     placeholder="Nazwa użytkownika" required>
                    <i class="bx bxs-user"></i>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password"
                     placeholder="Hasło" required>
                    <i class="bx bxs-lock-alt"></i>
                </div>

                <button type="submit" class="btn">Zaloguj się</button>

                <div class="register-link">
                    <p>Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>