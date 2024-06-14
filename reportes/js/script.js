//script.js

    //Cargar todos los proyectos
    document.addEventListener("DOMContentLoaded", function() {
    cargarProyectos(); // Cargar todos los proyectos al iniciar

    //Cargar todos los proyectos por nombre Cliente
    document.getElementById('filtroCliente').addEventListener('change', function() {
        const nombreCliente = this.value;
        cargarProyectos(nombreCliente); // Llama a cargarProyectos con el nombre del cliente
    });
    
    //Cargar todos los proyectos por nombre comercial
    document.getElementById('comercial').addEventListener('change', function() {
    const nombreComercial = this.value;
    cargarProyectos('', nombreComercial); // Llama a cargarProyectos con el nombre del comercial
      });
     // Cargar todos los proyectos por estado
    document.getElementById('filtroEstado').addEventListener('change', function() {
        const estadoProyecto = this.value;
        cargarProyectos('', '', estadoProyecto); // Llama a cargarProyectos con el estado seleccionado
    });
     // Nuevo evento para filtrar por número de factura
    document.getElementById('filtroFactura').addEventListener('input', function() {
        const numeroFactura = this.value;
        cargarProyectos('', '', '', numeroFactura); // Actualizado para incluir el número de factura
    });
    // Nuevo evento para filtrar por orden de compra
    document.getElementById('filtroOrdenCompra').addEventListener('input', function() {
    const ordenCompra = this.value;
    cargarProyectos('', '', '', '', ordenCompra); // Asegúrate de actualizar los argumentos según sea necesario
});
    });

    //function cargarProyectos(nombreCliente = '', nombreComercial = '') {
    //function cargarProyectos(nombreCliente = '', nombreComercial = '', estadoProyecto = '', numeroFactura = '') {
    function cargarProyectos(nombreCliente = '', nombreComercial = '', estadoProyecto = '', numeroFactura = '', ordenCompra = '') {    
    let url = 'php/getProyectos.php';
    
    //Agregar el parámetro "nombreCliente"
    if (nombreCliente) {
        url += '?nombreCliente=' + encodeURIComponent(nombreCliente);
    }
    //Agregar el parámetro "nombreComercial"
    if (nombreComercial) {
        url += (nombreCliente ? '&' : '?') + 'nombreComercial=' + encodeURIComponent(nombreComercial);
    }

    // Agregar el parámetro "estadoProyecto"
    if (estadoProyecto) {
        url += ((nombreCliente || nombreComercial) ? '&' : '?') + 'estadoProyecto=' + encodeURIComponent(estadoProyecto);
    }

    // Agregar el parámetro "numeroFactura"
    if (numeroFactura) {
        url += ((nombreCliente || nombreComercial || estadoProyecto) ? '&' : '?') + 'numeroFactura=' + encodeURIComponent(numeroFactura);
    }
    // Agregar el parámetro "ordenCompra"
    if (ordenCompra) {
        url += ((nombreCliente || nombreComercial || estadoProyecto || numeroFactura) ? '&' : '?') + 'ordenCompra=' + encodeURIComponent(ordenCompra);
    }
    
    fetch(url)
    .then(response => response.json())
    .then(proyectos => {
   
   ////////Prueba
         // Filtrar los proyectos aquí basándose en las fechas "desde" y "hasta"
        const fechaDesde = document.getElementById('filtroFechaDesde').value;
        const fechaHasta = document.getElementById('filtroFechaHasta').value;

        let proyectosFiltrados = proyectos;

        if (fechaDesde) {
            const fechaDesdeParsed = new Date(fechaDesde);
            proyectosFiltrados = proyectosFiltrados.filter(proyecto => {
                const fechaInicioProyecto = new Date(proyecto.fecha_inicio);
                return fechaInicioProyecto >= fechaDesdeParsed;
            });
        }

        if (fechaHasta) {
            const fechaHastaParsed = new Date(fechaHasta);
            proyectosFiltrados = proyectosFiltrados.filter(proyecto => {
                const fechaInicioProyecto = new Date(proyecto.fecha_inicio);
                return fechaInicioProyecto <= fechaHastaParsed;
            });
        }
//*************************************************
   
   
        mostrarProyectos(proyectosFiltrados);
   })
    .catch(error => console.error('Error:', error));
}

function agregarEventosToggle() {
    document.querySelectorAll('.toggle-lista').forEach(item => {
        item.addEventListener('click', function() {
            const listaTareas = this.nextElementSibling;
            if (listaTareas.style.display === "none") {
                listaTareas.style.display = "block";
            } else {
                listaTareas.style.display = "none";
            }
        });
    });
}


function actualizarEstadoTarea(idTarea, completada) {
    const estado = completada ? 1 : 0;
    const datosAEnviar = { idTarea: idTarea, completada: estado };

    console.log('Datos enviados:', datosAEnviar); // Agrega esta l��nea para depuraci��n

    fetch('php/actualizarEstadoTarea.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(datosAEnviar)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Estado de la tarea actualizado:', data);
    })
    .catch(error => console.error('Error:', error));
}

