<?php
include '../php/conexion.php'; // Asegúrate de tener este archivo para conectarte a tu base de datos

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idComercial']) && !empty($_POST['idComercial'])) {
    // Recuperar los datos enviados desde el formulario
    $idComercial = $_POST['idComercial'];
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fechaContratacion = $_POST['fecha_contratacion'];
    $otrosDatos = $_POST['otros_datos'];

    // Prepara la consulta SQL para actualizar el comercial
    $stmt = $conn->prepare("UPDATE comerciales SET cedula=?, nombre=?, email=?, telefono=?, fecha_contratacion=?, otros_datos=? WHERE id=?");

    // Vincula los parámetros a la consulta SQL
    $stmt->bind_param("ssssssi", $cedula, $nombre, $email, $telefono, $fechaContratacion, $otrosDatos, $idComercial);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "Comercial actualizado con éxito.";
        // Opcional: Redirigir a otra página después de la actualización, como la lista de comerciales
        // header('Location: mostrar_comerciales.php');
    } else {
        echo "Error al actualizar el comercial: " . $conn->error;
    }

    // Cierra el statement
    $stmt->close();
} else {
    echo "Datos del formulario incompletos.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
