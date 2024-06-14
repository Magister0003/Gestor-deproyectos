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
            // Aquí puedes manejar la respuesta del servidor, por ejemplo, mostrar un mensaje de éxito o error
            alert(this.responseText);
            
            limpiarCamposFormulario()
          
            
        }
    };
    xhttp.open("POST", "php/editarProyecto.php", true);
    xhttp.send(formData);
}

