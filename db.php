<?php
$servername = "localhost";
$username = "root";
$password = "Ines.2004!!";
$database = "gestioncomptes";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>
