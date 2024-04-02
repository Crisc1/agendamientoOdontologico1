<?php
// Incluye la clase de conexión a la base de datos
require_once('../../controladores/conexionDB.php');

// Función para consultar los insumos en la base de datos
function consultarInsumos() {
    // Crea una instancia de la clase de conexión
    $conexion = new ConexionDB();

    // Abre la conexión a la base de datos
    if ($conexion->abrir()) {
        // Realiza la consulta
        $sql = "SELECT ID, Nombre, Cantidad, Unidad FROM insumos order by nombre";
        $conexion->consultar($sql);
        
        // Obtiene los resultados de la consulta
        $resultados = $conexion->obtenerResult();
        
        // Cierra la conexión
        $conexion->cerrar();

        return $resultados;
    } else {
        return false;
    }
}

// Función para actualizar las cantidades de los insumos en la base de datos
function actualizarInsumos($cantidades) {
    // Crea una instancia de la clase de conexión
    $conexion = new ConexionDB();

    // Abre la conexión a la base de datos
    if ($conexion->abrir()) {
        foreach ($cantidades as $id => $cantidad) {
            // Actualiza la cantidad en la base de datos
            $sql = "UPDATE insumos SET Cantidad = Cantidad + $cantidad WHERE ID = $id";
            $conexion->consultar($sql);
        }

        // Cierra la conexión
        $conexion->cerrar();
        return true;
    } else {
        return false;
    }
}
?>
