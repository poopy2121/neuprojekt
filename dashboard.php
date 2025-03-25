<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="dashboard.php" method="post">
    <input type="submit" name="logout" value="log out">

</form>
    
</body>
</html>


<?php 
session_start();
require_once 'db.php';

if ($_SESSION['username']) {
    echo 'Wilkommen ' . $_SESSION['username'];
}
else {
    echo "PLEASE login.";
    exit;
}

if (isset($_POST['logout'])) {
    header('Location: index.php');
    session_destroy();
    exit;
}
?>