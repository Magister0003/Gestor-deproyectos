<?php
include 'conexion.php'; // Asegúrate de incluir el archivo correcto para la conexión a la base de datos

header('Content-Type: application/json');

// Consulta SQL para obtener el valor máximo de facturaiva
$sql_max = "SELECT MAX(facturaiva) AS facturaiva_maxima FROM archivo";
$result_max = $conn->query($sql_max);
$facturaiva_maxima = 0;

if ($result_max->num_rows > 0) {
    $row_max = $result_max->fetch_assoc();
    $facturaiva_maxima = $row_max['facturaiva_maxima'];
}

// Consulta SQL para obtener todos los valores de facturaiva
$sql_facturaiva = "SELECT DISTINCT facturaiva FROM archivo";
$result_facturaiva = $conn->query($sql_facturaiva);
$facturaivas = [];

if ($result_facturaiva->num_rows > 0) {
    while ($row_facturaiva = $result_facturaiva->fetch_assoc()) {
        $facturaivas[] = (float)$row_facturaiva['facturaiva'];
    }
}

// Combinar los resultados en un solo array de datos
$datos = [
    'facturaiva_maxima' => (float)$facturaiva_maxima,
    'facturaivas' => $facturaivas
];

echo json_encode($datos);

$conn->close();
?>


