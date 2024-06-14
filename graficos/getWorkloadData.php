<?php
include 'conexion.php';

header('Content-Type: application/json');

// Consulta para obtener la carga de trabajo a lo largo del tiempo
$sql = "SELECT
            fecha_inicio,
            fecha_fin,
            COUNT(*) as cantidadProyectos
        FROM proyectos
        WHERE fecha_inicio IS NOT NULL AND fecha_fin IS NOT NULL
        GROUP BY fecha_inicio, fecha_fin
        ORDER BY fecha_inicio";

$result = $conn->query($sql);
$datos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datos[] = [
            "fecha_inicio" => $row["fecha_inicio"],
            "fecha_fin" => $row["fecha_fin"],
            "cantidadProyectos" => (int)$row["cantidadProyectos"]
        ];
    }
    echo json_encode($datos);
} else {
    echo json_encode([]);
}

$conn->close();
?>
