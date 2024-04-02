<?php
include '../controladores/conexionDB.php';
class modeloCitas{
        public function regCita(claseCitas $regCita) {
        try {
            $conexion = new ConexionDB();
            $conexion->abrir();  
            $idProfesional= $regCita->getIdProfesional();
            $documento = $regCita->getDocumento();
            $idTratamiento = $regCita->getIdTratamiento();
            $fecha = $regCita->getFecha();
            $hora = $regCita->getHora();
            #$consultorio = $regCita->getConsultorio();
            $sql = "insert into cita values('null','$idProfesional','$documento','$idTratamiento','$fecha','$hora','1')";
            $conexion->consultar($sql);
            $res = $conexion->obtenerFilasAfectadas();
            if ($res == 1) {
                header("Location: ../vista/salidas/paginaExito.php"); 
                exit();    
            }else{
                header("Location: ../vista/salidas/paginaError.php"); 
                exit();  
            }  
            $conexion->cerrar();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function consultarCita($documento) {
         
        try{
            $conexion = new ConexionDB();
            $conexion->abrir();      
            $sql= "SELECT 
                    cita.ID_CITA, 
                    cita.FECHA, 
                    cita.HORA, 
                    profesional.ID_PROFESIONAL,  
                    CONCAT(persona.NOMBRE, ' ', persona.APELLIDO) AS NOMBRE_profesional,
                    tratamiento.NOMBRE_TRATAMIENTO AS NOMBRE_TRATAMIENTO, 
                    consultorio.NUMERO_CONSULTORIO
                FROM cita
                JOIN profesional ON cita.ID_PROFESIONAL = profesional.ID_PROFESIONAL
                JOIN persona ON profesional.DOCUMENTO = persona.DOCUMENTO
                LEFT JOIN tratamiento ON cita.ID_TRATAMIENTO = tratamiento.ID_TRATAMIENTO
                LEFT JOIN consultorio ON cita.ID_CONSULTORIO = consultorio.ID_CONSULTORIO
                WHERE cita.DOCUMENTO_PACIENTE = $documento
                    AND cita.FECHA >= CURDATE() -- Solo fechas mayores o iguales a la actual
                ORDER BY cita.FECHA";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function consultarAgenda($idProfesional) {
         
        try{
            $conexion = new conexionDB();
            $conexion->abrir();      
            $sql= "SELECT 
                        cita.ID_CITA, 
                        cita.FECHA, 
                        cita.HORA, 
                        PACIENTE.DOCUMENTO AS DOCUMENTO_PACIENTE,
                        profesional.ID_PROFESIONAL,  
                        CONCAT(PACIENTE.NOMBRE, ' ', PACIENTE.APELLIDO) AS NOMBRE_PACIENTE,
                        tratamiento.NOMBRE_TRATAMIENTO AS NOMBRE_TRATAMIENTO, 
                        consultorio.NUMERO_CONSULTORIO
                        FROM cita
                        JOIN profesional ON cita.ID_PROFESIONAL = profesional.ID_PROFESIONAL
                        JOIN persona AS PACIENTE ON cita.DOCUMENTO_PACIENTE = PACIENTE.DOCUMENTO
                        LEFT JOIN tratamiento ON cita.ID_TRATAMIENTO = tratamiento.ID_TRATAMIENTO
                        LEFT JOIN consultorio ON cita.ID_CONSULTORIO = consultorio.ID_CONSULTORIO
                        WHERE cita.ID_PROFESIONAL = $idProfesional
                        AND cita.FECHA >= CURDATE() -- Solo fechas mayores o iguales a la actual
                        ORDER BY cita.FECHA;";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function eliminarCita($idCita) {
        try{
            $conexion = new ConexionDB();
            $conexion->abrir();      
            $sql= "DELETE FROM cita WHERE ID_CITA = $idCita";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }   
}

