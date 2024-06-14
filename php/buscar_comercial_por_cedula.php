<?php
include '../php/conexion.php';

$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';

if ($cedula) {
    $stmt = $conn->prepare("SELECT * FROM comerciales WHERE cedula = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        echo json_encode(['encontrado' => true] + $fila);
    } else {
        echo json_encode(['encontrado' => false]);
    }
    $stmt->close();
} else {
    echo json_encode(['encontrado' => false]);
}
$conn->close();
?>
