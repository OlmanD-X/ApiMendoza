<?php

    class Mapa_est{
        private $db;

        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }

        public function add($ME_CREATE_DATE,$ME_PROC_ID,$ME_SUB_ID){
            try{
                $this->db->query("INSERT INTO MAPA_ESTRATEGICO(ME_CREATE_DATE,ME_PROC_ID,ME_SUB_ID,ME_ESTADO) VALUES(:ME_CREATE_DATE,:ME_PROC_ID,:ME_SUB_ID,'1')");
                $this->db->bind(':ME_CREATE_DATE',$ME_CREATE_DATE);
                $this->db->bind(':ME_PROC_ID',$ME_PROC_ID);
                $this->db->bind(':ME_SUB_ID',$ME_SUB_ID);
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
                $this->db->query("SELECT ME_CREATE_DATE,ME_PROC_ID,ME_SUB_ID FROM MAPA_ESTRATEGICO WHERE ME_ESTADO = '1'");
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getOne($ME_ID){
            try {
                $this->db->query("SELECT ME_ID,ME_CREATE_DATE,ME_PROC_ID,ME_SUB_ID FROM MAPA_ESTRATEGICO WHERE ME_ID = :ME_ID");
                $this->db->bind(':ME_ID',$ME_ID);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function update($ME_ID,$ME_CREATE_DATE,$ME_PROC_ID,$ME_SUB_ID){
            try {
                $this->db->query("UPDATE MAPA_ESTRATEGICO SET ME_CREATE_DATE=:ME_CREATE_DATE, ME_PROC_ID=:ME_PROC_ID, ME_SUB_ID=:ME_SUB_ID WHERE ME_ID=:ME_ID");
                $this->db->bind(':ME_ID',$ME_ID);
                $this->db->bind(':ME_CREATE_DATE',$ME_CREATE_DATE);
                $this->db->bind(':ME_PROC_ID',$ME_PROC_ID);
                $this->db->bind(':ME_SUB_ID',$ME_SUB_ID);
                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function delete($ME_ID){
            try {
                $this->db->query("UPDATE MAPA_ESTRATEGICO SET ME_ESTADO='0' WHERE ME_ID=:ME_ID");
                $this->db->bind(':ME_ID',$ME_ID);
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