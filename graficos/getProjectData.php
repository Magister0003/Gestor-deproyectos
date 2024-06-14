<?php
// getProjectData.php
include 'conexion.php';

$sql = "SELECT estado, COUNT(*) as cantidad FROM proyectos GROUP BY estado";
$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'estado' => $row['estado'],
        'cantidad' => $row['cantidad']
    ];
}

echo json_encode($data);
$conn->close();
?>