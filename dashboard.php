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
    <link href="logo.png" rel="icon">

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
        <style>
        .list-group-item{
            background-color: transparent !important;
            border: none !important;
        }
    </style>
</head>
<body>

<div class="c">
    <aside>
        <div class="toggle">
        
                <img src="logo.png">
            
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
                <h3>Dashboard</h3>
            </a>
            <a href="index.php" >
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Crear Proyecto</h3>
            </a>
            
            <a href="./graficos" >
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Gráficos</h3>
            </a>
            
            <a href="./reportes/index.php">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Reportes</h3>
            </a>
            
            <a href="../../admin.php">
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
        <h1 class="mb-3 ms-3">Gestor de Documentos de Proyectos</h1>
            
        <div class="container mb-3">

            
                <div class="row g-1">
                    <!-- Filtros -->
                    <div class="col-sm-3">
                        <div class="form-floating">
                        <select id="filtroCliente" class="form-select">
                            <option value=""></option>
                            <!-- Las opciones se cargarán dinámicamente -->
                            <?php
                                include './php/conexion.php'; // Asume que este archivo realiza la conexión a tu base de datos

                                $query = "SELECT id_cliente, nombre_cliente FROM clientes"; // Ajusta estos nombres de campo y tabla según tu base de datos
                                 $result = $conn->query($query);

                                 if ($result->num_rows > 0) {
                                 while($row = $result->fetch_assoc()) {
                                   // Usa el nombre_cliente como el valor
                                   echo "<option value='" . htmlspecialchars($row["nombre_cliente"], ENT_QUOTES) . "'>" . $row["nombre_cliente"] . "</option>";
                                   }
                                 } else {
                                 echo "<option>No hay clientes disponibles</option>";
                                 }
                                 $conn->close();
                             ?>
                        </select>
                        <label for="filtroCliente">Filtrar por cliente:</label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-floating">
                        <select id="comercial" name="comercial" class="form-select">
                            <option value=""></option>
                            <!-- Las opciones se cargarán dinámicamente -->
                            <?php
                                include './php/conexion.php'; // Asume que este archivo realiza la conexión a tu base de datos

                                $query = "SELECT id, nombre FROM comerciales"; // Ajusta estos nombres de campo y tabla según tu base de datos
                                 $result = $conn->query($query);

                                 if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                   // Usa el nombre_comercial como el valor
                                    echo "<option value='" . htmlspecialchars($row["nombre"], ENT_QUOTES) . "'>" . $row["nombre"] . "</option>";
                                      }
                                     } else {
                                       echo "<option>No hay comerciales disponibles</option>";
                                     }
                                 $conn->close();
                                 ?>
                        </select>
                        <label for="comercial" class="form-label">Comercial:</label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-floating">
                        <select id="filtroEstado" name="filtroEstado" class="form-select">
                            <option value=""></option>
                            <option value="En proceso de compra">En proceso de compra</option>
                            <option value="Entregado al cliente">Entregado al cliente</option>
                            <option value="Factura pendiente de pago">Factura pendiente de pago</option>
                            <option value="Pendiente por facturar">Pendiente por facturar</option>
                            <option value="Factura abonada">Factura abonada</option>
                            <option value="Finalizada">Finalizada</option>
                        </select>
                        <label for="filtroEstado" class="form-label">Filtrar por estado:</label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-floating">
                            <input type="text" id="filtroFactura" name="filtroFactura" class="form-control" placeholder="Ingrese Número de Factura">
                            <label for="filtroFactura">Filtrar por número de factura:</label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-floating">
                            <input type="text" id="filtroOrdenCompra" name="filtroOrdenCompra" class="form-control" placeholder="Ingrese Orden de Compra">
                            <label for="filtroOrdenCompra">Filtrar por Orden de Compra:</label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-floating">
                            <select id="filtroempresa_emisora" name="filtroempresa_emisora" class="form-select">
                            <option value=""></option>
                            <option value="Integratic SAS">Integratic SAS</option>
                            <option value="Pcsyportatiles">Pcsyportatiles</option>
                            <!-- Añade más opciones según sea necesario -->
                            </select>
                            <label for="filtroempresa_emisora">Empresa emisora de facturas:</label>
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="form-floating">
                            <input type="date" id="filtroFechaDesde" name="filtroFechaDesde" class="form-control">
                            <label for="filtroFechaDesde">Desde:</label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-floating">
                            <input type="date" id="filtroFechaHasta" name="filtroFechaHasta" class="form-control">
                            <label for="filtroFechaHasta" class="form-label">Hasta:</label>
                        </div>
                    </div>

                    <div class="col-sm-3 d-flex align-items-end">
                        
                    </div>

                </div>
        </div>
                <form id="nuevoProyectoForm">
                    <!-- Formulario de nuevo proyecto -->
                </form>
            <div class="container h p-0 m-0">

            
                <section id="proyectos" class="row g-0 p-0 w-100">
                <!-- Sección para mostrar los proyectos -->
                <!-- Los proyectos se cargarán dinámicamente aquí mediante JavaScript -->
                </section>
            </div>
            <script src="js/script.js"></script> <!-- Tu archivo JavaScript -->
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
