<?php 
include '../php/conexion.php';
header('Content-Type: application/json');

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Obtén el nombre del cliente si se proporciona como parámetro en la URL
$nombreCliente = isset($_GET['nombreCliente']) ? $_GET['nombreCliente'] : null;

// Obtén el nombre del comercial si se proporciona como parámetro en la URL
$nombreComercial = isset($_GET['nombreComercial']) ? $_GET['nombreComercial'] : null;

// Obtén el estado del proyecto si se proporciona como parámetro en la URL
$estadoProyecto = isset($_GET['estadoProyecto']) ? $_GET['estadoProyecto'] : null;

// Obtén el número de factura si se proporciona como parámetro en la URL
$numeroFactura = isset($_GET['numeroFactura']) ? $_GET['numeroFactura'] : null;

// Obtén la orden de compra si se proporciona como parámetro en la URL
$ordenCompra = isset($_GET['ordenCompra']) ? $_GET['ordenCompra'] : null;

// Obtén la orden de compra si se proporciona como parámetro en la URL
$empresa_emisora = isset($_GET['empresa_emisora']) ? $_GET['empresa_emisora'] : null;

// Modifica la consulta SQL base
//$sql = "SELECT proyectos.id as proyectoId, proyectos.nombre as proyectoNombre,
//               proyectos.comercial, proyectos.orden_compra, proyectos.fecha_inicio, proyectos.fecha_fin, proyectos.cliente,
//               MAX(archivos.numero_factura) as numero_factura,
//               tareas.id as tareaId, tareas.nombre as tareaNombre,
//               MAX(tareas.completada) as completada
//        FROM proyectos
//        LEFT JOIN tareas ON proyectos.id = tareas.id_proyecto
//        LEFT JOIN archivos ON proyectos.id = archivos.id_proyecto";

$sql = "SELECT proyectos.id as proyectoId, proyectos.nombre as proyectoNombre,
               proyectos.comercial, proyectos.orden_compra, proyectos.empresa_emisora, proyectos.fecha_inicio, proyectos.fecha_fin, proyectos.cliente,
               proyectos.estado, 
               MAX(archivos.numero_factura) as numero_factura,
               tareas.id as tareaId, tareas.nombre as tareaNombre,
               MAX(tareas.completada) as completada
        FROM proyectos
        LEFT JOIN tareas ON proyectos.id = tareas.id_proyecto
        LEFT JOIN archivos ON proyectos.id = archivos.id_proyecto";

// Aplica el filtro por nombre de cliente si se proporciona
if ($nombreCliente) {
    $sql .= " WHERE proyectos.cliente = '" . $nombreCliente . "'";
}

// Aplica el filtro por nombre del comercial si se proporciona
if ($nombreComercial) {
    // Si ya se aplicó un filtro anteriormente, agrega "AND" para combinar los filtros
    $sql .= $nombreCliente ? " AND " : " WHERE ";
    $sql .= "proyectos.comercial = '" . $nombreComercial . "'";
}

// Aplica el filtro por estado del proyecto si se proporciona
if ($estadoProyecto) {
    $sql .= ($nombreCliente || $nombreComercial ? " AND " : " WHERE ");
    $sql .= "proyectos.estado = '" . $estadoProyecto . "'";
}

// Agrega la condición para filtrar por número de factura
if ($numeroFactura) {
    $sql .= ($nombreCliente || $nombreComercial || $estadoProyecto ? " AND " : " WHERE ") . "archivos.numero_factura LIKE '%" . $numeroFactura . "%'";
}

// Agrega la condición para filtrar por orden de compra
if ($ordenCompra) {
    $sql .= ($nombreCliente || $nombreComercial || $estadoProyecto || $numeroFactura ? " AND " : " WHERE ") . "proyectos.orden_compra LIKE '%" . $ordenCompra . "%'";
}

// Agrega la condición para filtrar por $empresa_emisora
if ($empresa_emisora) {
    $sql .= ($nombreCliente || $nombreComercial || $estadoProyecto || $numeroFactura || $empresa_emisora ? " AND " : " WHERE ") . "proyectos.empresa_emisora LIKE '%" . $empresa_emisora . "%'";
}

$sql .= " GROUP BY proyectos.id, tareas.id";

$result = $conn->query($sql);
$proyectos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Agrega el proyecto si aún no está en el array
        if (!isset($proyectos[$row["proyectoId"]])) {
            $proyectos[$row["proyectoId"]] = array(
                "id" => $row["proyectoId"],
                "nombre" => $row["proyectoNombre"],
                "cliente" => $row["cliente"],
                "comercial" => $row["comercial"],
                "orden_compra" => $row["orden_compra"],
                "empresa_emisora" => $row["empresa_emisora"],
                "fecha_inicio" => $row["fecha_inicio"],
                "fecha_fin" => $row["fecha_fin"],
                "estado" => $row["estado"],
                "tareas" => array()
            );
        }

        // Agrega la tarea si existe
        if ($row['tareaId']) {
            $tarea = array(
                "id" => $row["tareaId"],
                "nombre" => $row["tareaNombre"],
                "completada" => $row["completada"]
            );
            $proyectos[$row["proyectoId"]]["tareas"][] = $tarea;
        }

        // Agrega el número de factura si existe
        if ($row["numero_factura"]) {
            $proyectos[$row["proyectoId"]]["numero_factura"] = $row["numero_factura"];
        }
    }

    // Convertir los proyectos a un array indexado
    echo json_encode(array_values($proyectos));
} else {
    echo json_encode([]);
}

$conn->close();
?>
