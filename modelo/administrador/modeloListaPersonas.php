<?php
session_start(); // Iniciar la sesión

// Incluir el archivo de conexión a la base de datos
include '../../controladores/conexionDB.php';

// Crear una instancia de la clase de conexión a la base de datos
$conexion = new ConexionDB();

// Abrir la conexión a la base de datos
if ($conexion->abrir() === 0) {
    die("Error al conectar a la base de datos");
}

// Obtener los valores de nombre y apellido de la sesión actual
if (isset($_SESSION['NOMBRE']) && isset($_SESSION['APELLIDO'])) {
    $nombre = $_SESSION['NOMBRE'];
    $apellido = $_SESSION['APELLIDO'];
} else {
    // Manejar el caso donde las variables de sesión no están definidas
    die("Las variables de sesión no están definidas");
}

// Realizar la consulta para obtener las personas registradas
$sql = "SELECT 
                P.DOCUMENTO,
                P.NOMBRE,
                P.APELLIDO,
                TD.NOMBRE_DOCUMENTO AS TIPO_DOCUMENTO,
                P.FECHA_NACIMIENTO,
                P.TELEFONO,
                P.CORREO,
                P.DIRECCION,
                P.CONTRASENA,
                R.NOMBRE_ROL AS ROL
            FROM 
                persona P
            JOIN 
                tipo_documento TD ON P.TIPO_DOCUMENTO = TD.ID_DOCUMENTO
            LEFT JOIN 
                rol R ON P.ID_ROL = R.ID_ROL
            WHERE 
                P.ID_ROL != 1 AND
                CONCAT(P.NOMBRE, ' ', P.APELLIDO) != '$nombre $apellido'
            ORDER BY 
                P.NOMBRE";
$conexion->consultar($sql);
$resultado = $conexion->obtenerResult();

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Array para almacenar las personas
    $personas = array();

    // Iterar sobre los resultados y agregar cada persona al array
    while ($fila = $resultado->fetch_assoc()) {
        $personas[] = $fila;
    }

    // Codificar los datos como JSON
    $personas_json = json_encode($personas);

    // Devolver las personas como una respuesta JSON
    echo $personas_json;
} else {
    // No se encontraron personas, devuelve un array vacío como respuesta JSON
    echo json_encode(array());
}

// Cerrar la conexión a la base de datos
$conexion->cerrar();
?>
