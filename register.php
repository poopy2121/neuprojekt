<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>REGISTER</h1>
    <form action="register.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="ultra cool name">
        <label for="password">password</label>
        <input placeholder=" 6 characters pls :3" type="password" name="password">
        <label for="repeated_password">repeat the password!!!</label>
        <input type="password" name="repeated_password" placeholder="repeat password">

        <input type="submit" name="register" value="lets go">
    </form>     
    <p>already got an account? <a href="index.php">login here</a></p>
</body>
</html>

<?php 
require_once 'db.php';

//wenn form aaction = post, mach: 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeated_password = $_POST['repeated_password'];

    //passwort wird gehased, password default ist der name vom algorithmus, es gibt mehrere
    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

}

//isset: code innerhalb hier von wird nur ausgeführt sobald der button mit name "register" geklickt wird
if (isset($_POST['register'])) {


    if (empty($username) || empty($password) || empty($repeated_password)) {
        echo "bitte fülle alles aus.";
        exit;
    }



    if ($password !== $repeated_password) {
        echo "passwords are not the same!!!";
        exit;
        }




//checken ob user schon existiert, bzw username vergeben

$querytwo = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($querytwo);
$stmt->bind_param('s', $username);
$stmt->execute();
$resulttwo = $stmt->get_result();

if (mysqli_num_rows($resulttwo) == 1) {
    echo "username schon vergeben.";
    exit;
}



//FORMDATA IN DATENBANK BALLERN
//conn, bind, execute

$query = "INSERT INTO users (username, password) VALUES (?,?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $username, $hashedpassword);
$stmt->execute();
$result = $stmt->get_result();

}





?>

