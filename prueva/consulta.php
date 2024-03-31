<?php
// Incluir la clase de conexión
require_once 'ConexionDB.php';

// Verificar si se proporcionó un documentoPersona
if(isset($_GET['documentoPersona'])) {
    // Obtener el valor del parámetro
    $documentoPersona = $_GET['documentoPersona'];
    
    // Crear una instancia de la clase ConexionDB
    $conexion = new ConexionDB();
    
    // Abrir la conexión a la base de datos
    if($conexion->abrir()) {
        // Consultar la base de datos
        $sql = "SELECT * FROM persona WHERE documento = '$documentoPersona'";
        $conexion->consultar($sql);
        
        // Obtener el resultado de la consulta
        $resultado = $conexion->obtenerResult();
        
        // Verificar si se encontraron resultados
        if(mysqli_num_rows($resultado) > 0) {
            // Array para almacenar los datos
            $datos = array();
            
            // Iterar sobre los resultados y almacenarlos en el array
            while($fila = mysqli_fetch_assoc($resultado)) {
                $datos[] = $fila;
            }
            
            // Almacenar los datos en un JSON
            $datos_json = json_encode($datos);
            
            // Puedes hacer lo que desees con $datos_json
            // Por ejemplo, imprimirlo en la página
            echo $datos_json;
        } else {
            echo "No se encontraron resultados para el documento proporcionado.";
        }
        
        // Cerrar la conexión
        $conexion->cerrar();
    } else {
        echo "Error al abrir la conexión a la base de datos.";
    }
} else {
    echo "Debe proporcionar un parámetro documentoPersona.";
}
?>

