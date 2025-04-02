<?php
session_start();



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
        <div class="image">
            <img src="../assets/cms.png" alt="" width="100px">
        </div>
<?php
    if (isset($_SESSION['user_id'])) {
        echo "<div class=\"user\">";
        echo "<h1>Witaj, " . htmlspecialchars($_SESSION['username']) . "!</h1>";
        echo "</div>";

        if ($_SESSION['role'] == 'admin') {
            echo "<div class=\"edit\"><a href='edit.php'>Edit Panel</a></div><div class='admin'><a href='admin.php'>Admin panel</a></div>";
        } elseif ($_SESSION['role'] == 'editor') {
            echo "<div class=\"edit\"><a href='edit.php'>Edit Panel</a></div>";
        } else {
            echo "<div class\"edit\></div>";
        }
        echo '<div class="logout"><p><a href="logout.php">Wyloguj się</a></p></div>';
    } else {
        echo "<div class=\"user\">";
        echo "<h1>Witaj na stronie!</h1>";
        echo "</div>";
        echo "<div class=\"logout\"><p><a href='login.php'>Zaloguj się</a></p></div>";
    }
?>
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