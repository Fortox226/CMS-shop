<?php
    $conn = mysqli_connect('localhost', 'root', '', 'CMS');
    if(!$conn)
    {
        exit("Błąd połączenia");
    }
    else
    {
        echo "Połączono poprawnie";
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