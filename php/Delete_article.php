<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM article WHERE id_article = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Błąd usuwania!";
    }
    $stmt->close();
}
?>