<?php
include 'conexion.php'; // Asegúrate de incluir el archivo correcto para la conexión a la base de datos

header('Content-Type: application/json');

// Modifica esta consulta según la estructura de tu base de datos
$sql = "SELECT
            DATE(t.fecha_limite) AS fecha,
            COUNT(*) AS cantidad_tareas
        FROM tareas t
        WHERE t.fecha_limite IS NOT NULL
        GROUP BY DATE(t.fecha_limite)
        ORDER BY DATE(t.fecha_limite)";

$result = $conn->query($sql);
$datos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datos[] = [
            'fecha' => $row['fecha'],
            'cantidad_tareas' => (int)$row['cantidad_tareas']
        ];
    }
}

echo json_encode($datos);

$conn->close();
?>
