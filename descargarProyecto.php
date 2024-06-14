<?php
include './php/conexion.php'; // Incluye tu conexión a la base de datos

$idProyecto = $_GET['idProyecto'] ?? '';

// Verificar si el ID del proyecto es válido
if (empty($idProyecto) || !is_numeric($idProyecto)) {
    die('ID de proyecto no válido.');
}

// Consulta para obtener el nombre del proyecto
$sqlNombre = "SELECT nombre FROM proyectos WHERE id = ?";
$stmtNombre = $conn->prepare($sqlNombre);
$stmtNombre->bind_param("i", $idProyecto);
$stmtNombre->execute();
$resultadoNombre = $stmtNombre->get_result();

if ($fila = $resultadoNombre->fetch_assoc()) {
    $nombreProyecto = $fila['nombre'];
} else {
    die('Proyecto no encontrado.');
}

// Consulta para obtener los archivos del proyecto
$sql = "SELECT ruta_archivo FROM archivos WHERE id_proyecto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idProyecto);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    // Inicializar un nuevo objeto ZipArchive
    $zip = new ZipArchive();
    $nombreArchivoZip = "proyecto_" . preg_replace("/[^a-zA-Z0-9]+/", "_", $nombreProyecto) . ".zip";
    $rutaZip = "./zip/" . $nombreArchivoZip; // Asegúrate de que la carpeta 'zip' exista y tenga permisos de escritura
    
    if ($zip->open($rutaZip, ZipArchive::CREATE) === TRUE) {
        // Agregar cada archivo al ZIP
        while ($archivo = $resultado->fetch_assoc()) {
            $rutaArchivo = $archivo['ruta_archivo'];
            if (file_exists($rutaArchivo)) {
                $zip->addFile($rutaArchivo, basename($rutaArchivo));
            }
        }
        $zip->close();
    
        // Envía el archivo ZIP para su descarga
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($nombreArchivoZip) . '"');
        header('Content-Length: ' . filesize($rutaZip));
        readfile($rutaZip);
    
        // Opcional: Eliminar el archivo ZIP después de la descarga
        unlink($rutaZip);
    } else {
        die('No se pudo crear el archivo ZIP.');
    }
} else {
    echo "<script>alert('No hay archivos para descargar.'); window.history.back();</script>";
}
?>

