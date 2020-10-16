<?php

  class ObjEstra{
    private $db;

    public function __construct(){
        $this->db = new Connection;
        if($this->db->error)
            throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
    }

    public function mdlMostrar_objEstrategicos($tabla, $item, $valor){

      try {
        if($item != null){
          $this->db->query("SELECT * FROM $tabla WHERE $item = :$item ORDER BY OE_ID DESC");
          $this->db->bind(':'.$item, $valor);
          return $this->db->getRegisties();
        }else{
          $this->db->query("SELECT * FROM $tabla ORDER BY OE_ID DESC");
          return $this->db->getRegisties();
        }
      } catch (\Throwable $th) {
          return $th->getMessage();
      }

    }

    public function mdlRegistrar_objEstrategico($tabla, $datos){

      try {
        $this->db->query("INSERT INTO $tabla(OE_DESC, OE_EMP_ID) VALUES (:OE_DESC, :OE_EMP_ID)");
        $this->db->bind(':OE_DESC', $datos["OE_DESC"]);
        $this->db->bind(':OE_EMP_ID', $datos["OE_EMP_ID"]);
        
        if ( $this->db->execute() ){
          return "ok";
        }else{
          return "error";
        }

      } catch (\Throwable $th) {
          return $th->getMessage();
      }
  
    }

    public function mdlEditar_objEstrategico($tabla, $descripcion, $id){

      try {
        $this->db->query("UPDATE $tabla SET OE_DESC = :OE_DESC WHERE OE_ID = :OE_ID");
        $this->db->bind(':OE_DESC', $descripcion);
        $this->db->bind(':OE_ID', $id);
        
        if ( $this->db->execute() ){
          return "ok";
        }else{
          return "error";
        }

      } catch (\Throwable $th) {
          return $th->getMessage();
      }
  
    }

    public function mdlEliminar_objEstrategico($tabla, $id){

      try {
        $this->db->query("DELETE FROM $tabla WHERE OE_ID=:OE_ID"); 
        $this->db->bind(':OE_ID', $id);

        if ( $this->db->execute() ){
          return "ok";
        }else{
          return "error";
        }

      } catch (\Throwable $th) {
          return $th->getMessage();
      }
  
    }

    public function mdlVerificar_objEstrategicos($oe_desc,$idEmp, $id = null){

      try {

        if ( $id==null) {
          $this->db->query("SELECT * FROM objetivos_estrategicos WHERE OE_DESC = :OE_DESC AND OE_EMP_ID=:idEmp");
          $this->db->bind(':OE_DESC', $oe_desc);
          $this->db->bind(':idEmp', $idEmp);
          $obj = $this->db->getRegisty();
          if (is_object($obj)){
            return "Hay datos";
          }else{
            return "No hay datos";
          }
        }else{
          $this->db->query("SELECT * FROM objetivos_estrategicos WHERE OE_ID != :OE_ID AND OE_DESC = :OE_DESC ");
          $this->db->bind(':OE_DESC', $oe_desc);
          $this->db->bind(':OE_ID', $id);
          
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

  }