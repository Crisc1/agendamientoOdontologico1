<?php
include_once '../../modelo/administrador/modeloConsultarExistencias.php';

// Función para consultar los insumos desde la base de datos
function consultarYActualizarInsumos() {
    // Consulta los insumos desde la base de datos
    $resultados = consultarInsumos();

    // Actualiza las cantidades de los insumos en la base de datos al presionar el botón "Actualizar"
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
        foreach ($resultados as $insumo) {
            $id = $insumo['ID'];
            
            // Verifica si se ha enviado una cantidad para actualizar para este insumo
            if (isset($_POST['cantidad'][$id])) {
                $cantidad_ingresada = intval($_POST['cantidad'][$id]);
                $cantidad_actual = $insumo['Cantidad'];
                
                // Verifica si la cantidad ingresada es diferente de la cantidad actual
                if ($cantidad_ingresada != $cantidad_actual) {
                    // Calcula la diferencia entre la cantidad ingresada y la cantidad actual
                    $diferencia = $cantidad_ingresada - $cantidad_actual;
                    
                    // Actualiza la cantidad en la base de datos sumando la diferencia
                    actualizarInsumos([$id => $diferencia]); // Utiliza el nombre correcto de la función aquí
                }
            }
        }
        
        // Después de actualizar, llamamos nuevamente a la función para obtener los datos actualizados
        $resultados = consultarInsumos();
    }

    return $resultados;
}

// Obtener los insumos
$resultados = consultarYActualizarInsumos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTROL DE INSUMOS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('../..//assets/imagenes/backGroundLogin.jpg') no-repeat center center fixed;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(0, 0, 0, 0.5); /* Borde del contenedor */
        }
        h1 {
            text-align: center;
            color: #007bff;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 60px;
        }
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.5); /* Borde de la tabla */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 10px; /* Redondea la tabla */
            border: 1px solid rgba(0, 0, 0, 0.5); /* Bordes de la tabla */
        }
        th, td {
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid rgba(0, 0, 0, 0.5); /* Borde de las celdas */
        }
        th {
            background-color: #f2f2f2;
        }
        .quantity-control {
            display: flex;
            flex-direction: column;
        }
        .quantity-control button {
            padding: 0.375rem 0.75rem;
            margin: 0;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 0;
        }
        .quantity-control button:hover {
            background-color: #0056b3;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .update-button {
            text-align: center;
            margin-top: 20px;
        }
        .update-message {
            color: green;
            font-weight: bold;
            font-size: 1.2em;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Control de Insumos</h1>
        <form action="" method="post">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Cantidad Actual</th>
                            <th>Modificar Cantidad</th>
                            <th>Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $insumo): ?>
                        <tr>
                            <td><?php echo $insumo['ID']; ?></td>
                            <td><?php echo $insumo['Nombre']; ?></td>
                            <td><?php echo $insumo['Cantidad']; ?></td>
                            <td class="quantity-control">
                                <div class="input-group">
                                    <button class="btn btn-outline-primary" type="button"
                                        onclick="decrementarCantidad(<?php echo $insumo['ID']; ?>)">-</button>
                                    <input id="cantidad_<?php echo $insumo['ID']; ?>" type="number"
                                        class="form-control text-center" name="cantidad[<?php echo $insumo['ID']; ?>]"
                                        value="<?php echo $insumo['Cantidad']; ?>" min="0">
                                    <button class="btn btn-outline-primary" type="button"
                                        onclick="incrementarCantidad(<?php echo $insumo['ID']; ?>)">+</button>
                                </div>
                            </td>
                            <td><?php echo $insumo['Unidad']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>

    <!-- Añade los scripts de Bootstrap al final del cuerpo del documento -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Agrega tu script personalizado aquí -->
    <script>
        // Funciones de incrementar y decrementar cantidad
        function incrementarCantidad(id) {
            var input = document.getElementById('cantidad_' + id);
            input.stepUp();
        }

        function decrementarCantidad(id) {
            var input = document.getElementById('cantidad_' + id);
            input.stepDown();
        }
    </script>
</body>
</html>