<?php 
include 'config.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_article = $_GET['id'];
    
    
    $sql = "SELECT * FROM article WHERE id_article = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_article);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];
        $date = $row['date'];
        $image = $row['header_image'];
    } else {
        echo "Artykuł nie został znaleziony.";
        $title = $content = $date = ''; 
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../css/style-article.css">
</head>
<body>
    <header>
        <div class="header-bar">
            <div class="title">
                <h1>CMS Articles</h1>
            </div>
            <div class="back">
                <a href="index.php">Strona główna</a>
            </div>
        </div>
    </header>
    <main>
        <?php
            echo "<div class='article'>";
            echo "<img src=\"" .  htmlspecialchars($image) . "\" alt=\"" . htmlspecialchars($row['title']) . "\"/>";
            echo "<h1>" . htmlspecialchars($title) . "</h1>";
            echo "<div class='content'>" . nl2br(htmlspecialchars($content)) . "</div>";
            echo "</div>";
        ?>
    </main>
</body>
</html>