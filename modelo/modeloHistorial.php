<?php
include '../controladores/ConexionDB.php';

class modeloHistorial{
    public function regOdontogramaAdulto($documentoPaciente, $fechaOdontograma, $comentarios){
        try {
            $conexion = new conexionDB();
            $conexion->abrir();

            // Puedes imprimir los valores recibidos aquí
//            echo "Documento Paciente: $documentoPaciente<br>";
//            echo "Fecha Odontograma: $fechaOdontograma<br>";
//            echo "Comentario: $comentarios<br>";

            // Ahora, puedes utilizar estos valores en tu consulta SQL
            $sql = "INSERT INTO ODONTOGRAMA (Documento_paciente, Fecha_odontograma, Comentarios) VALUES ('$documentoPaciente', '$fechaOdontograma', '$comentarios')";
            $conexion->consultar($sql);

            $result = $conexion->obtenerResult();
            $conexion->cerrar();

            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}
?>