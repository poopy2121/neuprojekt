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


    <form action="dashboard.php" method="post">
        <input type="text" name="note">
        <input type="submit" value="add note" name="addNote">
    </form>
    
</body>
</html>


<?php 
session_start();
require_once 'db.php';

if ($_SESSION['username']) {
    $userid = $_SESSION['id'];
    echo 'Wilkommen ' . $_SESSION['username'];

    if (isset($_POST['addNote'])) {
    $note = htmlspecialchars($_POST['note']);
    echo $note;

    $newQuery = "INSERT into notes (content, created_by) Values (?,?)";
    $stmt = $conn->prepare($newQuery);
    $stmt->bind_param('si', $note, $userid);
    $stmt->execute();
    $newResult = $stmt->get_result();
}
}

//effizientr möglich?
else {
    echo "PLEASE login.";
    if (isset($_POST['logout'])) {
        header('Location: index.php');
    exit;   
    }
}

if (isset($_POST['logout'])) {
    header('Location: index.php');
    session_destroy();
    exit;
}


//note logik 


?>