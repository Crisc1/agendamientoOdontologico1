<?php
class claseAdministrador{
    private $documentoPersona;

    
    public function __construct(){
        $this->documentoPersona="";
        
    }
    
    public function consultarPersona($documentoPersona) {
        $this->documentoPersona= $documentoPersona;
    }
    
    function  getDocumentoPersona(){
        return $this->documentoPersona;
    }
}

