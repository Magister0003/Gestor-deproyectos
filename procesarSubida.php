<?php
include './php/conexion.php'; // Incluye tu archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoge los valores del formulario
    $idTarea = $_POST['idTarea'];
    $tarea = $_POST['tarea'];
    $nombreProyecto = $_POST['proyecto'];
    $directorioDestino = "uploads/$nombreProyecto/$tarea/";
    $nombreUsuario = $_POST['nombreUsuario'];
    $observacion = $_POST['observacion'];
    $numeroFactura = isset($_POST['numeroFactura']) ? $_POST['numeroFactura'] : null;
    // Nuevo: Capturar la fecha de vencimiento de la factura
    $fechaVencimiento = isset($_POST['fechaVencimiento']) ? $_POST['fechaVencimiento'] : null;
    $facturaiva = isset($_POST['facturaiva']) ? $_POST['facturaiva'] : null;

    // Asegura que el directorio existe
    if (!file_exists($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);
    }

    $archivo = $_FILES['archivo']['tmp_name'];
    $nombreArchivo = $_FILES['archivo']['name'];
    $rutaArchivo = $directorioDestino . $nombreArchivo;

    if (move_uploaded_file($archivo, $rutaArchivo)) {
        // Obtén el id del proyecto basado en el nombre del proyecto
        $stmt = $conn->prepare("SELECT id FROM proyectos WHERE nombre = ?");
        $stmt->bind_param("s", $nombreProyecto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($fila = $resultado->fetch_assoc()) {
            $idProyecto = $fila['id'];

            // Inserta la información del archivo en la tabla de archivos
            $stmt = $conn->prepare("INSERT INTO archivos (id_proyecto, nombre_archivo, ruta_archivo, nombre_tarea, id_tarea, responsable, observacion, numero_factura, facturaiva) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssissss", $idProyecto, $nombreArchivo, $rutaArchivo, $tarea, $idTarea, $nombreUsuario, $observacion, $numeroFactura, $facturaiva);
            $stmt->execute();

            // Actualiza el estado de la tarea como completada
            $stmt = $conn->prepare("UPDATE tareas SET completada = 1 WHERE nombre = ? AND id_proyecto = ?");
            $stmt->bind_param("si", $tarea, $idProyecto);
            $stmt->execute();

            // Nuevo: Actualiza la fecha de vencimiento de la factura en la tabla de proyectos
            if ($fechaVencimiento && $numeroFactura) {
                $stmt = $conn->prepare("UPDATE proyectos SET vencimiento_factura = ? WHERE id = ?");
                $stmt->bind_param("si", $fechaVencimiento, $idProyecto);
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
        <link href="./css/bootstrap.min.css" rel="stylesheet">
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
    justify-items: center;
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
           <h5 class="card-title text-center">Archivo y fecha de vencimiento de factura actualizados con éxito</h5>
           <a class="btn btn-primary m-2" href="dashboard.php" style="width: 130px;">OK</a>
       </div>
   </div>
</div>

<!-- Incluye la biblioteca Font Awesome para el ícono -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

   ';
                } else {
                    echo "Archivo subido pero falló la actualización de la fecha de vencimiento de la factura.";
                }
            } else {
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
        <link href="./css/bootstrap.min.css" rel="stylesheet">
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
           <a class="btn btn-primary m-2" href="./dashboard.php">OK</a>
       </div>
   </div>
</div>

<!-- Incluye la biblioteca Font Awesome para el ícono -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

   ';
            }
        } else {
            echo "Proyecto no encontrado.";
        }
    } else {
        echo "Error al subir el archivo.";
    }
}

?>