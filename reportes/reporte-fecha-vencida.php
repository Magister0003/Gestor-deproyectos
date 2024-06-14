<?php
//require_once '../../dompdf/autoload.inc.php';
require_once './dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

include("./conexion_reportes.php");


  // Obtener el valor de la vencimiento_factura seleccionada

  // Validar que se haya seleccionado una vencimiento_factura
  
    // Modificar la consulta en la base de datos para filtrar por vencimiento_factura
    $consulta = "SELECT * FROM proyectos WHERE vencimiento_factura";
    $resultado = mysqli_query($conexion, $consulta);

  

    $html = '<html>';
    $html .= '<head>
    <meta charset="UTF-8">
    <title>Document</title>
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
  



    $dompdf->setPaper('A4', 'portrait');
    $dompdf->loadHtml($html);
    $dompdf->render();
  
    // Descargar el archivo PDF
    $dompdf->stream("Ficha_vencimiento_factura.pdf", ["Attachment" => false]);
  

/*
function obtenerImagenFirma($tecnico) {
  // Puedes implementar tu lógica para obtener la ruta de la imagen defirma según el técnico
  // Por ejemplo, puedes tener un array asociativo donde las claves sean los nombres de los técnicos y los valores sean las rutas de las imágenes
  $firmaTecnicos = array(
   'Denyer Bastidas' => '../firmas/denyer.jpeg',
    'Andrés Agudelo' => '../firmas/andres.jpg',
    'Michael Asprilla' => '../firmas/michael.jpg',
    'Michael Saavedra' => '../firmas/savedra.jpg',
     
    // Agrega más técnicos y sus respectivas rutas de imagen aquí
  );

  // Verificar si el técnico tiene una firma definida
  if (isset($firmaTecnicos[$tecnico])) {
    return $firmaTecnicos[$tecnico];
  } else {
    // Si no hay una firma definida para el técnico, puedes retornar una imagen por defecto o una ruta genérica
    return 'ruta/a/la/imagen/firma_default.jpg';
  }
}*/
?>