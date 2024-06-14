<?php
include '../php/conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

error_log("Datos recibidos en PHP: " . print_r($data, true)); // Agrega esta l��nea para depuraci��n

if (!isset($data['idTarea']) || !isset($data['completada'])) {
    echo json_encode(["exito" => false, "mensaje" => "Datos incompletos"]);
    exit;
}

$idTarea = $data['idTarea'];
$completada = $data['completada'];

$stmt = $conn->prepare("UPDATE tareas SET completada = ? WHERE id = ?");
$stmt->bind_param("ii", $completada, $idTarea);

if ($stmt->execute()) {
    echo json_encode(["exito" => true]);
} else {
    echo json_encode(["exito" => false, "mensaje" => "Error al actualizar la tarea"]);
}

$stmt->close();
$conn->close();
?>
