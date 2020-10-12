<?php

    class Empresa{
        private $db;

        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }

        public function add($EMP_RS,$EMP_RUC,$EMP_LOGO){
            try{
                $this->db->query("INSERT INTO EMPRESAS(EMP_RS,EMP_RUC,EMP_LOGO,EMP_ESTADO) VALUES(:EMP_RS,:EMP_RUC,:EMP_LOGO,'1')");
                $this->db->bind(':EMP_RS',$EMP_RS);
                $this->db->bind(':EMP_RUC',$EMP_RUC);
                $this->db->bind(':EMP_LOGO',$EMP_LOGO);
                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            }catch(\Throwable $th){
                return $th->getMessage();
            }
        }

        public function getAllEmpresas(){
            try {
                $this->db->query("SELECT EMP_RS,EMP_RUC,EMP_LOGO FROM EMPRESAS WHERE EMP_ESTADO = '1'");
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getEmpresa($EMP_ID){
            try {
                $this->db->query("SELECT EMP_ID,EMP_RS,EMP_RUC,EMP_LOGO FROM EMPRESAS WHERE EMP_ID = :EMP_ID");
                $this->db->bind(':EMP_ID',$EMP_ID);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function validateRuc($EMP_RUC){
            $this->db->query("SELECT EMP_RUC FROM EMPRESAS WHERE EMP_RUC=:EMP_RUC;");
            $this->db->bind(':EMP_RUC',$EMP_RUC);
            $data = $this->db->getRegisty();
            if(!empty($data->EMP_RUC))
                return true;
            else
                return false; 
        }

        public function validateRS($EMP_RS){
            $this->db->query("SELECT EMP_RS FROM EMPRESAS WHERE EMP_RS=:EMP_RS;");
            $this->db->bind(':EMP_RS',$EMP_RS);
            $data = $this->db->getRegisty();
            if(!empty($data->EMP_RS))
                return true;
            else
                return false; 
        }

        public function update($EMP_ID,$EMP_RS,$EMP_RUC,$EMP_LOGO){
            try {
                $this->db->query("UPDATE EMPRESAS SET EMP_RS=:EMP_RS, EMP_RUC=:EMP_RUC, EMP_LOGO=:EMP_LOGO WHERE EMP_ID=:EMP_ID");
                $this->db->bind(':EMP_ID',$EMP_ID);
                $this->db->bind(':EMP_RS',$EMP_RS);
                $this->db->bind(':EMP_RUC',$EMP_RUC);
                $this->db->bind(':EMP_LOGO',$EMP_LOGO);
                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function delete($EMP_ID){
            try {
                $this->db->query("UPDATE EMPRESAS SET EMP_ESTADO='0' WHERE EMP_ID=:EMP_ID");
                $this->db->bind(':EMP_ID',$EMP_ID);
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