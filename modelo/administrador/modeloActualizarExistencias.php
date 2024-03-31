<?php

include '../../controladores/ConexionDB.php'; // Incluye la clase ConexionDB

$conexionDB = new ConexionDB(); // Crea una instancia de la clase ConexionDB

// Abrir la conexión a la base de datos
if ($conexionDB->abrir() === 0) {
    die("Error de conexión: " . mysqli_connect_error());
}

$mensaje_actualizacion = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    foreach ($_POST['cantidad'] as $key => $cantidad) {
        $cantidad = intval($cantidad);

        // Actualizar la cantidad en la base de datos
        $id = $key + 1; // Suponiendo que el ID comienza desde 1
        $sql = "UPDATE Insumos SET Cantidad = $cantidad WHERE ID = $id";
        $conexionDB->consultar($sql);
    }
    $mensaje_actualizacion = "¡Insumos actualizados!";
}

// Cerrar la conexión a la base de datos
$conexionDB->cerrar();
?>