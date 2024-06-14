<?php
include '../php/conexion.php'; // Conexión a la base de datos

// Verificar si se recibieron los datos necesarios para la actualización
if (isset($_POST['id'])) {
    $idProyecto = $_POST['id'];
    $responsable = $_POST['responsable'];
    $nombre = $_POST['nombre'];
    $cliente = $_POST['cliente'];
    $comercial = $_POST['comercial'];
    $estado = $_POST['estado'];
    $empresa_emisora = $_POST['empresa_emisora'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $vencimiento_factura = $_POST['vencimiento_factura'];
    $descripcion = $_POST['descripcion'];
    // Asumiendo que 'orden_compra' también necesita ser actualizado
    $orden_compra = $_POST['orden_compra'];

    // Preparar la consulta SQL para actualizar el proyecto
    $query = "UPDATE proyectos SET responsable=?, nombre=?, cliente=?, comercial=?, estado=?, empresa_emisora=?, fecha_inicio=?, fecha_fin=?, vencimiento_factura=?, descripcion=?, orden_compra=? WHERE id=?";
    $stmt = $conn->prepare($query);
    if (false === $stmt) {
        // Manejar errores al preparar la declaración (opcional)
        die('Error al preparar: ' . htmlspecialchars($conn->error));
    }

    // Vincular parámetros a la declaración preparada
    $rc = $stmt->bind_param("ssssssssssss", $responsable, $nombre, $cliente, $comercial, $estado, $empresa_emisora, $fecha_inicio, $fecha_fin, $vencimiento_factura, $descripcion, $orden_compra, $idProyecto);
    if (false === $rc) {
        // Manejar errores al vincular parámetros (opcional)
        die('Error al vincular parámetros: ' . htmlspecialchars($stmt->error));
    }

    // Ejecutar la declaración preparada
    if ($stmt->execute()) {
                           echo '  <head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    
        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    
    
        <!-- Customized Bootstrap Stylesheet -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>  <style>
   /* Estilos para el contenedor principal */
   .conten {
       position: absolute;
       top: 1px;
       left: 1px;
       display: flex;
       justify-content: center;
       align-items: center;
       height: 100vh;
       width: 100%;
       background-color: #fff;
   }
   
   /* Estilos para la tarjeta */
   .card {
       width: 400px;
       height: 300px;
       display: flex;
       justify-content: center;
       align-items: center;
       border: 1px solid #ccc;
       border-radius: 5px;
       box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
   }

   .card-body {
    display: grid;
    justify-content: center;
    align-items: center;
   }


   /* Estilos para el ícono de verificación */
   .icon-container {
       border-radius: 50%;
       background-color: green;
       width: 100px;
       height: 100px;
       display: flex;
       justify-content: center;
       align-items: center;
       margin: 0 auto 20px;
   }

   /* Estilos para el ícono de verificación */
   .icon {
       font-size: 48px;
   }
</style>
<div class="conten">
   <div class="card">
       <div class="card-body">
           <div class="icon-container">
               <i class="fas fa-check icon"></i>
           </div>
           <h5 class="card-title">Guardado Exitoso</h5>
           <a class="btn btn-primary m-2 py-3" href="../dashboard.php">OK</a>
       </div>
   </div>
</div>

<!-- Incluye la biblioteca Font Awesome para el ícono -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>" ';
    } else {
        echo "Error al actualizar el proyecto: " . htmlspecialchars($stmt->error);
    }

    // Cerrar declaración y conexión
    $stmt->close();
    $conn->close();
} else {
    echo "No se proporcionó el ID del proyecto.";
}
?>
