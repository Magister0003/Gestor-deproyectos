function eliminarArchivo(idArchivo, divArchivo) {
    // Primero, pedir confirmación al usuario
    if (confirm("¿Estás seguro de que deseas eliminar este archivo?")) {
        var nombreResponsable = document.getElementById('nombreResponsable').value; // Obtener el valor
        console.log('Nombre del responsable:', nombreResponsable); // Depurar el valor del nombre del responsable
        console.log('Enviando solicitud de eliminación para el ID:', idArchivo); // Para depuración

        fetch('php/eliminarArchivo.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({idArchivo: idArchivo, nombreResponsable: nombreResponsable}) // Incluir el nombre del responsable
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Respuesta de red no fue ok.');
            }
            return response.json();
        })
        .then(data => {
            if (data.exito) {
                divArchivo.remove(); // Eliminar el elemento del DOM
                alert('Archivo eliminado exitosamente.'); // Notificar al usuario del éxito
            } else {
                alert('Error al eliminar el archivo: ' + data.mensaje); // Notificar al usuario del fallo
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud: ' + error.message); // Notificar al usuario de un error en la solicitud
        });
    } else {
        // Si el usuario cancela la operación, opcionalmente puedes hacer algo aquí, como un log en consola
        console.log('Eliminación cancelada por el usuario.');
    }
}