// Funci��n para mostrar los proyectos en el frontend
function mostrarProyectos(proyectos) {
    const contenedorProyectos = document.getElementById('proyectos');
    contenedorProyectos.innerHTML = '';

    if (!proyectos || !Array.isArray(proyectos)) {
        console.error('La respuesta no es un arreglo o está indefinida:', proyectos);
        contenedorProyectos.innerHTML = '<p>No se encontraron proyectos para mostrar.</p>';
        return;
    }

    proyectos.forEach(proyecto => {
        const divProyecto = document.createElement('div');
        divProyecto.classList.add('proyecto','col-sm-3', 'card', 'p-2', 'mb-2'); // Ajuste del tamaño de la tarjeta
        

        // Comparar la fecha de finalización del proyecto con la fecha actual
        const fechaFinProyecto = new Date(proyecto.fecha_fin);
        const fechaActual = new Date();

        if (fechaFinProyecto < fechaActual && proyecto.estado !== "Finalizado") {
            divProyecto.style.backgroundColor = '#ffcccc'; // Rojo claro
        } else if (proyecto.estado === "Finalizado") {
            divProyecto.style.backgroundColor = '#ccffcc'; // Verde claro
        } else if (proyecto.estado === "En Pausa") {
            divProyecto.style.backgroundColor = '#ffffcc'; // Amarillo claro
        }

        divProyecto.innerHTML = `
            <div class="d-flex justify-content-end">
            <p class="card-text">Factura: <span class="sp">${proyecto.numero_factura ? proyecto.numero_factura : 'N/A'}</span></p>
                
            </div>
            <p class="card-title"># Liquidación: <span class="sp">${proyecto.orden_compra ? proyecto.orden_compra : 'N/A'}</span></p>
            <h6>${proyecto.nombre}</h6>
            <p class="card-text">Cliente: ${proyecto.cliente}</p>
            <p class="card-text">Comercial: ${proyecto.comercial}</p>
            <div class="d-flex justify-content-between align-items-center toggle-lista">
            <p class="card-text">Fecha de Culminación: ${proyecto.fecha_fin}</p>
            <span class="toggle-tareas"><i class="fa fa-list" aria-hidden="true"></i></span>
            </div>
        `;

        const listaTareas = document.createElement('ul');
        listaTareas.classList.add('lista-tareas');

        proyecto.tareas.forEach(tarea => {
            const tareaItem = document.createElement('li');
            tareaItem.classList.add('list-group-item', 'p-1', 'd-flex');

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.checked = tarea.completada == 1;
            checkbox.disabled = true;

            const enlaceTarea = document.createElement('a');
            enlaceTarea.href = `php/subirDocumento.php?idTarea=${encodeURIComponent(tarea.id)}&tarea=${encodeURIComponent(tarea.nombre)}&proyecto=${encodeURIComponent(proyecto.nombre)}`;
            enlaceTarea.textContent = tarea.nombre;
            enlaceTarea.classList.add('ms-1');
            enlaceTarea.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = this.href;
            });

            tareaItem.appendChild(checkbox);
            tareaItem.appendChild(enlaceTarea);
            listaTareas.appendChild(tareaItem);
        });

        divProyecto.appendChild(listaTareas);

        const enlaceVisualizarArchivos = document.createElement('a');
        enlaceVisualizarArchivos.href = `visualizarArchivos.html?idProyecto=${proyecto.id}`;
        enlaceVisualizarArchivos.textContent = 'Ver Archivos del Proyecto';
        enlaceVisualizarArchivos.classList.add('btn', 'btn-primary', 'mt-2');
        divProyecto.appendChild(enlaceVisualizarArchivos);

        const barraProgreso = document.createElement('div');
        barraProgreso.classList.add('barra-progreso', 'progress', 'mt-3');
        const progreso = document.createElement('div');
        progreso.classList.add('progreso', 'progress-bar');
        progreso.style.width = '0%';
        barraProgreso.appendChild(progreso);
        divProyecto.appendChild(barraProgreso);

        contenedorProyectos.appendChild(divProyecto);
        actualizarProgreso(divProyecto, proyecto.tareas);
    });

    agregarEventosToggle();
}



//Barra de progreso
function actualizarProgreso(divProyecto, tareas) {
    // Calcular el porcentaje de tareas completadas
    const tareasCompletadas = tareas.filter(tarea => tarea.completada == 1).length;
    const totalTareas = tareas.length;
    const porcentaje = (tareasCompletadas / totalTareas) * 100;

    // Establecer el ancho de la barra de progreso para reflejar las tareas completadas
    const progreso = divProyecto.querySelector('.progreso');
    if (progreso) {
        progreso.style.width = porcentaje + '%';
    }
}

// Evento para manejar la creación de un nuevo proyecto
document.addEventListener("DOMContentLoaded", function() {
document.getElementById('nuevoProyectoForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const nombreProyecto = document.getElementById('nombreProyecto').value;

    // Enviar solicitud para crear nuevo proyecto
    fetch('php/crearProyecto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'nombreProyecto=' + encodeURIComponent(nombreProyecto)
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        cargarProyectos(); // Recargar la lista de proyectos
    })
    .catch(error => console.error('Error:', error));
});

});


// Cargar proyectos al iniciar
//window.onload = cargarProyectos;



