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
    <title>cms admin page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
    <header>
        <h1>CMS admin panel</h1>
    </header>
    <main>

    <form action="insert.php" method="post">
  <div class="form-group">
     <label>Name</label>
     <input type="text" name="name" class="form-control">
  </div>
  <div class="form-group">
     <label>Email</label>
     <input type="email" name="email" class="form-control">
  </div>
  <div class="form-group">
      <label>Mobile</label>
      <input type="mobile" name="mobile" class="form-control">
  </div>
       <input type="submit" name="submit" value="Submit">

   
</body>
</html>