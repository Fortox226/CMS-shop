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
        <div class="header-background">  
            <div class="header-bar">
                <div class="title">
                    <h1>CMS Articles</h1>
                </div>
                 <?php
                     if (isset($_SESSION['user_id'])) {
                        //  echo "<div class=\"user\">";
                        //  echo "<h1>Witaj, " . htmlspecialchars($_SESSION['username']) . "!</h1>";
                        //  echo "</div>";
                     
                         if ($_SESSION['role'] == 'admin') {
                             echo "<div class=\"edit\"><a href='edit.php'>Edit Panel</a></div><div class='admin'><a href='admin.php'>Admin panel</a></div>";
                         } elseif ($_SESSION['role'] == 'editor') {
                             echo "<div class=\"edit\"><a href='edit.php'>Edit Panel</a></div>";
                         } else {
                             echo "<div class\"edit\></div>";
                         }
                         echo '<div class="logout"><p><a href="logout.php">Logout</a></p></div>';
                     } else {
                         echo "<div class=\"user\">";
                         echo "<h1>Witaj na stronie!</h1>";
                         echo "</div>";
                         echo "<div class=\"logout\"><p><a href='login.php'>Log in</a></p></div>";
                     }
                 ?>
            </div>
            <div class="header-container" style="display:flex;justify-content:left; padding: 40px; box-sizing: border-box;">

                <div class="header-content">
                    <span>
                        <h2>Our blog</h2>
                    </span>
                    <div class="content-content">
                        <h1>Lorem ipsum dolor sit amet</h1>
                    </div>
                    <div class="small-text">
                        <h2>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Error qui voluptas repudiandae recusandae obcaecati nemo consequuntur!</h2>
                    </div>
                </div>
            </div>
            </div>
            
        </header>
    <main>
        <div class="latest">
            <h1>Latest Articles</h1>
        </div>
        <?php
           $sql = "SELECT id_article, title, content, header_image, date FROM article ORDER BY date DESC";
           $result = $conn->query($sql);
           
           if ($result->num_rows > 0) {
               while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                   echo "<div class='article'>";
                   echo "<div class='article-image'>";
                   echo "<img src=\"" .  htmlspecialchars($row['header_image']) . "\" alt=\"" . htmlspecialchars($row['title']) . "\"/>";
                   echo "</div>";
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