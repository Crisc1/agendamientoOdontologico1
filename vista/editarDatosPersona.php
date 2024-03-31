<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Persona</title>
</head>
<body>
    <div>
        <h1>Editar Persona</h1>
        <form id="editarPersonaForm">
            <!-- Los campos de entrada -->
            <div>
                <label for="documento">Documento:</label>
                <input type="text" id="documento" name="documento" placeholder="Ingrese documento">
            </div>
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" readonly>
            </div>
            <div>
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" readonly>
            </div>
            <div>
                <label for="tipoDocumento">Tipo Documento:</label>
                <input type="text" id="tipoDocumento" name="tipoDocumento" readonly>
            </div>
            <!-- Otros campos de entrada -->
        </form>
    </div>

    <script>
        // Obtener el documento de la URL
        var urlParams = new URLSearchParams(window.location.search);
        var documento = urlParams.get('documentoPersona');
        
        // Verificar si se recibió el documento en la URL
        if(documento) {
            // Si se recibió, hacer una solicitud AJAX para obtener los datos de la persona
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../../modelo/administrador/modeloConsultarDatosPersona.php?documento=' + documento, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var persona = JSON.parse(xhr.responseText);
                    console.log(persona); // Mostrar los datos en la consola
                    if(persona.hasOwnProperty('error')) {
                        alert(persona.error);
                    } else {
                        // Asignar los datos obtenidos a los campos de entrada respectivos
                        document.getElementById('nombre').value = persona.NOMBRE;
                        document.getElementById('apellido').value = persona.APELLIDO;
                        document.getElementById('tipoDocumento').value = persona.TIPO_DOCUMENTO;
                        // Asignar otros campos de entrada aquí
                    }
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
