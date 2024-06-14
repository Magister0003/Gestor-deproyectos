<?php
include '../php/conexion.php'; // Asume que este archivo realiza la conexión a tu base de datos

$query = "SELECT id_cliente, nombre_cliente FROM clientes"; // Ajusta estos nombres de campo y tabla según tu base de datos
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["id_cliente"] . "'>" . $row["nombre_cliente"] . "</option>";
    }
} else {
    echo "<option>No hay clientes disponibles</option>";
}
$conn->close();
?>