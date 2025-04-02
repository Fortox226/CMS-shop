<?php
session_start();

include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<h1>403 Forbidden</h1> Brak dostępu. Tylko administratorzy mają dostęp do tej strony.";
    exit();
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admina</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/stylea.css">
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        button { padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>
<header>
    <h2>Lista użytkowników</h2>
    <div class="back">
        <a href="index.php">Strona główna</a>
    </div>
</header>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password</th>
        <th>Role</th>
        <th>Akcje</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr id="user_<?php echo $row['id']; ?>">
        <td><?php echo $row['id']; ?></td>
        <td contenteditable="true" onBlur="updateUser(<?php echo $row['id']; ?>, 'username', this.innerText)">
            <?php echo $row['username']; ?>
        </td>
        <td>
            <input type="password" value="********" onFocus="this.value=''" onBlur="updateUser(<?php echo $row['id']; ?>, 'password', this.value)">
        </td>
        <td>
            <select onChange="updateUser(<?php echo $row['id']; ?>, 'role', this.value)">
                <option value="user" <?php echo $row['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo $row['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="editor" <?php echo $row['role'] == 'editor' ? 'selected' : ''; ?>>Editor</option>
            </select>
        </td>
        <td><button onClick="deleteUser(<?php echo $row['id']; ?>)">Usuń</button></td>
    </tr>
    <?php } ?>
</table>

<script>
function updateUser(id, column, value) {
    $.post("update.php", { id: id, column: column, value: value }, function(response) {
        alert(response);
    });
}

function deleteUser(id) {
    if (confirm("Na pewno chcesz usunąć tego użytkownika?")) {
        $.post("delete.php", { id: id }, function(response) {
            if (response === "OK") {
                $("#user_" + id).remove();
            } else {
                alert("Błąd usuwania!");
            }
        });
    }
}
</script>

</body>
</html>
