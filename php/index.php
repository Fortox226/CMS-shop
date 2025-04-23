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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
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
                    <div class="content-content">
                        <h1>Welcome to Our Article Hub!</h1>
                    </div>
                    <div class="small-text">
                        <h2>Discover a variety of engaging articles on topics ranging from technology to lifestyle. Stay informed with the latest trends and expert insights. Start reading now!</h2>
                    </div>
                </div>
            </div>
            </div>
            
        </header>
    <main>
        <div class="latest">
            <h1>Latest Articles</h1>
        </div>
        <div class="kategorie">
            <span>All</span>
            <span>Technology</span>
            <span>Health & Wellness</span>
            <span>Lifestyle</span>
            <span>Business & Finance</span>
            <span>Travel & Adventure</span>
            <span>
                <div class="input-box">
                    <i class="bx bxs-search"></i>
                    <input type="text" placeholder="Search">
                </div>
                
            </span>
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
                   echo "<div class='content'>" . nl2br(htmlspecialchars($row['content'])) . "</div>"; 
                   echo "<p><strong>Data publikacji: </strong>" . date('d-m-Y', strtotime($row['date'])) . "</p>";
                   echo "<a href='article.php?id=" . $row['id_article'] . "' class='read-more'>Czytaj dalej..</a>";
                   echo "</div>";
               }
           } else {
               echo "Brak artykułów w bazie danych.";
           }
           
           $conn->close();
        ?>
    </main>
    <footer>
        <div class="footer-info">
            <div class="footer-up">
                <div class="footer-left">
                    <h3>
                        CMS - Articles
                    </h3>
                </div>
                <div class="footer-right">
                    <box-icon type='logo' name='instagram'></box-icon> <box-icon type='logo' name='facebook'></box-icon> <box-icon name='pinterest' type='logo' ></box-icon> <box-icon name='twitter' type='logo' ></box-icon>
                </div>
                 
            </div>
            <div class="footer-down">
                <p>© 2025 CMS  <a href="#">Terms</a>  <a href="#">Privacy</a>  <a href="#">Cookies</a></p>
                
            </div>
        </div>
    </footer>
</body>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const articles = document.querySelectorAll(".article");

  articles.forEach((article) => {
    const content = article.querySelector(".content");

    if (content) {
      const fullText = content.textContent || content.innerText; 
      const maxLength = 50; 

      if (fullText.length > maxLength) {
        const shortenedText = fullText.slice(0, maxLength) + "...";
        content.textContent = shortenedText;

        const readMore = article.querySelector(".read-more");
        if (readMore) {
          readMore.style.display = "inline-block";
        }
      }
    }
  });
});
</script>
</html>