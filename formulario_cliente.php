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
                    <h3>Formulario cliente</h3>
                </a>
                

            <a href="mostrar_clientes.php">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Vista Clientes</h3>
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
    
        <main class="px-1">
            
            <h1 class="mb-3 ms-3">Agregar Cliente</h1>
            <div class="container mt-5 d-grid">
            <form action="./php/agregar_cliente.php" method="post" class="row gap-3 mt-3">
             <!--   <div class="col-sm-7">
                    <div class="form-floating">
                        <input class="form-control" type="text" id="idClienteBuscar" name="idCliente" placeholder="ID Cliente (para búsqueda):" oninput="buscarClientePorId()">
                        <label for="idCliente">ID Cliente (para búsqueda):</label>
                    </div>
                </div>-->

                <div class="col-sm-7">
                    <div class="form-floating">
                        <input class="form-control" type="text" id="nombre_cliente" name="nombre" placeholder="Nombre:" required>
                        <label for="nombre">Nombre:</label>
                    </div>
                </div>

                <div class="col-sm-7">
                    <div class="form-floating">
                        <input class="form-control" type="email" id="correo_electronico" name="correo_electronico" placeholder="Correo Electrónico:" required>
                        <label for="correo_electronico">Correo Electrónico:</label>
                    </div>
                </div>

                <div class="col-sm-7">
                    <div class="form-floating">
                        <input class="form-control" type="text" id="telefono" name="telefono" placeholder="Teléfono:">
                        <label for="telefono">Teléfono:</label>
                    </div>
                </div>

                <div class="col-sm-12 text-center">
                    <button class="btn btn-primary" type="submit">Agregar Cliente</button>
                </div>
            </form>
            
            <script>
            function buscarClientePorId() {
                var idCliente = document.getElementById('idClienteBuscar').value; // Cambio para usar idClienteBuscar
                if (idCliente) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'buscar_cliente_por_id.php?idCliente=' + idCliente, true);
                    xhr.onload = function() {
                        if (this.status == 200) {
                            var respuesta = JSON.parse(this.responseText);
                            if (respuesta.encontrado) {
                                document.getElementById('nombre_cliente').value = respuesta.nombre;
                                document.getElementById('correo_electronico').value = respuesta.correo_electronico;
                                document.getElementById('telefono').value = respuesta.telefono;
                                // Asegúrate de que todos estos IDs existan en tu formulario
                            } else {
                                console.log('Cliente no encontrado');
                            }
                        }
                    };
                    xhr.send();
                }
            }
            </script>
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
    
