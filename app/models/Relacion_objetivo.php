<?php

    class Relacion_objetivo{
        private $db;

        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }

        public function add($REL_OE_ID,$REL_OBJ_ID,$REL_DET_ID){
            try{
                $this->db->query("INSERT INTO RELACIONES_OBJETIVOS(REL_OE_ID,REL_OBJ_ID,REL_DET_ID) VALUES(:REL_OE_ID,:REL_OBJ_ID,:REL_DET_ID)");
                $this->db->bind(':REL_OE_ID',$REL_OE_ID);
                $this->db->bind(':REL_OBJ_ID',$REL_OBJ_ID);
                $this->db->bind(':REL_DET_ID',$REL_DET_ID);
                if($this->db->execute()){
                    return true;                    
                }else{
                    return false;
                }
            }catch(\Throwable $th){
                return $th->getMessage();
            }
        }

        public function getAll(){
            try {
                $this->db->query("SELECT REL_OE_ID,REL_OBJ_ID,REL_DET_ID FROM RELACIONES_OBJETIVOS");
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getOne($REL_ID){
            try {
                $this->db->query("SELECT REL_ID,REL_OE_ID,REL_OBJ_ID,REL_DET_ID FROM RELACIONES_OBJETIVOS WHERE REL_ID = :REL_ID");
                $this->db->bind(':REL_ID',$REL_ID);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function update($REL_ID,$REL_OE_ID,$REL_OBJ_ID,$REL_DET_ID){
            try {
                $this->db->query("UPDATE  SET REL_OE_ID=:REL_OE_ID, REL_OBJ_ID=:REL_OBJ_ID, REL_DET_ID=:REL_DET_ID WHERE REL_ID=:REL_ID");
                $this->db->bind(':REL_ID',$REL_ID);
                $this->db->bind(':REL_OE_ID',$REL_OE_ID);
                $this->db->bind(':REL_OBJ_ID',$REL_OBJ_ID);
                $this->db->bind(':REL_DET_ID',$REL_DET_ID);
                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function delete($REL_ID){
            try {
                $this->db->query("DELETE FROM RELACIONES_OBJETIVOS WHERE REL_ID=:REL_ID");
                $this->db->bind(':REL_ID',$REL_ID);
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