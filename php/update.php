<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $column = $_POST['column'];
    $value = $_POST['value'];

    if ($column === 'password') {
        $value = password_hash($value, PASSWORD_DEFAULT);
    }

    $stmt = $conn->prepare("UPDATE users SET $column = ? WHERE id = ?");
    $stmt->bind_param("si", $value, $id);
    if ($stmt->execute()) {
        echo "Zaktualizowano!";
    } else {
        echo "Błąd aktualizacji!";
    }
    $stmt->close();
}
?>