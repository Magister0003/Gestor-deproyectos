<?php
include '../php/conexion.php';
session_start(); // Iniciar la sesión
        
// Obtener los valores de la sesión
$username = $_SESSION['username'];
$access_level = $_SESSION['access_level'];
$email = $_SESSION['email'];
$archivo = $_SESSION['archivo'];

// Asegúrate de validar y desinfectar todos los inputs
$responsable = $username; //Resposable del crear el proyecto en la aplicación
$nombreProyecto = $_POST['nombre']; // Nombre del proyecto
$comercial = $_POST['comercial']; // Comercial a cargo
$estado = $_POST['estado']; // Estado del proyecto
$fecha_inicio = $_POST['fecha_inicio']; // Fecha de inicio
$fecha_fin = $_POST['fecha_fin']; // Fecha de fin
$descripcion = $_POST['descripcion']; // Descripción del proyecto
$cliente = $_POST['cliente']; // Cliente asociado
$orden_compra = $_POST['orden_compra']; // Orden de compra
$empresa_emisora= $_POST['empresa_emisora']; // empresa_emisora

// Tareas predefinidas
$tareasPredefinidas = ['Liquidación', 'Orden de Compra (cust)', 'Orden de Compra', 'Póliza', 'Factura Proveedor', 'Remisión', 'Prefactura', 'Factura', 'Carta de Satisfacción', 'Recibo de Pago Cliente'];

$conn->begin_transaction();

try {
    // Insertar el nuevo proyecto con todos los campos
    $stmt = $conn->prepare("INSERT INTO proyectos (nombre, comercial, estado, fecha_inicio, fecha_fin, descripcion, cliente, orden_compra, responsable, empresa_emisora) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $nombreProyecto, $comercial, $estado, $fecha_inicio, $fecha_fin, $descripcion, $cliente, $orden_compra, $responsable, $empresa_emisora);
    $stmt->execute();
    $idProyecto = $stmt->insert_id;

    // Insertar tareas predefinidas para el nuevo proyecto
    $stmt = $conn->prepare("INSERT INTO tareas (id_proyecto, nombre) VALUES (?, ?)");
    foreach ($tareasPredefinidas as $tarea) {
        $stmt->bind_param("is", $idProyecto, $tarea);
        $stmt->execute();
    }

    $conn->commit();
    ?>
    
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
           <a class="btn btn-primary m-2" href="../dashboard.php">OK</a>
       </div>
   </div>
</div>

<!-- Incluye la biblioteca Font Awesome para el ícono -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

   ';
<?php
    //echo json_encode(["success" => true, "message" => "Nuevo proyecto y tareas creadas con éxito"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

$conn->close();
?>
