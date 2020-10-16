<?php

    class Perspectiva{
        private $db;

        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }

        public function add($PERS_NAME,$PERS_ORDEN,$PERS_ME_ID){
            try{
                $this->db->query("INSERT INTO PERSPECTIVA(PERS_NAME,PERS_ORDEN,PERS_ME_ID) VALUES(:PERS_NAME,:PERS_ORDEN,:PERS_ME_ID)");
                $this->db->bind(':PERS_NAME',$PERS_NAME);
                $this->db->bind(':PERS_ORDEN',$PERS_ORDEN);
                $this->db->bind(':PERS_ME_ID',$PERS_ME_ID);
                if($this->db->execute()){
                    return true;                    
                }else{
                    return false;
                }
            }catch(\Throwable $th){
                return $th->getMessage();
            }
        }

        public function getAll($id){
            try {
                $this->db->query("SELECT PERS_ID,PERS_NAME,PERS_ORDEN,PERS_ME_ID FROM PERSPECTIVA WHERE PERS_ME_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getOne($PERS_ID){
            try {
                $this->db->query("SELECT PERS_ID,PERS_NAME,PERS_ORDEN,PERS_ME_ID FROM PERSPECTIVA WHERE PERS_ID = :PERS_ID");
                $this->db->bind(':PERS_ID',$PERS_ID);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function update($PERS_ID,$PERS_NAME,$PERS_ORDEN,$PERS_ME_ID){
            try {
                $this->db->query("UPDATE PERSPECTIVA SET PERS_NAME=:PERS_NAME, PERS_ORDEN=:PERS_ORDEN, PERS_ME_ID=:PERS_ME_ID WHERE PERS_ID=:PERS_ID");
                $this->db->bind(':PERS_ID',$PERS_ID);
                $this->db->bind(':PERS_NAME',$PERS_NAME);
                $this->db->bind(':PERS_ORDEN',$PERS_ORDEN);
                $this->db->bind(':PERS_ME_ID',$PERS_ME_ID);
                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function delete($PERS_ID){
            try {
                $this->db->query("DELETE FROM PERSPECTIVA WHERE PERS_ID=:PERS_ID");
                $this->db->bind(':PERS_ID',$PERS_ID);
                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function delete_det_me($PERS_ID){
            try{
                $this->db->query("DELETE FROM DET_MAPA_ESTRATEGICO WHERE DET_PERS_ID=:PERS_ID");
                $this->db->bind(':PERS_ID',$PERS_ID);
                return $this->db->execute();
            }catch(\Throwable $th){
                return $th->getMessage();
            }
        }

        public function verificarDeletePerspectiva_det($PERS_ID){
            try{
                $this->db->query("SELECT *FROM PERSPECTIVA P INNER JOIN DET_MAPA_ESTRATEGICO DME ON P.PERS_ID=DME.DET_PERS_ID WHERE DME.DET_PERS_ID=:PERS_ID");
                $this->db->bind(':PERS_ID',$PERS_ID);
                $data = $this->db->getRegisty();
                    if(!empty($data->PERS_ID))
                        return true;
                    else
                        return false; 

            }catch(\Throwable $th){
                return $th->getMessage();
            }
        }

        public function validateName($name,$id)
        {
            try{
                $this->db->query("SELECT *FROM PERSPECTIVA WHERE PERS_NAME=:nombre AND PERS_ME_ID=:id");
                $this->db->bind(':nombre',$name);
                $this->db->bind(':id',$id);
                $data = $this->db->getRegisty();
                    if(!empty($data->PERS_ID))
                        return true;
                    else
                        return false; 

            }catch(\Throwable $th){
                return $th->getMessage();
            }
        }

        public function validateLevel($level,$id)
        {
            try{
                $this->db->query("SELECT *FROM PERSPECTIVA WHERE PERS_ORDEN=:nivel AND PERS_ME_ID=:id");
                $this->db->bind(':nivel',$level);
                $this->db->bind(':id',$id);
                $data = $this->db->getRegisty();
                    if(!empty($data->PERS_ID))
                        return true;
                    else
                        return false; 

            }catch(\Throwable $th){
                return $th->getMessage();
            }
        }
    }

