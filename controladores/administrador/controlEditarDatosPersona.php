<?php
include '../../clases/administrador/claseAdministrador.php';
include '../../modelo/administrador/modeloConsultarDatosPersona.php';       

if(isset($_POST['documentoPersona'])){
    try {
        $documentoPersona = $_POST['documentoPersona'];
        $persona=new claseAdministrador();
        $persona->consultarPersona($documentoPersona);
        $consultarPersonas= new modeloConsultarDatosPersona();
        $result=$consultarPersonas->consultarPersona($persona->getDocumentoPersona());
        require '../../vista/administrador/editarDatosPersona.php';
    } catch (Exception $exc) {
        // Manejo de errores
        echo 'Error: ' . $exc->getMessage();
    }
} else {
    $alerta = "Llenar todos los campos";
    echo "alert('" . $alerta . "');";
}
?>
