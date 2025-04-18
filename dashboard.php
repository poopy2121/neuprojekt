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
    echo 'Wilkommen, ' .  $_SESSION['username'];

    if (isset($_POST['addNote'])) {
    $note = htmlspecialchars($_POST['note']);

    $errormesage = "pls enter a valid note";

    if (empty($note)) {
        echo $errormesage;
    }
    
    else {
    // notitz in datenbank ballern
    $newQuery = "INSERT into notes (content, created_by) Values (?,?)";
    $stmt = $conn->prepare($newQuery);
    $stmt->bind_param('si', $note, $userid);
    $stmt->execute();
    $newResult = $stmt->get_result();   
    }

}}
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

if (isset($_POST['deleteNote'])) {

    // note id ist unten bei while in form post
        $note_id = $_POST['note_id'];
        $deleteQuery = 'DELETE from notes WHERE created_by = ? and id = ?';
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param('ii', $userid, $note_id);
        $stmt->execute();
    
    }

     //notes displayen
    $showQuerry = 'SELECT * from notes WHERE created_by = ?';
    $stmt = $conn->prepare($showQuerry);
    $stmt->bind_param('i',$userid);
    $stmt->execute();
    $result = $stmt->get_result();

    //hieran arbeiten
    while ($row = $result->fetch_assoc()) {
        echo '<p>' . $row['content'] . '</p>';
        echo '<form action="dashboard.php" method="post">';
        echo '<input type="hidden" name="note_id" value="' . $row['id'] . '">';
        echo '<input type="submit" name="deleteNote" value="Delete">';
        echo '</form>';
}
?>

