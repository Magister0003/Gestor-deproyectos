<?php
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
    <title>Gestor de Documentos de Proyectos</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="css/estilos.css"> <!-- Asegúrate de tener tu archivo de estilos CSS -->
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/logo.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="c">
    <aside>
        <div class="toggle">
        
                <img src="img/logo.png">
            
            <div class="close" id="close-btn">
                <span class="material-icons-sharp">
                    close
                </span>
            </div>
        </div>

        <div class="sidebar">
            <a class="dbl"></a>
            <a href="#" class="active">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Reportes</h3>
            </a>
            <a href="../graficos" >
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Gráficos</h3>
            </a>
            <a href="../dashboard.php" >
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Dashboard</h3>
            </a>
            <a href="../index.php" >
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Crear Proyecto</h3>
            </a>
            

            
            <a href="../../../admin.php">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Intranet</h3>
            </a>
            <div class="profile">
            <div class="profile-photo">
            <?php echo "<img src='./img/$archivo' alt='Imagen de usuario'>"; ?>
            </div>
            <div class="info">
                <p><b><?php echo $username; ?></b></p>
                <small class="text-muted"></small>
            </div>
            </div>
            <a href="https://integratic.com.co/">
                <span class="material-icons-sharp">
                    logout
                </span>
                <h3>Logout</h3>
            </a>
        </div>
    </aside>

    <main class="px-0">
        <h1 class="mb-3 ms-3">Reportes</h1>    
        <div class="container mb-3">
         <div class="row g-3 pt-5">
            <div class="col-md-4 mb-4">
                <div class="card text-center pt-3">
                    <h5 class="card-title">Reporte de proyectos con fecha vencida</h5>
                    <form method="POST" action="./reporte-fecha-vencida.php" class="row g-3 p-3">
                        <div class="col-12 text-center">
                            <input class="btn btn-primary py-2" type="submit" name="Formulario" value="Descargar" style="width: 100px;">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center pt-3">
                    <h5 class="card-title">Reporte de archivos eliminados</h5>
                    <form method="POST" action="./reporte-archivos-eliminados.php" class="row g-3 p-3">
                        <div class="col-12 text-center">
                            <input class="btn btn-primary py-2" type="submit" name="Formulario" value="Descargar" style="width: 100px;">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center pt-3">
                    <h5 class="card-title">Reporte de archivos Cargados</h5>
                    <form method="POST" action="./reporte-archivos-cargados.php" class="row g-3 p-3">
                        <div class="col-12 text-center">
                            <input class="btn btn-primary py-2" type="submit" name="Formulario" value="Descargar" style="width: 100px;">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center pt-3">
                    <h5 class="card-title">Reporte fecha vencimiento</h5>
                    <form method="POST" action="./reporte-fecha-vencimiento.php" class="row g-3 p-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="date" name="fecha_final" id="fecha_final" class="form-control" required>
                                <label for="fecha_final_ficha">Fecha final:</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <input class="btn btn-primary py-2" type="submit" name="Formulario" value="Descargar" style="width: 100px;">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center pt-3">
                    <h5 class="card-title">Reportes por proyecto</h5>
                    <form method="POST" action="./reporte-proyecto.php" class="row g-3 p-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del proyecto" required>
                                <label for="fecha_final_ficha">Nombre del proyecto</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <input class="btn btn-primary py-2" type="submit" name="Formulario" value="Descargar" style="width: 100px;">
                        </div>
                    </form>
                </div>
            </div>
         </div>
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

<script src="./js/index.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

</body>
<script src="../../temp.js"></script>
</html>

