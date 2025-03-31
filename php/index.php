<?php
session_start();

if (isset($_SESSION['user_id'])) {
    echo "<h1>Witaj, " . htmlspecialchars($_SESSION['username']) . "!</h1>";

    if ($_SESSION['role'] == 'admin') {
        echo "<p>Jesteś administratorem. Możesz zarządzać użytkownikami.</p>";
    } elseif ($_SESSION['role'] == 'editor') {
        echo "<p>Jesteś edytorem. Możesz dodawać i edytować artykuły.</p>";
    } else {
        echo "<p>Jesteś zwykłym użytkownikiem. Możesz przeglądać artykuły.</p>";
    }

    echo '<p><a href="logout.php">Wyloguj się</a></p>';
} else {
    echo "<h1>Witaj na stronie!</h1>";
    echo "<p>Proszę się <a href='login.php'>zalogować</a> lub <a href='register.php'>zarejestrować</a>.</p>";
}

$conn = mysqli_connect('localhost', 'root', '', 'CMS');
if(!$conn)
{
    exit("Błąd połączenia");
}
$conn->set_charset("utf8mb4");

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cms user page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>CMS</h1>
    </header>
    <main>
        <?php
           $sql = "SELECT id_article, title, content, date FROM article ORDER BY date DESC";
           $result = $conn->query($sql);
           
           if ($result->num_rows > 0) {
               while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                   echo "<div class='article'>";
                   echo "<h2>" . htmlspecialchars($row['title']) . "</h2>"; 
                   echo "<p><strong>Data publikacji: </strong>" . date('d-m-Y', strtotime($row['date'])) . "</p>"; 
                   echo "<div class='content'>" . nl2br(htmlspecialchars($row['content'])) . "</div>"; 
                   echo "</div><hr>";
               }
           } else {
               echo "Brak artykułów w bazie danych.";
           }
           
           $conn->close();
        ?>
    </main>
</body>
</html>