<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar datos por documentoPersona</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        #resultado {
            margin-top: 30px;
        }
        label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Editar datos por documentoPersona</h2>
    <div id="resultado"></div>

    <script>
        $(document).ready(function(){
            // Obtener el valor del documentoPersona
            var documentoPersona = '<?php echo isset($_POST['documentoPersona']) ? $_POST['documentoPersona'] : ''; ?>';
            
            // Verificar si hay un documentoPersona proporcionado
            if(documentoPersona !== '') {
                // Realizar la solicitud AJAX automáticamente
                $.ajax({
                    type: 'GET',
                    url: 'consulta.php',
                    data: { documentoPersona: documentoPersona },
                    dataType: 'json',
                    success: function(data){
                        // Limpiar el contenido anterior
                        $('#resultado').empty();

                        // Verificar si se encontraron resultados
                        if(data.length > 0){
                            // Crear campos de entrada para cada dato
                            $.each(data[0], function(key, value){
                                var label = $('<label>').text(key + ': ').appendTo('#resultado');
                                var input = $('<input>').attr({
                                    type: 'text',
                                    name: key,
                                    value: value
                                }).appendTo('#resultado');
                                $('<br>').appendTo('#resultado');
                            });

                            // Botón para guardar los cambios
                            $('<button>').text('Guardar Cambios').click(function(){
                                // Obtener los valores editados
                                var formData = {};
                                $('#resultado input').each(function(){
                                    formData[$(this).attr('name')] = $(this).val();
                                });

                                // Enviar los datos actualizados al servidor
                                $.ajax({
                                    type: 'POST',
                                    url: 'guardar.php', // Este es el script PHP que manejará el guardado de los datos
                                    data: formData,
                                    success: function(response){
                                        // Aquí puedes manejar la respuesta del servidor, como mostrar un mensaje de éxito o error
                                        alert(response);
                                    },
                                    error: function(){
                                        alert('Error al procesar la solicitud.');
                                    }
                                });
                            }).appendTo('#resultado');
                        } else {
                            $('<p>').text('No se encontraron resultados para el documento proporcionado.').appendTo('#resultado');
                        }
                    },
                    error: function(){
                        $('<p>').text('Error al procesar la solicitud.').appendTo('#resultado');
                    }
                });
            }
        });
    </script>
</body>
</html>
