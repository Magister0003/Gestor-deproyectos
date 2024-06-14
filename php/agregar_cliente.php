<?php
include '../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo_electronico = $_POST['correo_electronico'];
    $telefono = $_POST['telefono'];

    $stmt = $conn->prepare("INSERT INTO clientes (nombre_cliente, correo_electronico, telefono) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $correo_electronico, $telefono);
    
    if ($stmt->execute()) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
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
        <style>
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
        </head>
        <body>
            <div class="conten">
               <div class="card">
                   <div class="card-body">
                       <div class="icon-container">
                           <i class="fas fa-check icon"></i>
                       </div>
                       <h5 class="card-title">Guardado Exitoso</h5>
                       <a class="btn btn-primary m-2 py-3" href="../mostrar_clientes.php">OK</a>
                   </div>
               </div>
            </div>
            <!-- Aquí van tus scripts JS -->
        </body>
        </html>
        <?php
    } else {
        echo "Error al agregar cliente: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

