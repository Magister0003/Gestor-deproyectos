<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blockbl5_sysintegraapp";

/*$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blockbl5_asecoemg";*/

// Crear conexi贸n
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexi贸n
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8mb4");
?>