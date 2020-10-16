<?php

    class Indicator{
        private $db;

        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }

        public function add($name,$responsable,$obj,$lineBase,$meta,$frecuency,$formula,$redSymbol,$yellowSymbol,$greenSymbol,$redValue,$yellowValue,$greenValue,$procId,$subProcId,$variables,$initiatives){
            try {
                $this->db->query("INSERT INTO INDICADORES(IND_NAME,IND_RESPONSABLE,IND_OBJ,IND_LINEA_BASE,IND_META,IND_FRECUENCIA,IND_FORMULA,IND_RED_SYMBOL,IND_RED_VALUE,IND_YELLOW_SYMBOL,IND_YELLOW_VALUE,IND_GREEN_SYMBOL,IND_GREEN_VALUE,IND_PROC_ID,IND_SUB_ID,IND_ESTADO) VALUES(:nombre,:responsable,:obj,:linebase,:meta,:frecuency,:formula,:redSymbol,:redValue,:yellowSymbol,:yellowValue,:greenSymbol,:greenValue,:procId,:subId,'1')");
                $this->db->bind(':nombre',$name);
                $this->db->bind(':responsable',$responsable);
                $this->db->bind(':obj',$obj);
                $this->db->bind(':linebase',$lineBase);
                $this->db->bind(':meta',$meta);
                $this->db->bind(':frecuency',$frecuency);
                $this->db->bind(':formula',$formula);
                $this->db->bind(':redSymbol',$redSymbol);
                $this->db->bind(':redValue',$redValue);
                $this->db->bind(':yellowSymbol',$yellowSymbol);
                $this->db->bind(':yellowValue',$yellowValue);
                $this->db->bind(':greenSymbol',$greenSymbol);
                $this->db->bind(':greenValue',$greenValue);
                $this->db->bind(':procId',$procId);
                $this->db->bind(':subId',$subProcId);
                $bool= $this->db->execute();
                if(!$bool)
                    return $bool;
                $this->db->query("SELECT MAX(IND_ID) AS IND_ID FROM INDICADORES");
                $id = $this->db->getRegisty();
                foreach ($variables as $variable) {
                    $bool = $this->addVariable($variable->symbol,$variable->desc,$id->IND_ID);
                    if(!$bool)
                        return $bool;
                }
                foreach ($initiatives as $initiative) {
                    $bool = $this->addInitiative($initiative->desc,$id->IND_ID);
                    if(!$bool)
                        return $bool;
                }
                return true;
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function addVariable($symbol,$desc,$id){
            try {
                $this->db->query("INSERT INTO VARIABLE(VAR_SYMBOL,VAR_DESC,VAR_IND_ID) VALUES(:symbol,:descVar,:indId)");
                $this->db->bind(':symbol',$symbol);
                $this->db->bind(':descVar',$desc);
                $this->db->bind(':indId',$id);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function updateVariable($symbol,$desc,$id){
            try {
                $this->db->query("UPDATE VARIABLE SET VAR_SYMBOL=:symbol,VAR_DESC=:descVar WHERE VAR_ID=:id");
                $this->db->bind(':symbol',$symbol);
                $this->db->bind(':descVar',$desc);
                $this->db->bind(':id',$id);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function addInitiative($desc,$id){
            try {
                $this->db->query("INSERT INTO INICIATIVAS(INI_DESC,INI_IND_ID) VALUES(:descIni,:indId)");
                $this->db->bind(':descIni',$desc);
                $this->db->bind(':indId',$id);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function updateInitiative($desc,$id){
            try {
                $this->db->query("UPDATE INICIATIVAS SET INI_DESC=:descIni WHERE INI_ID=:id");
                $this->db->bind(':descIni',$desc);
                $this->db->bind(':id',$id);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getAllVariable(){
            try {
                $this->db->query("SELECT * FROM VARIABLES");
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getVariable($id){
            try {
                $this->db->query("SELECT * FROM VARIABLES WHERE VAR_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getVariableByIndicator($id){
            try {
                $this->db->query("SELECT * FROM VARIABLES WHERE VAR_IND_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getAllInitiative(){
            try {
                $this->db->query("SELECT * FROM INICIATIVAS");
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getInitiative($id){
            try {
                $this->db->query("SELECT * FROM INICIATIVAS WHERE INI_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getInitiativeByIndicator($id){
            try {
                $this->db->query("SELECT * FROM INICIATIVAS WHERE INI_IND_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function deleteVariable($id){
            try {
                $this->db->query("DELETE FROM VARIABLES WHERE VAR_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function deleteInitiative($id){
            try {
                $this->db->query("DELETE FROM INICIATIVAS WHERE INI_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function deleteVariablesbyIndId($id)
        {
            try {
                $this->db->query("DELETE FROM VARIABLES WHERE VAR_IND_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function deleteInitiativesbyIndId($id)
        {
            try {
                $this->db->query("DELETE FROM INICIATIVAS WHERE INI_IND_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getAll()
        {
            try {
                $this->db->query("SELECT * FROM INDICADORES");
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getAllByProceso($id)
        {
            try {
                $this->db->query("SELECT * FROM INDICADORES WHERE IND_PROC_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getAllBySubroceso($id)
        {
            try {
                $this->db->query("SELECT * FROM INDICADORES WHERE IND_SUB_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->getRegisties();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function get($id)
        {
            try {
                $this->db->query("SELECT * FROM INDICADORES WHERE IND_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getByName($nombre,$id)
        {
            try {
                $this->db->query("SELECT * FROM INDICADORES WHERE IND_NAME=:nombre AND IND_PROC_ID=:id");
                $this->db->bind(':nombre',$nombre);
                $this->db->bind(':id',$id);
                $bool = $this->db->getRegisty();
                if(is_object($bool))
                    return true;
                else
                    return false;
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getByName2($nombre,$id)
        {
            try {
                $this->db->query("SELECT * FROM INDICADORES WHERE IND_NAME=:nombre AND IND_SUB_ID=:id");
                $this->db->bind(':nombre',$nombre);
                $this->db->bind(':id',$id);
                $bool = $this->db->getRegisty();
                if(is_object($bool))
                    return true;
                else
                    return false;
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getByNameEdit($nombre,$id,$idInd)
        {
            try {
                $this->db->query("SELECT * FROM INDICADORES WHERE IND_NAME=:nombre AND IND_ID!=:idInd AND IND_PROC_ID=:id");
                $this->db->bind(':nombre',$nombre);
                $this->db->bind(':id',$id);
                $this->db->bind(':idInd',$idInd);
                $bool = $this->db->getRegisty();
                if(is_object($bool))
                    return true;
                else
                    return false;
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getByName2Edit($nombre,$id,$idInd)
        {
            try {
                $this->db->query("SELECT * FROM INDICADORES WHERE IND_NAME=:nombre AND IND_ID!=:idInd AND IND_SUB_ID=:id");
                $this->db->bind(':nombre',$nombre);
                $this->db->bind(':id',$id);
                $this->db->bind(':idInd',$idInd);
                $bool = $this->db->getRegisty();
                if(is_object($bool))
                    return true;
                else
                    return false;
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function delete($id)
        {
            try {
                $this->db->query("UPDATE INDICADORES SET IND_ESTADO='0' WHERE IND_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function update($name,$responsable,$obj,$lineBase,$meta,$frecuency,$formula,$redSymbol,$yellowSymbol,$greenSymbol,$redValue,$yellowValue,$greenValue,$variables,$initiatives,$id)
        {
            try {
                $this->db->query("UPDATE INDICADORES SET IND_NAME=:nombre,IND_RESPONSABLE=:responsable,IND_OBJ=:obj,IND_LINEA_BASE=:linebase,IND_META=:meta,IND_FRECUENCIA=:frecuency,IND_FORMULA=:formula,IND_RED_SYMBOL=:redSymbol,IND_RED_VALUE=:redValue,IND_YELLOW_SYMBOL=:yellowSymbol,IND_YELLOW_VALUE=:yellowValue,IND_GREEN_SYMBOL=:greenSymbol,IND_GREEN_VALUE=:greenValue WHERE IND_ID=:id");
                $this->db->bind(':nombre',$name);
                $this->db->bind(':responsable',$responsable);
                $this->db->bind(':obj',$obj);
                $this->db->bind(':linebase',$lineBase);
                $this->db->bind(':meta',$meta);
                $this->db->bind(':frecuency',$frecuency);
                $this->db->bind(':formula',$formula);
                $this->db->bind(':redSymbol',$redSymbol);
                $this->db->bind(':redValue',$redValue);
                $this->db->bind(':yellowSymbol',$yellowSymbol);
                $this->db->bind(':yellowValue',$yellowValue);
                $this->db->bind(':greenSymbol',$greenSymbol);
                $this->db->bind(':greenValue',$greenValue);
                $this->db->bind(':id',$id);
                $bool= $this->db->execute();
                if(!$bool)
                    return $bool;
                $bool = $this->deleteInitiativesbyIndId($id);
                if(!$bool);
                    return $bool;
                $bool = $this->deleteVariablesbyIndId($id);
                if(!$bool);
                    return $bool;
                foreach ($variables as $variable) {
                    $bool = $this->addVariable($variable->symbol,$variable->desc,$id);
                    if(!$bool)
                        return $bool;
                }
                foreach ($initiatives as $initiative) {
                    $bool = $this->addInitiative($initiative->desc,$id);
                    if(!$bool)
                        return $bool;
                }
                return true;
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }