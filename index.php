<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome</h1>
    <h2>login</h2>
    <form action="index.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username">
        <label for="password">password</label>
        <input type="password" name="password">
        <input type="submit" name="login" value="login">
    </form>   

    <p>Don't have an account? <a href="register.php">Register</a></p>
    

</body>
</html>


<?php
    session_start();
    require_once 'db.php';

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($password) || empty($username))  {
        echo "bitte alles ausfülen.";
        exit;
    }

        
    //LOGIN
    // genau wie bei register, aber jetzt nehmen wir wo username = ?, also existiert. wenn row 1 also user existiert, dan login erfolgreich, wenn row 0 also in datenbank es keinen user gibt mit ?, dann fail login. ? ist tja nur platzhalter für echte username bzw. password-
    // basically wir gucken gibt es den user in der datenbank? 
    // SELECT * Weil wir username UND passwort wollen, für password verify unten
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    // get_result() gives you many rows (even if it’s just 1)
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        // fetch_assoc() lets you access that row as an array, also gibt mir die user daten als array (username, pw aus datenbank).
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header('location: dashboard.php');
            exit;

        }
        else { echo "ungültiges passwort";
        }
    }

}


//PASSWORT VERIFY, checken ob das richige passwort mit has in db übereinstimmt.
//parameters: password: The user's password. hash: A hash created by password_hash().

//fetched das erste ergennis, also den relvanten user.
// So think of $user like this: 🧠 “Hey database, give me the row with that username 
//  and I’ll call it $user so I can access its info easily.”


//parameters von verify easy erklärt: 
//password_verify(string $userInputPassword, string $hashedPasswordFromDatabase)


?>






