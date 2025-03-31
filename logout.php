<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <form action="logout.php" method="post">
        <input type="submit" name="logout" value="log out">
    </form>    
</body>
</html>

<?php 
session_start();
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>