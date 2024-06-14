<?php
include './php/conexion.php'; // Incluye tu archivo de conexión a la base de datos
header('Content-Type: application/json');

ini_set('display_errors', 1); // Solo para depuración
ini_set('display_startup_errors', 1); // Solo para depuración
error_reporting(E_ALL); // Solo para depuración

$datos = json_decode(file_get_contents('php://input'), true);
$idArchivo = $datos['idArchivo'] ?? null;
$responsable = $datos['nombreResponsable'] ?? 'Desconocido';

if (!isset($idArchivo) || !is_numeric($idArchivo)) {
    echo json_encode(["exito" => false, "mensaje" => "ID de archivo no válido"]);
    exit;
}

$stmt = $conn->prepare("SELECT archivos.ruta_archivo, tareas.id AS id_tarea, tareas.nombre AS nombre_tarea, proyectos.nombre AS nombre_proyecto
                        FROM archivos
                        JOIN tareas ON archivos.id_tarea = tareas.id
                        JOIN proyectos ON tareas.id_proyecto = proyectos.id
                        WHERE archivos.id = ?");
$stmt->bind_param("i", $idArchivo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $rutaDelArchivo = $fila['ruta_archivo'];
    $idTarea = $fila['id_tarea'];
    $nombreTarea = $fila['nombre_tarea'];
    $nombreProyecto = $fila['nombre_proyecto'];

    if (file_exists($rutaDelArchivo) && unlink($rutaDelArchivo)) {
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("DELETE FROM archivos WHERE id = ?");
            $stmt->bind_param("i", $idArchivo);
            $stmt->execute();

            // Insertar registro en historico_eliminar incluyendo el nombre del proyecto
            $stmt = $conn->prepare("INSERT INTO historico_eliminar (nombre_tarea, nombre_proyecto, responsable) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombreTarea, $nombreProyecto, $responsable);
            $stmt->execute();

            // Actualizar la tarea a no completada
            $stmt = $conn->prepare("UPDATE tareas SET completada = 0 WHERE id = ?");
            $stmt->bind_param("i", $idTarea);
            $stmt->execute();

            $conn->commit();
            
                       echo json_encode(["exito" => true, "mensaje" => "Archivo eliminado, tarea actualizada y registro histórico creado"]);


            
            
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(["exito" => false, "mensaje" => "Error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["exito" => false, "mensaje" => "Error al eliminar archivo del servidor"]);
    }
} else {
    echo json_encode(["exito" => false, "mensaje" => "Archivo no encontrado en la base de datos"]);
}

$conn->close();
?>

