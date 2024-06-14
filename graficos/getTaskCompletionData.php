<?php
include 'conexion.php'; // Asegúrate de incluir el archivo correcto para la conexión a la base de datos

header('Content-Type: application/json');

// La consulta SQL reúne información sobre las tareas completadas y pendientes de cada proyecto
$sql = "SELECT
            p.id AS proyecto_id,
            p.nombre AS nombre_proyecto,
            SUM(CASE WHEN t.completada = 1 THEN 1 ELSE 0 END) AS tareas_completadas,
            SUM(CASE WHEN t.completada = 0 THEN 1 ELSE 0 END) AS tareas_pendientes
        FROM proyectos p
        LEFT JOIN tareas t ON p.id = t.id_proyecto
        GROUP BY p.id, p.nombre";

$result = $conn->query($sql);
$datos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datos[] = [
            'nombre_proyecto' => $row['nombre_proyecto'],
            'completadas' => (int)$row['tareas_completadas'],
            'pendientes' => (int)$row['tareas_pendientes']
        ];
    }
}

echo json_encode($datos);

$conn->close();
?>
