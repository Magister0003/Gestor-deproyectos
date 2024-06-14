<?php
if (isset($_POST['orden_compra_busqueda'])) {
    include '../php/conexion.php';

    $ordenCompraBusqueda = $_POST['orden_compra_busqueda'];

    $stmt = $conn->prepare("SELECT * FROM proyectos WHERE orden_compra = ?");
    $stmt->bind_param("s", $ordenCompraBusqueda);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        echo json_encode($fila);
    } else {
        echo json_encode(array("limpiarCampos" => true));
    }

    $stmt->close();
    $conn->close();
}
?>