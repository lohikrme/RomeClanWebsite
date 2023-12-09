<?php
// Luo tietokantayhteys
$dsn = "mysql:host=localhost;dbname=users";
$username = "root";
$password = "";
$conn = new PDO($dsn, $username, $password);

// Suorita SQL-kysely
$sql = "SELECT * FROM registrations";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

// Tulosta tulos
print_r($result);
?>