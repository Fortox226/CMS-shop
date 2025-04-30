<?php
session_start();

include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

if ($role != 'admin' && $role != 'editor') {
    echo "<h1>403 Forbidden</h1> Brak dostępu do tej strony.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['id_article']) && !empty($_POST['id_article'])) {
        
        
        $sql = "UPDATE article SET title = ?, content = ?, date = ? WHERE id_article = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $title, $content, $date, $id_article);
        
        $id_article = $_POST['id_article'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = $_POST['date'];

        // $stmt->store_result();

        if ($stmt->execute()) {
            echo "Artykuł został zaktualizowany!";
        } else {
            echo "Błąd: " . $conn->error;
        }
    } else {
        
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = $_POST['date'];
        $imagePath = null;

        if (isset($_FILES['header_image']) && $_FILES['header_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
        
            $fileTmpPath = $_FILES['header_image']['tmp_name'];
            $fileName = basename($_FILES['header_image']['name']);
            $fileName = time() . '_' . $fileName;
            $destPath = $uploadDir . $fileName;
        
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imagePath = $destPath;
            } else {
                echo "Błąd podczas przesyłania pliku.";
            }
        }
        
        $sql = "INSERT INTO article (title, content, date, header_image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $title, $content, $date, $imagePath);
        

        if ($stmt->execute() === TRUE) {
            echo "Nowy artykuł został dodany!";
        } else {
            echo "Błąd: " . $conn->error;
        }
    }
}


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
    } else {
        echo "Artykuł nie został znaleziony.";
        $title = $content = $date = ''; 
    }
} else {
    
    $title = $content = '';
    $date = date('Y-m-d');
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Panel</title>
    <link rel="stylesheet" href="../css/style-edit.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <img src="../assets/cms.png" alt="" >
        <h1>Edit Panel</h1> 
       <div class="back">
            <a href="index.php">Strona główna</a>
       </div>
       
    </header>
    <main>
        
         <div class="formularz">
    <h2><?php echo isset($_GET['id']) ? 'Edytuj' : 'Dodaj nowy '; ?> artykuł</h2>
    <form action="edit.php<?php echo isset($id_article) ? '?id=' . $id_article : ''; ?>" method="post" enctype="multipart/form-data">
        <?php if (isset($id_article)): ?>
            <input type="hidden" name="id_article" value="<?php echo $id_article; ?>">
        <?php endif; ?>
        
        <label for="title"></label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br><br>
        
        <label for="content"></label><br>
        <textarea id="content" name="content" rows="10" cols="90" required><?php echo htmlspecialchars($content); ?></textarea><br><br>
        
        <label for="date">Data artykułu:</label><br>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>" required><br><br>
        <input type="file" name="header_image" accept="image/*"><br><br>
        
        <input type="submit" value="<?php echo isset($id_article) ? 'Zapisz zmiany' : 'Dodaj artykuł'; ?>">
    </form>
</div>
    

    <div class="lista">
    <h2>Lista artykułów</h2>
    <?php
$sql = "SELECT * FROM article";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li data-id=\"{$row['id_article']}\">";

        echo "<div class='article-info'>";
        echo "ID: {$row['id_article']} — Tytuł: {$row['title']} — Data: {$row['date']}";
        echo "</div>";

        echo "<div class='actions'>";
        echo "<a href='edit.php?id={$row['id_article']}'>Edytuj</a>";
        echo "<button onclick='deleteArticle({$row['id_article']})'>Usuń</button>";
        echo "</div>";

        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Brak artykułów.";
}

$conn->close();
?>
    </div>
</main>
<script>
    function deleteArticle(id) {
        if (confirm("Na pewno chcesz usunąć ten artykuł?")) {
            $.post("Delete_article.php", { id: id }, function(response) {
                if (response === "OK") {
                    $("li[data-id=" + id + "]").remove();
                } else {
                    alert("Błąd usuwania!");
                }
            });
        }
    }
</script>
</body>
</html>

