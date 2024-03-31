<?php
include '../../controladores/ConexionDB.php';

// Este es un ejemplo básico, asegúrate de sanear y validar los datos antes de usarlos en consultas a la base de datos

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    // Obtener otros datos del formulario según sea necesario

    // Crear una instancia del controlador de conexión a la base de datos
    $conexionDB = new ConexionDB();
    // Abrir la conexión a la base de datos
    $conexionExitosa = $conexionDB->abrir();
    
    if ($conexionExitosa) {
        // Consultar la base de datos para actualizar los datos del usuario
        $sql = "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido' WHERE id = $id";
        $conexionDB->consultar($sql);
        
        // Verificar si la actualización fue exitosa
        $filasAfectadas = $conexionDB->obtenerFilasAfectadas();
        if ($filasAfectadas > 0) {
            // Envía una respuesta de éxito al cliente
            echo "success";
        } else {
            // Envía una respuesta de error al cliente
            echo "error";
        }

        // Cerrar la conexión a la base de datos
        $conexionDB->cerrar();
    } else {
        // Envía una respuesta de error al cliente si la conexión falló
        echo "error_conexion";
    }
}
?>
