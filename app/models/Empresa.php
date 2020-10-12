<?php

  class Empresa{
    private $db;

    public function __construct(){
        $this->db = new Connection;
        if($this->db->error)
            throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
    }

    public function mdlMostrarEmpresas($tabla, $item, $valor){

      try {
        if($item != null){
          $this->db->query("SELECT * FROM $tabla WHERE $item = :$item AND EMP_ESTADO='1' ORDER BY EMP_ID DESC");
          $this->db->bind(':'.$item, $valor);
          return $this->db->getRegisty();
        }else{
          $this->db->query("SELECT * FROM $tabla WHERE EMP_ESTADO='1' ORDER BY EMP_ID DESC");
          return $this->db->getRegisties();
        }
      } catch (\Throwable $th) {
          return $th->getMessage();
      }

    }

    public function mdlRegistrarEmpresa($tabla, $datos){

      try {
        $this->db->query("INSERT INTO $tabla(EMP_RS, EMP_RUC, EMP_LOGO, EMP_ESTADO) VALUES (:EMP_RS, :EMP_RUC, :EMP_LOGO, :EMP_ESTADO)");
        $this->db->bind(':EMP_RS', $datos["EMP_RS"]);
        $this->db->bind(':EMP_RUC', $datos["EMP_RUC"]);
        $this->db->bind(':EMP_LOGO', $datos["EMP_LOGO"]);
        $this->db->bind(':EMP_ESTADO', $datos["EMP_ESTADO"]);
        
        if ( $this->db->execute() ){
          return "ok";
        }else{
          return "error";
        }

      } catch (\Throwable $th) {
          return $th->getMessage();
      }
  
    }

    public function mdlEditarEmpresa($tabla, $datos, $id){

      try {
        $this->db->query("UPDATE $tabla SET EMP_RS = :EMP_RS, EMP_RUC = :EMP_RUC, EMP_LOGO = :EMP_LOGO, EMP_ESTADO = :EMP_ESTADO WHERE EMP_ID = :EMP_ID");
        $this->db->bind(':EMP_RS', $datos["EMP_RS"]);
        $this->db->bind(':EMP_RUC', $datos["EMP_RUC"]);
        $this->db->bind(':EMP_LOGO', $datos["EMP_LOGO"]);
        $this->db->bind(':EMP_ESTADO', $datos["EMP_ESTADO"]);
        $this->db->bind(':EMP_ID', $id);
        
        if ( $this->db->execute() ){
          return "ok";
        }else{
          return "error";
        }

      } catch (\Throwable $th) {
          return $th->getMessage();
      }
  
    }

    public function mdlEliminarEmpresa($tabla, $id){

      try {
        $this->db->query("UPDATE $tabla SET EMP_ESTADO = :EMP_ESTADO WHERE EMP_ID = :EMP_ID"); //Solo cambiar estado
        $this->db->bind(':EMP_ESTADO', '0');
        $this->db->bind(':EMP_ID', $id);

        if ( $this->db->execute() ){
          return "ok";
        }else{
          return "error";
        }

      } catch (\Throwable $th) {
          return $th->getMessage();
      }
  
    }

    public function mdlVerificar_Empresa($Empresa, $ruc, $id){

      try {

        if ( $id==null) {
          $this->db->query("SELECT * FROM empresas WHERE EMP_RS = :EMP_RS OR EMP_RUC = :EMP_RUC AND EMP_ESTADO='1'");
          $this->db->bind(':EMP_RS', $Empresa);
          $this->db->bind(':EMP_RUC', $ruc);
          
          if ( count($this->db->getRegisties())>0 ){
            return "Hay datos";
          }else{
            return "No hay datos";
          }
        }else{
          $this->db->query("SELECT * FROM empresas WHERE EMP_ID != :EMP_ID AND EMP_RS = :EMP_RS AND EMP_RUC = :EMP_RUC");
          $this->db->bind(':EMP_RS', $Empresa);
          $this->db->bind(':EMP_RUC', $ruc);
          $this->db->bind(':EMP_ID', $id);
          
          if ( count($this->db->getRegisties())>0 ){
            return "No actualizar";
          }else{
            return "Actualizar";
          }
        }      

      } catch (\Throwable $th) {
          return $th->getMessage();
      }

    }

    public function mdlTraerDatos_Empresa($tabla, $id){

      try {
        $this->db->query("SELECT * FROM $tabla WHERE EMP_ID = :EMP_ID AND EMP_ESTADO='1' ");
        $this->db->bind(':EMP_ID', $id);
        return $this->db->getRegisty();

      } catch (\Throwable $th) {
          return $th->getMessage();
      }

    }

  }