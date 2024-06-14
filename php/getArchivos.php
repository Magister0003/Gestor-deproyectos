<?php
include '../php/conexion.php';
$idProyecto = $_GET['idProyecto'];
// Asegúrate de validar y sanear $idProyecto para evitar inyecciones SQL

$query = "SELECT a.id, p.nombre as nombre, a.nombre_tarea, a.nombre_archivo, a.ruta_archivo FROM proyectos p JOIN archivos a ON p.id = a.id_proyecto WHERE p.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idProyecto);
$stmt->execute();
$resultado = $stmt->get_result();

$archivos = [];
while ($fila = $resultado->fetch_assoc()) {
    $archivos[] = $fila;
}

echo json_encode($archivos);;
?>