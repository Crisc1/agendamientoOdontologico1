<?php
// Verificar si se recibió el ID del usuario a eliminar
if(isset($_POST['id'])) {
    // Incluir el archivo de conexión a la base de datos
    include '../../controladores/ConexionDB.php';

    // Obtener el ID del usuario a eliminar
    $id = $_POST['id'];

    // Crear una instancia de la clase de conexión a la base de datos
    $conexion = new ConexionDB();

    // Abrir la conexión a la base de datos
    if ($conexion->abrir() === 0) {
        die("Error al conectar a la base de datos");
    }

    // Escapar el ID del usuario para evitar inyección SQL
    $id = $conexion->mySQLI->real_escape_string($id);

    // Construir la consulta SQL para eliminar el usuario
    $sql = "DELETE FROM persona WHERE ID = $id";

    // Ejecutar la consulta
    $conexion->consultar($sql);

    // Verificar si la consulta se ejecutó correctamente
    if ($conexion->obtenerFilasAfectadas() > 0) {
        // La eliminación fue exitosa
        echo "success";
    } else {
        // No se pudo eliminar el usuario
        echo "error";
    }

    // Cerrar la conexión a la base de datos
    $conexion->cerrar();
} else {
    // No se recibió el ID del usuario a eliminar
    echo "ID del usuario no recibido";
}
?>
