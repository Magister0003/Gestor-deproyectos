<?php
//require_once '../../dompdf/autoload.inc.php';
require_once './dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

// Conexión a la base de datos
include("./conexion_reportes.php");

// Verificar conexión
if (mysqli_connect_errno()) {
    echo "Error al conectar a MySQL: " . mysqli_connect_error();
    exit();
}

 // Suponiendo que el valor de fecha viene de un formulario POST

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el valor de la sede seleccionada
    $fecha_final = $_POST['fecha_final'];
    
    if (!empty($fecha_final) ) {


$consulta = "SELECT * FROM proyectos WHERE fecha_fin = '$fecha_final'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    // Crear instancia de Dompdf
    $dompdf = new Dompdf();

    // Contenido HTML del informe
    $html = '<html>';
    $html .= '<head>
                <meta charset="UTF-8">
                <title>Informe de Proyectos</title>
                <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 10px;
                }
                
                .table-container {
                    margin-top: 20px;
                }
                
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                
                table, th, td {
                    border: 1px solid black;
                    padding: 8px;
                }
                
                th {
                    background-color: #f2f2f2;
                }
                
                </style>
                </head>';
                $html .= '<body>';
                
                $html .= '<h1>Informe de Proyectos</h1>';
                
                $html .= '<div class="table-container">';
                $html .= '<table>';
                $html .= '<tr>
                            <th>Empresa</th>
                            <th>Vencimiento Factura</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Orden de Compra</th>
                            <th>Comercial</th>
                            <th>Estado</th>
                            <th>Cliente</th>
                            <th>Responsable</th>
                            <th>Descripcion</th>
                        </tr>';
                
                  while ($fila = mysqli_fetch_assoc($resultado)) {
                    $html .= '<tr>';
                    $html .= '<td>'. utf8_encode($fila['nombre']) .'</td>';
                    $html .= '<td>'. utf8_encode($fila['vencimiento_factura']) .'</td>';
                    $html .= '<td>'. utf8_encode($fila['fecha_inicio']) .'</td>';
                    $html .= '<td>'. utf8_encode($fila['fecha_fin']) .'</td>';
                    $html .= '<td>'. utf8_encode($fila['orden_compra']) .'</td>';
                    $html .= '<td>'. utf8_encode($fila['comercial']) .'</td>';
                    $html .= '<td>'. utf8_encode($fila['estado']) .'</td>';
                    $html .= '<td>'. utf8_encode($fila['cliente']) .'</td>';
                    $html .= '<td>'. utf8_encode($fila['responsable']) .'</td>';
                    $html .= '<td>'. utf8_encode($fila['descripcion']) .'</td>';
                    $html .= '</tr>';
                }
                  
            
            
                $html .= '</table>';
    $html .= '</div>'; // Cierre de div.table-container

    $html .= '</body>';
    $html .= '</html>';

    // Cargar contenido HTML en Dompdf
    $dompdf->loadHtml($html);

    // Establecer el tamaño del papel y la orientación (opcional)
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar HTML como PDF
    $dompdf->render();

    // Salida del PDF (descargar o visualizar)
    $dompdf->stream("Informe_de_Proyectos.pdf", array("Attachment" => false));
} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}

// Cerrar conexión
mysqli_close($conexion);
    }
}
?>
