<?php

    class ModelProcesos{
        private $db;
        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }
        public function validateRepetido($descripcion,$idEmpresa){
            $this->db->query("SELECT PROC_DESC FROM procesos WHERE PROC_DESC=:descripcion AND PROC_EMP_ID=:id AND PROC_ESTADO='1'");
            $this->db->bind(':descripcion',$descripcion);
            $this->db->bind(':id',$idEmpresa);
            $data = $this->db->getRegisty();
            if(!empty($data->PROC_DESC))
                return true;
            else
                return false; 
        }
        public function agregarProceso($descripcion,$idEmpresa){
            $this->db->query("INSERT INTO procesos(PROC_DESC,PROC_EMP_ID,PROC_ESTADO) VALUES(:descripcion,:id,'1')");
            $this->db->bind(':descripcion',$descripcion);
            $this->db->bind(':id',$idEmpresa);
            return $this->db->execute();   
        }
        public function obtenerUnProceso($idProceso){
            $this->db->query("SELECT*FROM procesos WHERE PROC_ID=:id");
            $this->db->bind(':id',$idProceso);
            $data = $this->db->getRegisty();
            return $data;
        }
        public function mostrarTodosProcesos($idEmpresa){
            $this->db->query("SELECT*FROM procesos WHERE PROC_EMP_ID=:id AND PROC_ESTADO='1'");
            $this->db->bind(':id',$idEmpresa);
            $data = $this->db->getRegisties();
            return $data;
        }
        public function actualizarProceso($idProceso,$descripcion){
            $this->db->query("UPDATE procesos SET PROC_DESC=:descripcion WHERE PROC_ID=:id");
            $this->db->bind(':descripcion',$descripcion);
            $this->db->bind(':id',$idProceso);
            return $this->db->execute();   
        }
        public function eliminarProceso($idProceso){
            $this->db->query("UPDATE procesos SET PROC_ESTADO='0' WHERE PROC_ID=:id");
            $this->db->bind(':id',$idProceso);
            return $this->db->execute();
        }
    }