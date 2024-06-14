// Función para obtener parámetros de la URL
function obtenerParametroUrl(nombre) {
    nombre = nombre.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + nombre + '=([^&#]*)');
    var resultados = regex.exec(location.search);
    return resultados === null ? '' : decodeURIComponent(resultados[1].replace(/\+/g, ' '));
}

// Función para mostrar los archivos de un proyecto específico
function mostrarArchivos(idProyecto) {
    fetch(`php/getArchivos.php?idProyecto=${idProyecto}`)
    .then(response => response.json())
    .then(archivos => {
         console.log("Archivos recibidos:", archivos); // Imprime para depuración
        
        const contenedorArchivos = document.getElementById('listaArchivos');
        contenedorArchivos.innerHTML = '';

        let nombreProyectoMostrado = false;

        archivos.forEach(archivo => {
            const divArchivo = document.createElement('div');

            // Mostrar el nombre del proyecto solo una vez
            if (!nombreProyectoMostrado) {
                const tituloProyecto = document.createElement('h2');
                tituloProyecto.textContent = archivo.nombre; // Asegúrate de que 'nombre_proyecto' es el campo correcto
                contenedorArchivos.appendChild(tituloProyecto);
                nombreProyectoMostrado = true;
            }

            // Añadir el nombre de la tarea
            const nombreTarea = document.createElement('div');
            nombreTarea.textContent = archivo.nombre_tarea; // Asegúrate de que 'nombre_tarea' es el campo correcto
            divArchivo.appendChild(nombreTarea);

            // Añadir el enlace del archivo
            const enlaceArchivo = document.createElement('a');
            enlaceArchivo.href = archivo.ruta_archivo; // Asegúrate de que 'ruta_archivo' es el campo correcto
            enlaceArchivo.textContent = archivo.nombre_archivo; // Asegúrate de que 'nombre_archivo' es el campo correcto
            enlaceArchivo.target = "_blank";
            divArchivo.appendChild(enlaceArchivo);

            // Añadir el botón de eliminar
            const botonEliminar = document.createElement('button');
            botonEliminar.textContent = 'Eliminar';
            botonEliminar.onclick = function() {
                console.log('Intentando eliminar el archivo con ID:', archivo.id); // Añade esto para depuración
                eliminarArchivo(archivo.id, divArchivo); // Asegúrate de que 'id' es el campo correcto
            };
            divArchivo.appendChild(botonEliminar);

            contenedorArchivos.appendChild(divArchivo);
        });

        // Crear y añadir el botón de "Descargar Todo"
        const botonDescargarTodo = document.createElement('button');
        botonDescargarTodo.textContent = 'Descargar Todo';
        botonDescargarTodo.onclick = function() {
            window.location.href = 'php/descargarProyecto.php?idProyecto=' + idProyecto;
        };
        contenedorArchivos.appendChild(botonDescargarTodo);
    })
    .catch(error => {
        console.error('Error al cargar los archivos:', error);
    });
}

// Ejecutar mostrarArchivos cuando la página se haya cargado completamente
document.addEventListener('DOMContentLoaded', function() {
    var idProyecto = obtenerParametroUrl('idProyecto'); // Obtén el ID del proyecto desde la URL
    if (idProyecto) {
        mostrarArchivos(idProyecto); // Llama a mostrarArchivos con el ID del proyecto
    } else {
        console.error('ID del proyecto no proporcionado');
    }
});
