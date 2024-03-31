// Función para realizar la búsqueda de usuarios

function buscar() {
    var textoBusqueda = document.getElementById('busqueda').value.trim().toLowerCase();
    var columnaSeleccionada = document.getElementById('columna').value;
    var filasTabla = document.querySelectorAll('#lista-personas table tr');

    for (var i = 1; i < filasTabla.length; i++) {
        var fila = filasTabla[i];
        var textoCeldaNombreApellido = (fila.cells[0].textContent.trim() + ' ' + fila.cells[1].textContent.trim()).toLowerCase();

        if (columnaSeleccionada == 0 && textoCeldaNombreApellido.includes(textoBusqueda)) {
            fila.style.display = '';
        } else if (fila.cells[columnaSeleccionada].textContent.trim().toLowerCase().includes(textoBusqueda)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    }
}

// Obtener y mostrar la lista de personas al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../../modelo/administrador/modeloListaPersonas.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var personas = JSON.parse(xhr.responseText);
            var listaPersonasHTML = "<table class='table'><tr><th>Nombres y Apellidos</th><th>Tipo Documento</th><th>Correo</th><th>Telefono</th><th>Rol</th><th>Acciones</th></tr>";

            personas.forEach(function(persona) {
                listaPersonasHTML += "<tr><td>" + persona.NOMBRE + " " + persona.APELLIDO +"</td><td>" + persona.TIPO_DOCUMENTO + "</td><td>" + persona.CORREO + "</td><td>" + persona.TELEFONO + "</td><td>" + persona.ROL + "</td>";
                listaPersonasHTML += "<td><button class='btn btn-primary' onclick='editarUsuario(" + persona.DOCUMENTO + ")'>Editar</button>";
                listaPersonasHTML += "<button class='btn btn-danger' onclick='eliminarUsuario(" + persona.DOCUMENTO + ")'>Eliminar</button></td></tr>";
            });

            listaPersonasHTML += "</table>";
            document.getElementById('lista-personas').innerHTML = listaPersonasHTML;
        }
    };
    xhr.send();
});

// Redirigir a la página de edición con el documento como parámetro
function editarUsuario(documento) {
    // Crear un formulario dinámico
    var form = document.createElement('form');
    form.method = 'post';
    form.action = '../../controladores/administrador/controlEditarDatosPersona.php'; // Reemplaza 'tu_archivo_php.php' con la ruta correcta a tu archivo PHP
    
    // Crear un campo oculto para enviar el documento
    var hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'documentoPersona';
    hiddenInput.value = documento;

    // Agregar el campo oculto al formulario
    form.appendChild(hiddenInput);

    // Agregar el formulario al cuerpo del documento
    document.body.appendChild(form);

    // Enviar el formulario
    form.submit();
}


// Eliminar usuario
function eliminarUsuario(documento) {
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        var xhrEliminar = new XMLHttpRequest();
        xhrEliminar.open('POST', '../../modelo/administrador/eliminarPersona.php', true);
        xhrEliminar.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhrEliminar.onreadystatechange = function() {
            if (xhrEliminar.readyState == 4 && xhrEliminar.status == 200) {
                if (xhrEliminar.responseText === "success") {
                    alert("Usuario eliminado correctamente");
                    location.reload();
                } else {
                    alert("Error al eliminar el usuario");
                }
            }
        };
        xhrEliminar.send("documento=" + documento);
    }
}
