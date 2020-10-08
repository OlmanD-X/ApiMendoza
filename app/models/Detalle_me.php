<?php

    class Detalle_me{
        private $db;

        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }

        public function add($DET_OBJ_ID,$DET_OE_ID,$DET_PERS_ID){
            try{
                $this->db->query("INSERT INTO DET_MAPA_ESTRATEGICO (DET_OBJ_ID,DET_OE_ID,DET_PERS_ID) VALUES(:DET_OBJ_ID,:DET_OE_ID,:DET_PERS_ID)");
                $this->db->bind(':DET_OBJ_ID',$DET_OBJ_ID);
                $this->db->bind(':DET_OE_ID',$DET_OE_ID);
                $this->db->bind(':DET_PERS_ID',$DET_PERS_ID);
                if($this->db->execute()){
                    return true;                    
                }else{
                    return false;
                }
            }catch(\Throwable $th){
                return $th->getMessage();
            }
        }

        public function getAll($PERS_ID){
            try {
                $this->db->query("SELECT DET_ID,DET_OBJ_ID,DET_OE_ID,DET_PERS_ID FROM DET_MAPA_ESTRATEGICO WHERE DET_PERS_ID=:PERS_ID");
                $this->db->bind(':PERS_ID',$PERS_ID);
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getOne($DET_ID){
            try {
                $this->db->query("SELECT DET_ID,DET_OBJ_ID,DET_OE_ID,DET_PERS_ID FROM DET_MAPA_ESTRATEGICO  WHERE DET_ID = :DET_ID");
                $this->db->bind(':DET_ID',$DET_ID);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function update($DET_ID,$DET_OBJ_ID,$DET_OE_ID,$DET_PERS_ID){
            try {
                $this->db->query("UPDATE DET_MAPA_ESTRATEGICO  SET DET_OBJ_ID=:DET_OBJ_ID, DET_OE_ID=:DET_OE_ID, DET_PERS_ID=:DET_PERS_ID WHERE DET_ID=:DET_ID");
                $this->db->bind(':DET_ID',$DET_ID);
                $this->db->bind(':DET_OBJ_ID',$DET_OBJ_ID);
                $this->db->bind(':DET_OE_ID',$DET_OE_ID);
                $this->db->bind(':DET_PERS_ID',$DET_PERS_ID);
                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function delete($DET_ID){
            try {
                $this->db->query("DELETE FROM DET_MAPA_ESTRATEGICO WHERE DET_ID=:DET_ID");
                $this->db->bind(':DET_ID',$DET_ID);
                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }