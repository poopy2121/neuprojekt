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
        <input type="submit" value="delete note" name="deleteNote">
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

    // notitz in datenbank ballern
    $newQuery = "INSERT into notes (content, created_by) Values (?,?)";
    $stmt = $conn->prepare($newQuery);
    $stmt->bind_param('si', $note, $userid);
    $stmt->execute();
    $newResult = $stmt->get_result();

    //notes displayen
    $showQuerry = 'SELECT * from notes WHERE created_by = ?';
    $stmt = $conn->prepare($showQuerry);
    $stmt->bind_param('i',$userid);
    $stmt->execute();
    $result = $stmt->get_result();


    //hieran arbeiten
    while ($row = $result->fetch_assoc()) {
        
    echo '<p>' . $row['content'] . '<p>';
    }
    

    //notes entfernen (hieran arbeiten, es soll nur eine deleted werden. )
    //außerdem musss ich machen dasss bei add jeder note gestyled wird und ein delte butto generiert wird, aber easy
    
    if (isset($_POST['deleteNote'])) {
        $deleteQuery = 'DELETE from notes WHERE created_by = ?';


    }
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