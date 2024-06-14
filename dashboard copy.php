<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Documentos de Proyectos</title>
    <link rel="stylesheet" href="css/estilos.css"> <!-- Asegúrate de tener tu archivo de estilos CSS -->
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="logo.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

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
</head>
<body>
    <header>
        <h1>Gestor de Documentos Proyectos</h1>
    </header>

     
    <form id="nuevoProyectoForm">
        
    </form>
    <!-- Filtro por nombre de Cliente -->
    <div>
    <label for="filtroCliente">Filtrar por cliente:</label>
    <select id="filtroCliente">
        <option value="">Todos los clientes</option>
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
    </div>
    
    <!-- Filtro por nombre de Comercial -->
    <div class="campo">
        <label for="comercial">Comercial:</label>
        <select id="comercial" name="comercial">
        <option value="">Seleccionar un Comercial</option>
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
        </div>
        
    <!-- Filtro por estado del proyecto -->    
    <div>
    <label for="filtroEstado">Filtrar por estado:</label>
    <select id="filtroEstado">
        <option value="">Todos los estados</option>
        <option value="Activo">Activo</option>
        <option value="En Pausa">En Pausa</option>
        <option value="Vencido">Vencido</option>
        <option value="Finalizado">Finalizado</option>
    </select>
    </div>
    
    <!-- Filtro por número de factura -->
    <div>
    <label for="filtroFactura">Filtrar por número de factura:</label>
    <input type="text" id="filtroFactura" name="filtroFactura" placeholder="Ingrese Número de Factura">
     </div>
     
     <!-- Filtro por Orden de Compra -->
     <div>
    <label for="filtroOrdenCompra">Filtrar por Orden de Compra:</label>
    <input type="text" id="filtroOrdenCompra" name="filtroOrdenCompra" placeholder="Ingrese Orden de Compra">
    </div>
    
    
    <!-- Filtro por Rango de Fechas de Inicio -->
     <div>
    <label for="filtroFechaDesde">Mostrar proyectos desde:</label>
    <input type="date" id="filtroFechaDesde" name="filtroFechaDesde">
    </div>
    <div>
    <label for="filtroFechaHasta">Hasta:</label>
    <input type="date" id="filtroFechaHasta" name="filtroFechaHasta">
    </div>
    
    <!-- Boton para ir la pagina de creación de proyecto -->
     <div class="campo">
        <a href="index.php">
        <button type="button">Formulario</button>
        </a>
    </div>
    
    <!-- Sección para mostrar los proyectos -->
    <section id="proyectos">
        <!-- Los proyectos se cargarán dinámicamente aquí mediante JavaScript -->
       
    </section>
    
    

    <footer>
        <!-- Aquí puedes poner información del footer si lo deseas -->
    </footer>

    <script src="js/script.js"></script> <!-- Tu archivo JavaScript -->
            <!-- JavaScript Libraries -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/lightbox/js/lightbox.min.js"></script>
</body>
</html>
