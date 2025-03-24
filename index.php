<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username">
        <label for="password">password</label>
        <input type="password" name="password">
        <input type="submit" value="lets go">
    </form>    
</body>
</html>


<?php
//mit datenbank verbinden, host, username, paswwort, database-name (root unnd leeres passwword sind default in xammp)
$conn = mysqli_connect("127.0.0.1", "root", "", "cooldb");

if (!$conn) {
    die("connection failed" . mysqli_connect_error());
}
echo "databse connection works fine!";

//wenn form aaction = post, mach: 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //$_post = was in dem jeweiligen fällt steht. ist so änhlich wie in js .value() variable $username = inputfeld mit name "username"
    $username = $_POST['username'];
    $password = $_POST['password'];
    echo  "user: " . $username . "<br>"; 
    echo "password: " . $password . "<br>";

    if ($username === "" and $password === "") {
        echo "pls fill out everything";
    }
}

//formdata in datenbank packen mit stmt (sicher gegen sql injections.) $query = "INSERT INTO users (username, password) VALUES ($username, $password) wäre nicht gut. ";

$query = "INSERT INTO users (username, password) VALUES (?,?)";
$stmt = $conn->prepare($query);
$stmt = $conn->bind('ss', $username, $password);