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
    <title>Agregar Comercial</title>
        <!-- Google Web Fonts -->
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            <span class="material-icons-sharp" >
                    add
            </span>
                <h3>Formulario comercial</h3>
            </a>
            
            
            <a href="mostrar_comerciales.php">
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Vista Comercial</h3>
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
            
            <h1 class="mb-3 ms-3">Comercial</h1>
            <div class="container mt-5 d-grid">
                <form action="./php/agregar_comercial.php" method="post" class="row g-3 mt-3">
                    <input type="hidden" id="idComercial" name="idComercial">
                
                    <div class="col-sm-5">
                        <div class="form-floating">
                            <input type="text" id="cedula" name="cedula" class="form-control" placeholder="Cedula:" required oninput="buscarComercialPorCedula()">
                            <label for="cedula">Cedula:</label>
                        </div>
                    </div>
                
                    <div class="col-sm-5">
                        <div class="form-floating">
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre:" required>
                            <label for="nombre">Nombre:</label>
                        </div>
                    </div>
                
                    <div class="col-sm-3">
                        <div class="form-floating">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email:" required>
                            <label for="email">Email:</label>
                        </div>
                    </div>
                
                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" id="telefono" name="telefono" placeholder="Teléfono:" class="form-control">
                            <label for="telefono">Teléfono:</label>
                        </div>
                    </div>
                
                    <div class="col-sm-3">
                        <div class="form-floating">
                            <input type="date" id="fecha_contratacion" name="fecha_contratacion" class="form-control">
                            <label for="fecha_contratacion">Fecha de Contratación:</label>
                        </div>
                    </div>
                
                    <div class="col-sm-10">
                        <div class="form-floating">
                            <textarea id="otros_datos" name="otros_datos" class="form-control" style="height: 150px;"></textarea>
                            <label for="otros_datos">Otros Datos:</label>
                        </div>
                    </div>
                
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
                
                <button type="button" id="btnEditar" onclick="editarComercial()" style="display:none;">Editar Comercial</button>
                
                <script>
                function buscarComercialPorCedula() {
                var cedula = document.getElementById('cedula').value;
                if (cedula) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'buscar_comercial_por_cedula.php?cedula=' + cedula, true);
                    xhr.onload = function() {
                        if (this.status == 200) {
                            var respuesta = JSON.parse(this.responseText);
                            if (respuesta.encontrado) {
                                document.getElementById('idComercial').value = respuesta.id;
                                document.getElementById('nombre').value = respuesta.nombre;
                                document.getElementById('email').value = respuesta.email;
                                document.getElementById('telefono').value = respuesta.telefono;
                                document.getElementById('fecha_contratacion').value = respuesta.fecha_contratacion;
                                document.getElementById('otros_datos').value = respuesta.otros_datos;
                                 // Mostrar el botón de editar
                                document.getElementById('btnEditar').style.display = 'block'; // Asegúrate de que este ID coincide con el del botón en tu HTML
                            } else {
                                console.log('Comercial no encontrado');
                                // Opcional: Limpiar los campos si se desea cuando no se encuentra el comercial
                            }
                        }
                    };
                    xhr.send();
                }
            }
            function editarComercial() {
                var form = document.querySelector('form');
                form.action = 'editar_comercial.php'; // URL del script PHP que maneja la edición
                form.method = 'POST';
                form.submit();
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
    </html>

</body>
<script src="../../temp.js"></script>
</html>
