<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Datos de Persona</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('../../assets/imagenes/backGroundLogin.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .navbar {
            background-color: #007bff;
            display: flex; /* Add display property only to the navbar */
        }

        .navbar-dark .navbar-toggler-icon {
            background-color: #ffffff;
        }

        .container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            padding: 30px;
            max-width: 600px;
        }

        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-primary:focus {
            outline: none;
        }
        
        .btn-volver {
            background-color: #e63946; /* Cambio de color a un tono de rojo más fuerte */
            color: #fff;
            border-color: #e63946; /* Cambio de color del borde */
            border-radius: 10px;
            padding: 8px 16px;
            margin-left: 10px;
        }

        .btn-volver:hover {
            background-color: #cf303e; /* Cambio de color al pasar el ratón */
            border-color: #cf303e; /* Cambio de color del borde al pasar el ratón */
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="../administrador/menuAdministrador.php">Centro Odontológico</a>
        <div class="navbar-collapse justify-content-end">
            <button class="btn rounded mr-2 btn-volver" type="button" onclick="window.history.back()">Volver</button>
        </div>
    </nav>

    <div class="container">
        <h1>Editar Datos de Persona</h1>
        <div class="row">
            <div class="col-md-12">
                <form action="guardarCambios.php" method="POST">
                    <?php
                    // Verificar si hay resultados de la consulta
                    if (!empty($result)) {
                        // Iterar sobre los resultados
                        foreach ($result as $persona) {
                            ?>
                            <!-- Campo oculto para el documento de la persona -->
                            <input type="hidden" name="documentoPersona" value="<?= $persona['DOCUMENTO']; ?>">
                            
                            <!-- Campo de nombre -->
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $persona['NOMBRE']; ?>">
                            </div>
                            
                            <!-- Campo de apellido -->
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $persona['APELLIDO']; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="tipoDocumentoAnterior">Tipo de Documento Anterior:</label>
                                <input type="text" class="form-control" id="tipoDocumentoAnterior" name="tipoDocumentoAnterior" value="<?= $persona['TIPO_DOCUMENTO']; ?>" readonly>
                            </div>

                            <!-- Campo de Tipo de Documento Nuevo -->
                            <div class="form-group">
                                <label for="tipoDocumentoNuevo">Tipo de Documento Nuevo:</label>
                                <select class="form-control" id="tipoDocumentoNuevo" name="tipoDocumentoNuevo">
                                    <?php
                                    // Iterar sobre los tipos de documento
                                    foreach ($tiposDocumento as $tipoDocumento) {
                                        // Mostrar opción en el select
                                        echo "<option value='{$tipoDocumento['ID_DOCUMENTO']}'>{$tipoDocumento['NOMBRE_DOCUMENTO']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <!-- Campo de correo -->
                            <div class="form-group">
                                <label for="correo">Correo:</label>
                                <input type="email" class="form-control" id="correo" name="correo" value="<?= $persona['CORREO']; ?>">
                            </div>
                            
                            <!-- Campo de teléfono -->
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $persona['TELEFONO']; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="rolAnterior">Rol Anterior:</label>
                                <input type="text" class="form-control" id="rolAnterior" name="rolAnterior" value="<?= $persona['NOMBRE_ROL']; ?>" readonly>
                            </div>

                            <!-- Campo de Rol Nuevo -->
                            <div class="form-group">
                                <label for="rolNuevo">Rol Nuevo:</label>
                                <select class="form-control" id="rolNuevo" name="rolNuevo">
                                    <?php
                                    // Iterar sobre los roles
                                    foreach ($roles as $rol) {
                                        // Mostrar opción en el select
                                        echo "<option value='{$rol['ID_ROL']}'>{$rol['NOMBRE_ROL']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>No se encontraron resultados.</p>";
                    }
                    ?>
                    <!-- Botón para guardar cambios -->
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
