<?php

    class ModelObjetivosProceso{
        private $db;
        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }
        public function validateRepetido($descripcion,$idProceso){
            $this->db->query("SELECT OBJ_DESC FROM obj_proceso WHERE OBJ_DESC=:descripcion AND OBJ_PROC_ID=:id");
            $this->db->bind(':descripcion',$descripcion);
            $this->db->bind(':id',$idProceso);
            $data = $this->db->getRegisty();
            if(!empty($data->OBJ_DESC))
                return true;
            else
                return false; 
        }
        public function agregarObjetivosProceso($descripcion,$idProceso){
            $this->db->query("INSERT INTO obj_proceso(OBJ_DESC,OBJ_PROC_ID) VALUES(:descripcion,:id)");
            $this->db->bind(':descripcion',$descripcion);
            $this->db->bind(':id',$idProceso);
            return $this->db->execute();   
        }
        public function obtenerUnObjetivo($idObjetivo){
            $this->db->query("SELECT*FROM obj_proceso WHERE OBJ_ID=:id");
            $this->db->bind(':id',$idObjetivo);
            $data = $this->db->getRegisty();
            return $data;
        }
        public function mostrarTodosObjetivos($idProceso){
            $this->db->query("SELECT*FROM obj_proceso WHERE OBJ_PROC_ID=:id");
            $this->db->bind(':id',$idProceso);
            $data = $this->db->getRegisties();
            return $data;
        }
        public function actualizarObjetivos($idObjetivo,$descripcion){
            $this->db->query("UPDATE obj_proceso SET OBJ_DESC=:descripcion WHERE OBJ_PROC_ID=:id");
            $this->db->bind(':descripcion',$descripcion);
            $this->db->bind(':id',$idObjetivo);
            return $this->db->execute();   
        }
        public function eliminarObjetivos($idObjetivo){
            $this->db->query("DELETE FROM obj_proceso WHERE OBJ_PROC_ID=:id");
            $this->db->bind(':id',$idObjetivo);
            return $this->db->execute();
        }
    }