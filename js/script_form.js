// Define la variable timer fuera de tu función
let timer;

function buscarProyectoPorOrdenCompra() {
    var ordenCompra = document.getElementById('orden_compra').value;
    
    // Limpia el timer existente para reiniciar el retraso
    clearTimeout(timer)
    
     // Establece un nuevo timer
    timer = setTimeout(function() {
        if (ordenCompra.length === 0) {
            // Opcional: limpiar los campos del formulario si el input está vacío
            return;
        }


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (!respuesta.error) {
                // Rellenar los campos del formulario con la respuesta
                document.getElementById('id').value = respuesta.id || '';
                document.getElementById('responsable').value = respuesta.responsable || '';
                document.getElementById('nombre').value = respuesta.nombre || '';
                document.getElementById('cliente').value = respuesta.cliente || '';
                document.getElementById('comercial').value = respuesta.comercial || '';
                document.getElementById('empresa_emisora').value = respuesta.empresa_emisora || '';
                
                //document.getElementById('estado').value = respuesta.estado || '';
                
                // Actualiza el estado solo si la respuesta incluye un valor para estado
                if (respuesta.estado) {
                document.getElementById('estado').value = respuesta.estado;
                 } else {
                document.getElementById('estado').value = 'Activo';
                }
                
                document.getElementById('fecha_inicio').value = convertirFecha(respuesta.fecha_inicio);
                document.getElementById('fecha_fin').value = convertirFecha(respuesta.fecha_fin);
                document.getElementById('vencimiento_factura').value = convertirFecha(respuesta.vencimiento_factura);
                
                //document.getElementById('fecha_inicio').value = respuesta.fecha_inicio || '';
                //document.getElementById('fecha_inicio').value = respuesta.fecha_inicio !== '0000-00-00' ? respuesta.fecha_inicio : '';
                //document.getElementById('fecha_fin').value = respuesta.fecha_fin || '';
                //document.getElementById('fecha_fin').value = respuesta.fecha_fin !== '0000-00-00' ? respuesta.fecha_fin : '';
                //document.getElementById('vencimiento_factura').value = respuesta.vencimiento_factura || '';
                //document.getElementById('vencimiento_factura').value = respuesta.vencimiento_factura !== '0000-00-00' ? respuesta.vencimiento_factura : '';
                
                document.getElementById('descripcion').value = respuesta.descripcion || '';
                // Deshabilita el botón de "Crear Proyecto" si se encontró un proyecto
                document.getElementById('botonCrearProyecto').disabled = true;
                
                

                
                // Asegúrate de ajustar los identificadores y nombres según tu HTML
            } else {
                // Manejar el caso de error o limpiar los campos
                //alert(respuesta.error);
                if (respuesta.limpiarCampos) {
                        limpiarCamposFormulario();
                    }
            }
        }
    };
    xhttp.open("POST", "php/buscarProyectoPorOrdenCompra.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("orden_compra_busqueda=" + ordenCompra);

    }, 500); // Espera 500 ms antes de ejecutar la búsqueda
}

function limpiarCamposFormulario() {
    document.getElementById('id').value = '';
    document.getElementById('responsable').value = '';
    document.getElementById('orden_compra').value = '';
    document.getElementById('nombre').value = '';
    document.getElementById('cliente').value = '';
    
    // Establece el <select> de "estado" a "Activo"
    document.getElementById('estado').value = 'Activo';
    document.getElementById('empresa_emisora').value = '';
    document.getElementById('comercial').value = '';
    document.getElementById('fecha_inicio').value = '';
    document.getElementById('fecha_fin').value = '';
    document.getElementById('vencimiento_factura').value = '';
    document.getElementById('descripcion').value = '';
    document.getElementById('botonCrearProyecto').disabled = false; // Re-habilita el botón de "Crear Proyecto"
    // Asegúrate de ajustar los identificadores y nombres según tu HTML
}

// Función para convertir fechas en formato 'AAAA-MM-DD' o retornar cadena vacía si no es válida
    function convertirFecha(fecha) {
        return fecha && fecha !== '0000-00-00' ? fecha : '';
    }

    function editarProyecto() {
        var formData = new FormData(document.getElementById('nuevoProyectoForm'));
    
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Reemplaza la alerta con el HTML personalizado
                var alertHTML = '  <head>\
                                    <meta charset="UTF-8">\
                                    <title>Agregar Cliente</title>\
                                    <!-- Google Web Fonts -->\
                                    <link rel="preconnect" href="https://fonts.googleapis.com">\
                                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>\
                                    <meta content="width=device-width, initial-scale=1.0" name="viewport">\
                                    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">\
                                    <!-- Icon Font Stylesheet -->\
                                    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">\
                                    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">\
                                    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">\
                                    <!-- Customized Bootstrap Stylesheet -->\
                                    <link href="../css/bootstrap.min.css" rel="stylesheet">\
                                </head>\
                                <style>\
                                   /* Estilos para el contenedor principal */\
                                   .conten {\
                                       position: absolute;\
                                       top: 1px;\
                                       left: 1px;\
                                       display: flex;\
                                       justify-content: center;\
                                       align-items: center;\
                                       height: 100vh;\
                                       width: 100%;\
                                       background-color: #fff;\
                                   }\
                                   /* Estilos para la tarjeta */\
                                   .card {\
                                       width: 400px;\
                                       height: 300px;\
                                       display: flex;\
                                       justify-content: center;\
                                       align-items: center;\
                                       border: 1px solid #ccc;\
                                       border-radius: 5px;\
                                       box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);\
                                   }\
                                   .card-body {\
                                    display: grid;\
                                    justify-content: center;\
                                    align-items: center;\
                                   }\
                                   /* Estilos para el ícono de verificación */\
                                   .icon-container {\
                                       border-radius: 50%;\
                                       background-color: green;\
                                       width: 100px;\
                                       height: 100px;\
                                       display: flex;\
                                       justify-content: center;\
                                       align-items: center;\
                                       margin: 0 auto 20px;\
                                   }\
                                   /* Estilos para el ícono de verificación */\
                                   .icon {\
                                       font-size: 48px;\
                                   }\
                                </style>\
                                <div class="conten">\
                                   <div class="card">\
                                       <div class="card-body">\
                                           <div class="icon-container">\
                                               <i class="fas fa-check icon"></i>\
                                           </div>\
                                           <h5 class="card-title">Actualizacion Exitoso</h5>\
                                           <a class="btn btn-primary m-2" href="./dashboard.php">OK</a>\
                                       </div>\
                                   </div>\
                                </div>\
                                <!-- Incluye la biblioteca Font Awesome para el ícono -->\
                                <script src="https://kit.fontawesome.com/a076d05399.js"></script>';
    
                // Mostrar el HTML personalizado
                document.body.innerHTML += alertHTML;
                
                // Limpia los campos del formulario
                limpiarCamposFormulario();
            }
        };
        xhttp.open("POST", "./php/editarProyecto.php", true);
        xhttp.send(formData);
    }
    