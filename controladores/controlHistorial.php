<?php
// Incluir las clases y archivos necesarios
include '../clases/claseHistorial.php';
include '../modelo/modeloHistorial.php';

// Obtener el contenido JSON del cuerpo de la solicitud
$json_data = file_get_contents("php://input");

// Decodificar el JSON en un array asociativo
$data = json_decode($json_data, true);

// Inicializar el array para la respuesta
$response = [];

// Verificar si se proporcionaron los datos de odontograma y documentoPaciente
if (isset($data['odontograma']) && isset($data['documentoPaciente'])) {
    try {
        // Obtener los datos de odontograma y documentoPaciente
        $odontograma = $data['odontograma'];
        $documentoPaciente = $data['documentoPaciente'];

        // Iterar sobre los elementos del odontograma
        foreach ($odontograma as $item) {
            // Verificar si el elemento tiene el campo 'comentario'
            if (isset($item['comentario'])) {
                // Obtener el comentario
                $comentario = $item['comentario'];

                // Obtener la fecha si está presente, de lo contrario, usar la fecha actual
                $fecha = isset($item['fecha']) ? $item['fecha'] : date('Y-m-d');

                // Aquí puedes agregar el código para guardar los datos en la base de datos
                // Crear instancia de la claseHistorial y llamar al método odontograma
                $odontogramaAdulto = new claseHistorial();
                $odontogramaAdulto->odontograma($documentoPaciente, $fecha, $comentario);

                // Si es necesario, registrar el odontograma en el modelo
                $regOdontograma = new modeloHistorial();
                $regOdontograma->regOdontogramaAdulto($documentoPaciente, $fecha, $comentario);
            } else {
                // Si falta el campo 'comentario', no hacer nada
            }
        }

        // Establecer la respuesta de éxito
        $response['success'] = true;
        $response['message'] = 'Odontograma(s) guardado(s) con éxito';
    } catch (Exception $exc) {
        // Establecer la respuesta de error
        $response['success'] = false;
        $response['message'] = $exc->getMessage();
    }
} else {
    // Establecer la respuesta de error si no se proporcionan los datos necesarios
    $response['success'] = false;
    $response['message'] = 'Llenar todos los campos';
}

// Convertir la respuesta a JSON y enviarla
echo json_encode($response);
?>
