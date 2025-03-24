<?php
//mit datenbank verbinden, host, username, paswwort, database-name (root unnd leeres passwword sind default in xammp)
$conn = mysqli_connect("127.0.0.1", "root", "", "cooldb");

if (!$conn) {
    die("connection failed" . mysqli_connect_error());
}
?>