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
    document.querySelectorAll('.toggle-tareas').forEach(item => {
        item.addEventListener('click', function() {
            const listaTareas = this.nextElementSibling;
            if (listaTareas.classList.contains('expandida')) {
                listaTareas.classList.remove('expandida');
                this.innerHTML = '&#9660;'; // Icono de expandir
            } else {
                listaTareas.classList.add('expandida');
                this.innerHTML = '&#9650;'; // Icono de colapsar
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
        divProyecto.classList.add('proyecto');
       
         // Comparar la fecha de finalización del proyecto con la fecha actual
         const fechaFinProyecto = new Date(proyecto.fecha_fin);
         const fechaActual = new Date();
         
         //if (fechaFinProyecto < fechaActual) {
          if (fechaFinProyecto < fechaActual && proyecto.estado !== "Finalizado") {
         // Cambiar el color de fondo si la fecha de finalización es anterior a la fecha actual
         divProyecto.style.backgroundColor = '#ffcccc'; // Rojo claro
         //divProyecto.classList.add('proyecto-vencido');
         }
         
          // Proyecto finalizado
    if (proyecto.estado === "Finalizado") {
        divProyecto.style.backgroundColor = '#ccffcc'; // Verde claro
    }
    // Proyecto en pausa
    else if (proyecto.estado === "En Pausa") {
        divProyecto.style.backgroundColor = '#ffffcc'; // Amarillo claro
    }
    // Proyecto vencido
    else if (fechaFinProyecto < fechaActual) {
        divProyecto.style.backgroundColor = '#ffcccc'; // Color para indicar vencido, por ejemplo, rojo claro
    }
         
         
         
        //Codigo de prueba******************************************************
          // Cambiar el color de fondo directamente si el estado del proyecto es "Finalizado"
       // if (proyecto.estado === "Finalizado") {
         //   divProyecto.style.backgroundColor = '#ccffcc'; // Verde claro
    //    }
        
        // Cambiar el color de fondo directamente si el estado del proyecto es "En Pausa"
     //   if (proyecto.estado === "En Pausa") {
      //  divProyecto.style.backgroundColor = '#ffffcc'; // Amarillo claro
    //    }

        //**********************************************************************
        
        
        divProyecto.innerHTML = `
        <p># Liquidación: ${proyecto.orden_compra  ? proyecto.orden_compra  : 'N/A'}</p>
        <h3>${proyecto.nombre}</h3>
        <p>Cliente: ${proyecto.cliente}</p>
        <p>Comercial: ${proyecto.comercial}</p>
        <p>Fecha de Culminación: ${proyecto.fecha_fin}</p>
        <p>Factura: ${proyecto.numero_factura  ? proyecto.numero_factura  : 'N/A'}</p>
        
        <span class="toggle-tareas">&#9660;</span>
        `;

        const listaTareas = document.createElement('ul');
        listaTareas.classList.add('lista-tareas');

        proyecto.tareas.forEach(tarea => {
            console.log('Tarea:', tarea); // Para depurar y verificar que cada tarea tiene un 'id'
            const tareaItem = document.createElement('li');

            // Crear el checkbox para la tarea
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.checked = tarea.completada == 1;       //checkbox.checked = tarea.completada; //Revisar codigo
            checkbox.disabled = false;
            
            // Intercepta el evento de clic y previene que el estado del checkbox cambie
            checkbox.addEventListener('click', function(event) {
                event.preventDefault();
            });
            
            // Crear el enlace para subir documentos
            const enlaceTarea = document.createElement('a');
            //enlaceTarea.href = `subirDocumento.php?tarea=${encodeURIComponent(tarea.nombre)}&proyecto=${encodeURIComponent(proyecto.nombre)}`;
            enlaceTarea.href = `php/subirDocumento.php?idTarea=${encodeURIComponent(tarea.id)}&tarea=${encodeURIComponent(tarea.nombre)}&proyecto=${encodeURIComponent(proyecto.nombre)}`;
            console.log("ID Tarea:", tarea.id); // Depuraci��n para ver el ID de la tarea

            enlaceTarea.textContent = tarea.nombre;
           
            
            enlaceTarea.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = this.href;
            });

            tareaItem.appendChild(checkbox);
            tareaItem.appendChild(enlaceTarea);
            listaTareas.appendChild(tareaItem);
            
        });

        divProyecto.appendChild(listaTareas);
        
        // Crear y a�0�9adir un enlace para visualizar los archivos del proyecto
        const enlaceVisualizarArchivos = document.createElement('a');
        enlaceVisualizarArchivos.href = `../visualizarArchivos.html?idProyecto=${proyecto.id}`;
        //enlaceSubirDocumento.href = `subirDocumento.php?idTarea=${encodeURIComponent(tarea.id)}&proyecto=${encodeURIComponent(proyecto.nombre)}`;
        enlaceVisualizarArchivos.textContent = 'Ver Archivos del Proyecto';
        divProyecto.appendChild(enlaceVisualizarArchivos);
        
        
         // Agregar la barra de progreso al div del proyecto
        const barraProgreso = document.createElement('div');
        barraProgreso.classList.add('barra-progreso');
        const progreso = document.createElement('div');
        progreso.classList.add('progreso');
        progreso.style.width = '0%'; // Inicializar el ancho del progreso
        barraProgreso.appendChild(progreso);
        divProyecto.appendChild(barraProgreso);

        contenedorProyectos.appendChild(divProyecto);

        // Actualizar la barra de progreso bas��ndose en el estado 'completada' de las tareas
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



