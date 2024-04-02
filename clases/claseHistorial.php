<?php
class claseHistorial{
    private $documentoPaciente;
    private $fechaOdontograma;
    private $comentario;

    
    public function __construct(){
        $this->documentoPaciente="";
        $this->fechaOdontograma="";
        $this->comentario="";

    }
    
    public function odontograma($documentoPaciente, $fechaOdontograma, $comentario) {
        $this->documentoPaciente= $documentoPaciente;
        $this->fechaOdontograma= $fechaOdontograma;
        $this->comentario= $comentario;
    }

}
