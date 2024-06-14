<?php
include './php/conexion.php';


        session_start(); // Iniciar la sesi®Æn
        
        // Obtener los valores de la sesi®Æn
        $username = $_SESSION['username'];
        $access_level = $_SESSION['access_level'];
        $email = $_SESSION['email'];
        $archivo = $_SESSION['archivo'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Comerciales</title>
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
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
                <h3>Vista Clientes</h3>
            </a>

        
            <a href="formulario_cliente.php">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Formulario cliente</h3>
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
        <h1 class="mb-3 ms-3">Clientes</h1>
            
        <div class="container mt-5">
        <?php
        $sql = "SELECT id_cliente, nombre_cliente, correo_electronico, telefono, fecha_creacion FROM clientes";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            echo '<table class="table table-sm">';
            echo '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Tel√©fono</th>
                        <th>Fecha de Contrataci√≥n</th>
                        
                    </tr>
                  </thead>';
            echo '<tbody>';
            while($row = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["id_cliente"]."</td>
                        <td>".$row["nombre_cliente"]."</td>
                        <td>".$row["correo_electronico"]."</td>
                        <td>".$row["telefono"]."</td>
                        <td>".$row["fecha_creacion"]."</td>
                        
                      </tr>";
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo "0 resultados";
        }

        
        $conn->close();
        ?>
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
