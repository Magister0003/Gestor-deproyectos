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

        // Crear contenedor responsive
        const contenedorResponsive = document.createElement('div');
        contenedorResponsive.classList.add('m-0');

        // Crear tabla
        const tabla = document.createElement('table');
        tabla.classList.add('table', 'table-striped', 'table-sm');

        // Crear encabezado de tabla
        const encabezadoTabla = document.createElement('thead');
        encabezadoTabla.innerHTML = `
            <tr>
                <th>Proyecto</th>
                <th>Tarea</th>
                <th>Archivo</th>
                <th>Eliminar</th>
            </tr>
        `;
        tabla.appendChild(encabezadoTabla);

        // Crear cuerpo de tabla
        const cuerpoTabla = document.createElement('tbody');

        archivos.forEach(archivo => {
            const fila = document.createElement('tr');

            // Mostrar el nombre del proyecto solo una vez
            if (!nombreProyectoMostrado) {
                const tituloProyecto = document.createElement('td');
                tituloProyecto.textContent = archivo.nombre; // Asegúrate de que 'nombre_proyecto' es el campo correcto
                fila.appendChild(tituloProyecto);
                nombreProyectoMostrado = true;
            } else {
                fila.innerHTML = '<td></td>'; // Dejar un espacio en blanco para las filas siguientes del mismo proyecto
            }

            // Añadir el nombre de la tarea
            const nombreTarea = document.createElement('td');
            nombreTarea.textContent = archivo.nombre_tarea; // Asegúrate de que 'nombre_tarea' es el campo correcto
            fila.appendChild(nombreTarea);

            // Añadir el enlace del archivo
            const enlaceArchivo = document.createElement('td');
            const enlace = document.createElement('a');
            enlace.href = archivo.ruta_archivo; // Asegúrate de que 'ruta_archivo' es el campo correcto
            enlace.textContent = archivo.nombre_archivo; // Asegúrate de que 'nombre_archivo' es el campo correcto
            enlace.target = "_blank";
            enlaceArchivo.appendChild(enlace);
            fila.appendChild(enlaceArchivo);

            // Añadir el icono de eliminar
            const columnaEliminar = document.createElement('td');
            const iconoEliminar = document.createElement('i');
            iconoEliminar.classList.add('bi', 'bi-trash');
            iconoEliminar.style.cursor = "pointer";
            iconoEliminar.style.color = "red";
            iconoEliminar.onclick = function() {
                console.log('Intentando eliminar el archivo con ID:', archivo.id); // Añade esto para depuración
                eliminarArchivo(archivo.id, fila); // Asegúrate de que 'id' es el campo correcto
            };
            columnaEliminar.appendChild(iconoEliminar);
            fila.appendChild(columnaEliminar);

            cuerpoTabla.appendChild(fila);
        });

        tabla.appendChild(cuerpoTabla);
        contenedorResponsive.appendChild(tabla);
        contenedorArchivos.appendChild(contenedorResponsive);

        const colsm12 = document.createElement('div');
        colsm12.classList.add('col-sm-12', 'text-center');

        // Crear y añadir el botón de "Descargar Todo"
        const botonDescargarTodo = document.createElement('button');
        botonDescargarTodo.classList.add('btn', 'btn-primary');
        botonDescargarTodo.textContent = 'Descargar Todo';
        botonDescargarTodo.onclick = function() {
            window.location.href = 'php/descargarProyecto.php?idProyecto=' + idProyecto;
        };
        colsm12.appendChild(botonDescargarTodo);
        contenedorArchivos.appendChild(colsm12);
        
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
