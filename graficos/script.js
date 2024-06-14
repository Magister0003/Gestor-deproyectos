// Grafico # 1
function inicializarGraficoProyectos() {
    fetch('getProjectData.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('projectsChart').getContext('2d');
            const labels = data.map(item => item.estado);
            const cantidad = data.map(item => item.cantidad);

                new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Proyectos por Estado Actual',
                        data: cantidad,
                        backgroundColor: data.map(item => {
                            switch(item.estado) {
                                case 'Finalizado':
                                    return 'rgba(75, 192, 192, 0.5)'; // Verde
                                case 'Activo':
                                    return 'rgba(255, 206, 86, 0.5)'; // Amarillo
                                case 'En Pausa':
                                    return 'rgba(255, 99, 132, 0.5)'; // Rojo
                                default:
                                    return 'rgba(201, 203, 207, 0.5)'; // Gris por defecto
                            }
                        }),
                        borderColor: data.map(item => {
                            switch(item.estado) {
                                case 'Finalizado':
                                    return 'rgba(75, 192, 192, 1)'; // Verde
                                case 'Activo':
                                    return 'rgba(255, 206, 86, 1)'; // Amarillo
                                case 'En Pausa':
                                    return 'rgba(255, 99, 132, 1)'; // Rojo
                                default:
                                   return 'rgba(201, 203, 207, 1)'; // Gris por defecto
                            }
                        }),
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
}

// Grafico # 2
function inicializarGraficoTareas() {
    fetch('getTaskCompletionData.php')
        .then(response => response.json())
        .then(data => {
            // console.log(data); // Esto imprimirá los datos recibidos en la consola

            // Sumar las tareas completadas y pendientes de todos los proyectos
            let totalCompletadas = 0;
            let totalPendientes = 0;
            data.forEach(proyecto => {
                totalCompletadas += proyecto.completadas;
                totalPendientes += proyecto.pendientes;
            });

            // Obtener el contexto del canvas donde se mostrará el gráfico
            const ctx = document.getElementById('tasksChart').getContext('2d');

            // Crear el gráfico circular
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Tareas Completadas', 'Tareas Pendientes'],
                    datasets: [{
                        label: 'Estado General de Tareas',
                        data: [totalCompletadas, totalPendientes],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        })
        .catch(error => console.error('Error:', error));
}
// Grafico # 3
function inicializarGraficoBarrasApiladas() {
    fetch('getTaskCompletionData.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('stackedBarChart').getContext('2d');
            const nombresProyectos = data.map(item => item.nombre_proyecto);
            const tareasCompletadas = data.map(item => item.completadas);
            const tareasPendientes = data.map(item => item.pendientes);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nombresProyectos,
                    datasets: [{
                        label: 'Tareas Completadas',
                        data: tareasCompletadas,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)' // Color para completadas
                    }, {
                        label: 'Tareas Pendientes',
                        data: tareasPendientes,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)' // Color para pendientes
                    }]
                },
                options: {
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
}
// Grafico # 6
function inicializarGraficoBarrasApiladas2() {
    fetch('getTaskfacturaData.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('stackedBarChart2').getContext('2d');
            const nombreComercial = data.map(item => item.nombre_comercial);
            const facturaivaMaxima = data.facturaiva_maxima;
            const facturaivas = data.facturaivas;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nombreComercial,
                    datasets: [{
                        label: 'Facturaiva',
                        data: facturaivas,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)' // Color para facturaiva
                    }, {
                        label: 'Facturaiva Maxima',
                        data: Array(nombreComercial.length).fill(facturaivaMaxima),
                        backgroundColor: 'rgba(255, 159, 64, 0.6)' // Color para facturaiva máxima
                    }]
                },
                options: {
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
}



// Grafico # 4
function inicializarGraficoCargaTrabajo() {
    fetch('getWorkloadData.php')
        .then(response => response.json())
        .then(data => {
            const fechas = [];
            const cargaTrabajo = [];

            data.forEach(item => {
    fechas.push(item.fecha_inicio);
    // Usar la cantidad de proyectos como indicador de carga de trabajo
    cargaTrabajo.push(item.cantidadProyectos);
});

            const ctx = document.getElementById('workloadChart').getContext('2d');
            new Chart(ctx, {
                type: 'line', // Gráfico de línea para tendencias
                data: {
                    labels: fechas,
                    datasets: [{
                        label: 'Carga de Trabajo',
                        data: cargaTrabajo,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
}

// Grafico # 5
function inicializarGraficoEvolucionProyecto() {
    fetch('getProjectEvolutionData.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('evolutionChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.fecha),
                    datasets: [{
                        label: 'Cantidad de Tareas Iniciadas por Fecha',
                        data: data.map(item => item.cantidad_tareas),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
}


document.addEventListener('DOMContentLoaded', () => {
    inicializarGraficoProyectos();
    inicializarGraficoTareas();
    inicializarGraficoBarrasApiladas();
    inicializarGraficoBarrasApiladas2();
    inicializarGraficoCargaTrabajo();
    inicializarGraficoEvolucionProyecto();
    
});