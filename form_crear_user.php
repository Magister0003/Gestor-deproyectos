<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario CSS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">

</head>

<body>

    <div class="contenedor-formulario contenedor">
        <div class="imagen-formulario">
        </div>

        <form action="./procesos/proceso_Crear_login.php" method="post" class="formulario" enctype="multipart/form-data">
            <div class="texto-formulario">
                <article>
                <img src="./img/logo.png" alt="logo" class="logo">
                </article>
                <p>Crea tu cuenta</p>
            </div>


            <div class="user-input-box select">
            <label for="username">Usuario:</label>
            <input placeholder="Ingresa tu Nombre de usuario" type="text" id="username" name="username" required>
            </div>

            <div class="user-input-box select">
            <label for="username">Email:</label>
            <input placeholder="Ingresa tu Nombre de usuario" type="email" id="email" name="email" required>
            </div>

            <div class="user-input-box">
                <label for="password">Contraseña</label>
                <input placeholder="Ingresa tu contraseña" type="password" id="password" name="password" required>
            </div>

            <label for="username">Foto de perfil:</label>
            <input placeholder="Ingresa tu Nombre de usuario" type="file" id="archivo" name="archivo" accept="image/*" required>

            <div class="input">
                <input type="submit" value="Crear">
            </div>

            <div class="password-olvidada">
                <a href="form_login.php">Iniciar sesión </a>
            </div>

        </form>
    </div>
    
</body>

</html>