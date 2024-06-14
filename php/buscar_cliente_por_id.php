<?php
include '../php/conexion.php';

$idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : '';

if ($idCliente) {
    $stmt = $conn->prepare("SELECT id_cliente, nombre, correo_electronico, telefono, fecha_creacion FROM clientes WHERE id_cliente = ?");
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $fila['encontrado'] = true;
        echo json_encode($fila); // Esto asegura que 'nombre_cliente' sea parte de la respuesta si eso es lo que esperas
    } else {
        echo json_encode(['encontrado' => false]);
    }
    $stmt->close();
} else {
    echo json_encode(['encontrado' => false]);
}
$conn->close();
?>
