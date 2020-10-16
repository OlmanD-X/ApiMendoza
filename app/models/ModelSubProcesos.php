<?php

    class ModelSubProcesos{
        private $db;
        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }
        public function validateRepetido($descripcion,$idProceso){
            $this->db->query("SELECT SUB_DESC FROM subprocesos WHERE SUB_DESC=:descripcion AND SUB_PROC_ID=:id AND SUB_ESTADO='1'");
            $this->db->bind(':descripcion',$descripcion);
            $this->db->bind(':id',$idProceso);
            $data = $this->db->getRegisty();
            if(!empty($data->SUB_DESC))
                return true;
            else
                return false; 
        }
        public function agregarSubProceso($descripcion,$idProceso){
            $this->db->query("INSERT INTO subprocesos(SUB_DESC,SUB_PROC_ID,SUB_ESTADO) VALUES(:descripcion,:id,'1')");
            $this->db->bind(':descripcion',$descripcion);
            $this->db->bind(':id',$idProceso);
            return $this->db->execute();   
        }
        public function obtenerUnSubProceso($idSubProceso){
            $this->db->query("SELECT*FROM subprocesos WHERE SUB_ID=:id");
            $this->db->bind(':id',$idSubProceso);
            $data = $this->db->getRegisty();
            return $data;
        }
        public function mostrarTodosSubProcesos($idProceso){
            $this->db->query("SELECT*FROM subprocesos WHERE SUB_PROC_ID=:id AND SUB_ESTADO='1'");
            $this->db->bind(':id',$idProceso);
            $data = $this->db->getRegisties();
            return $data;
        }
        public function actualizarSubProceso($idSubProceso,$descripcion){
            $this->db->query("UPDATE subprocesos SET SUB_DESC=:descripcion WHERE SUB_ID=:id");
            $this->db->bind(':descripcion',$descripcion);
            $this->db->bind(':id',$idSubProceso);
            return $this->db->execute();   
        }
        public function eliminarSubProceso($idSubProceso){
            $this->db->query("UPDATE subprocesos SET SUB_ESTADO='0' WHERE SUB_ID=:id");
            $this->db->bind(':id',$idSubProceso);
            return $this->db->execute();
        }
    }