<?php
        session_start(); // Iniciar la sesión
        
        // Obtener los valores de la sesión
        $username = $_SESSION['username'];
        $user = $_SESSION['username'];
        $access_level = $_SESSION['access_level'];
        $email = $_SESSION['email'];
        $archivo = $_SESSION['archivo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Proyecto</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Asume que tienes un archivo CSS para estilos -->
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
    <link href="index.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
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
                <h3>Crear Proyecto</h3>
            </a>

            <a href="dashboard.php">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Dashboard</h3>
            </a>
            
            <a href="./graficos">
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
                <p><b style="font-size: 0.70rem !important;"><?php echo $username; ?></b></p>
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
    
    <main>
    <h1 class="mb-5">Crear proyecto</h1>
    <form id="nuevoProyectoForm" action="./php/crearProyecto.php" method="post" class="row g-3">
        
            <input type="hidden" id="id" name="id">
        
 
            <input value="<?php echo $username; ?>" type="hidden" id="responsable" name="responsable">


            <div class="col-sm-4">
                <div class="form-floating ">
                    <input type="text" class="form-control" id="orden_compra" name="orden_compra" placeholder="# Proyecto" oninput="buscarProyectoPorOrdenCompra()">
                    <label for="orden_compra"># Proyecto</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-floating ">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Descripción del Proyecto" required>
                    <label for="nombre">Descripción del Proyecto</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-floating ">
                    <select class="form-select" id="cliente" name="cliente" aria-label="Seleccionar un Cliente">
                        <option value="" disabled selected>Seleccionar un Cliente</option>
                        <?php
                        include './php/conexion.php';
                        $query = "SELECT id_cliente, nombre_cliente FROM clientes";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row["nombre_cliente"], ENT_QUOTES) . "'>" . $row["nombre_cliente"] . "</option>";
                            }
                        } else {
                            echo "<option>No hay clientes disponibles</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                    <label for="cliente">Cliente</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-floating ">
                    
                    <select id="comercial" name="comercial" class="form-select">
                        <option value="" disabled selected>Seleccionar un Comercial</option>
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
                    <label for="comercial">Comercial:</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-floating ">
                    <select id="estado" name="estado" class="form-select">
                    <option value="" disabled selected>Seleccionar un estado</option>
                    <option value="En proceso de compra">En proceso de compra</option>
                    <option value="Entregado al cliente">Entregado al cliente</option>
                    <option value="Factura pendiente de pago">Factura pendiente de pago</option>
                    <option value="Pendiente por facturar">Pendiente por facturar</option>
                    <option value="Factura abonada">Factura abonada</option>
                    <option value="Finalizada">Finalizada</option>
                    <!-- Añade más estados según sea necesario -->
                    </select>
                    <label for="estado">Estado del Proyecto:</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-floating ">
                    <select id="empresa_emisora" name="empresa_emisora" class="form-select">
                    <option value="" disabled selected>Seleccionar un emisor</option>
                    <option value="Integratic SAS">Integratic SAS</option>
                    <option value="Pcsyportatiles">Pcsyportatiles</option>
                    <!-- Añade más estados según sea necesario -->
                    </select>
                    <label for="estado">Empresa emisora de facturas:</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-floating ">
                    
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                    <label for="fecha_inicio">Fecha de Inicio:</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-floating ">
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                    <label for="fecha_fin">Fecha de Fin:</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-floating ">
                    
                    <input type="date" id="vencimiento_factura" name="vencimiento_factura" class="form-control">
                    <label for="vencimiento_factura">Vencimiento de Factura:</label>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-floating ">
                    <textarea id="descripcion" name="descripcion" class="form-control" style="height: 100px;"></textarea>
                    <label for="descripcion">Detalles:</label>
                </div>
            </div>
            
            <div class="col-12 text-center">
                <button  class="btn btn-primary py-2" style="width: 100px;" type="submit" name="crearProyecto">Crear</button>
                <button type="button" class="btn btn-primary py-2" style="width: 100px;" id="botonEditar" onclick="editarProyecto()">Editar</button>
            </div>
        
    </form>
   
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
    <script src="js/script_form.js"></script>
    <script src="js/index.js"></script>


        <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+D4gkOtF5y5Iz6F5twxO7K1fjH6tuU8tizsTO5d2Au3U7q2N" crossorigin="anonymous"></script>-->
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

</body>
<script src="../../temp.js"></script>
</html>
