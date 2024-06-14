<?php
// Incluye tu archivo de conexión a la base de datos
include '../php/conexion.php';

// Asegúrate de que 'idTarea', 'tarea' y 'proyecto' son los nombres correctos de los parámetros pasados en la URL
$idTarea = isset($_GET['idTarea']) ? $_GET['idTarea'] : 'id de la tarea no especificado';
$tarea = isset($_GET['tarea']) ? $_GET['tarea'] : 'Nombre de la tarea no especificado';
$proyecto = isset($_GET['proyecto']) ? $_GET['proyecto'] : 'Nombre del proyecto no especificado';

// Diagnostica los valores que se están pasando
//var_dump($_GET);

        session_start(); // Iniciar la sesión
        
        // Obtener los valores de la sesión
        $username = $_SESSION['username'];
        $access_level = $_SESSION['access_level'];
        $email = $_SESSION['email'];
        $archivo = $_SESSION['archivo'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Documento para <?php echo htmlspecialchars($tarea); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="c">
    <aside>
        <div class="toggle">
        
                <img src="../img/logo.png">
            
            <div class="close" id="close-btn">
                <span class="material-icons-sharp">
                    close
                </span>
            </div>
        </div>

        <div class="sidebar">
            <a class="dbl"></a>
            <a href="../dashboard.php" class="active">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Dashboard</h3>
            </a>
            <a href="../graficos" >
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Gráficos</h3>
            </a>

            <a href="../index.php" >
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Crear Proyecto</h3>
            </a>
            
            <a href="../reportes/index.php">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Reportes</h3>
            </a>
            
            <a href="../../../admin.php">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Intranet</h3>
            </a>


            <div class="profile">
            <div class="profile-photo">
            <?php echo "<img src='../img/$archivo' alt='Imagen de usuario'>"; ?>
            </div>
            <div class="info">
                <p><b style="font-size: 0.70rem !important;"><?php echo $username; ?></b></p>
                <small class="text-muted"></small>
            </div>
            </div>
            <a href="../../../form_login.php">
                <span class="material-icons-sharp">
                    logout
                </span>
                <h3>Logout</h3>
            </a>
        </div>
    </aside>

    <main class="px-0">
        <h1 class="mb-3 ms-3">Subir Documento para <?php echo htmlspecialchars($tarea); ?> del Proyecto <?php echo htmlspecialchars($proyecto); ?></h1>
            
        <div class="container mb-3 px-5 py-3">

            
        
    <!-- <h2>Id de tarea: <?php echo htmlspecialchars($idTarea); ?></h2> -->
    <form action="../procesarSubida.php" method="post" enctype="multipart/form-data" class="row g-3 m-5 p-5">


                <input value="<?php echo $username; ?>" type="hidden" name="nombreUsuario" id="nombreUsuario">


                <?php
        // Si la tarea es "facturación", muestra el campo para el número de factura
        if ($tarea === "Factura") {
            echo '<div class="col-sm-6">';
            echo '</div>';
            // Agrega aquí el campo para la fecha de vencimiento
            echo '<div class="col-sm-6">';
            echo '<div class="form-floating">';
                echo '<input class="form-control" type="date" name="fechaVencimiento" id="fechaVencimiento" required>';
                echo '<label for="fechaVencimiento">Fecha de Vencimiento:</label>';
            echo '</div>';
            echo '</div>';
                        echo '<div class="col-sm-6">';
                echo '<div class="form-floating">';
                    echo '<input class="form-control" type="text" name="numeroFactura" id="numeroFactura" placeholder="Número de Factura:" required>';
                    echo '<label for="numeroFactura">Número de Factura:</label>';
                echo '</div>';
            echo '</div>';
            echo '<div class="col-sm-6">';
            echo '<div class="form-floating">';
                echo '<input class="form-control" type="text" name="facturaiva" id="facturaiva" placeholder="Valor de Factura:" required>';
                echo '<label for="numeroFactura">Valor de Factura:</label>';
            echo '</div>';
            echo '</div>';

        
        }
        ?>
        <div class="col-sm-12">
            <input class="form-control" type="file" name="archivo">
        </div>
        <div class="col-sm-12">
            <div class="form-floating">
                <textarea class="form-control" style="height: 100px;" name="observacion" id="observacion" required></textarea>
                <label for="observacion">Observación:</label>
            </div>
        </div>
        

        <input type="hidden" name="idTarea" value="<?php echo htmlspecialchars($idTarea); ?>">
        <input type="hidden" name="tarea" value="<?php echo htmlspecialchars($tarea); ?>">
        <input type="hidden" name="proyecto" value="<?php echo htmlspecialchars($proyecto); ?>">
        <div class="col-sm-8 text-center mt-3">
            <button class="btn btn-primary" type="submit">Subir Archivo</button>
        </div>
    </form>
        </div>
    </main>
        <!-- Right Section -->
<div class="right-section">
    <div class="nav">
        <button id="menu-btn">
            <span class="material-icons-sharp">
                menu
            </span>
        </button>
    </div>
</div>
</div>


<script src="../js/index.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../lib/wow/wow.min.js"></script>
<script src="../lib/easing/easing.min.js"></script>
<script src="../lib/waypoints/waypoints.min.js"></script>
<script src="../lib/owlcarousel/owl.carousel.min.js"></script>
<script src="../lib/lightbox/js/lightbox.min.js"></script>

</body>
<script src="../../temp.js"></script>
</html>