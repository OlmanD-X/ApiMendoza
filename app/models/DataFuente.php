<?php

  class DataFuente{
    private $db;

    public function __construct(){
        $this->db = new Connection;
        if($this->db->error)
            throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
    }

    public function mdlMostrar_DataFuente($tabla, $item, $valor){

      try {
        if($item != null){
          $this->db->query("SELECT * FROM $tabla WHERE $item = :$item");
          $this->db->bind(':'.$item, $valor);
          return $this->db->getRegisties();
        }else{
          $this->db->query("SELECT * FROM $tabla");
          return $this->db->getRegisties();
        }
      } catch (\Throwable $th) {
          return $th->getMessage();
      }

    }

    public function mdlMostrar_variablesDF($tabla, $item, $valor){

      try {
        if($item != null){
          $this->db->query("SELECT * FROM $tabla WHERE $item = :$item");
          $this->db->bind(':'.$item, $valor);
          return $this->db->getRegisties();
        }else{
          $this->db->query("SELECT * FROM $tabla");
          return $this->db->getRegisties();
        }
      } catch (\Throwable $th) {
          return $th->getMessage();
      }

    }

    public function mdlRegistrar_DataFuente($tabla, $datos){

      try {
        $this->db->query("INSERT INTO $tabla(DF_PERIODO, DF_RESULT, DF_IND_ID, DF_RUTA_ARCHIVO) VALUES (:DF_PERIODO, :DF_RESULT, :DF_IND_ID, :DF_RUTA_ARCHIVO)");
        $this->db->bind(':DF_PERIODO', $datos["DF_PERIODO"]);
        $this->db->bind(':DF_RESULT', $datos["DF_RESULT"]);
        $this->db->bind(':DF_IND_ID', $datos["DF_IND_ID"]);
        $this->db->bind(':DF_RUTA_ARCHIVO', $datos["DF_RUTA_ARCHIVO"]);
        
        if ( $this->db->execute() ){
          $this->db->query("SELECT MAX(DF_ID) AS ID FROM resumen_data_fuente");
          $array = json_decode(json_encode( $this->db->getRegisty() ), true);
          //print_r($array);
          return $array["ID"];
        }else{
          return -1;
        }

      } catch (\Throwable $th) {
          return $th->getMessage();
      }
  
    }

    public function mdlRegistrar_variablesDF($tabla, $variables, $id_DataFuente){

      try {

        $cont = 0;
        for ($i=0; $i < count($variables); $i++) { 
          $this->db->query("INSERT INTO $tabla(VAR_VALUE, VAR_DF_ID) VALUES (:VAR_VALUE, :VAR_DF_ID)");
          $this->db->bind(':VAR_VALUE', $variables[$i]);
          $this->db->bind(':VAR_DF_ID', $id_DataFuente);
          if ( $this->db->execute() ){
            $cont++;
          }
        }
        
        if ( $cont == count($variables) ){
          return "ok";
        }else{
          return "error";
        }

      } catch (\Throwable $th) {
          return $th->getMessage();
      }
  
    }

    public function mdlEditar_objEstrategico($tabla, $descripcion, $id_empresa, $id){

      try {
        $this->db->query("UPDATE $tabla SET OE_DESC = :OE_DESC, OE_EMP_ID = :OE_EMP_ID WHERE OE_ID = :OE_ID");
        $this->db->bind(':OE_DESC', $descripcion);
        $this->db->bind(':OE_EMP_ID', $id_empresa);
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

    public function mdlVerificar_objEstrategicos($oe_desc, $id){

      try {

        if ( $id==null) {
          $this->db->query("SELECT * FROM objetivos_estrategicos WHERE OE_DESC = :OE_DESC");
          $this->db->bind(':OE_DESC', $oe_desc);
          
          if ( count($this->db->getRegisties())>0 ){
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

    public function mdlActualizar_resultadoDF($tabla, $variables, $id){

      try {

        $result_Formula = calcularResultado($variables);
        
        $this->db->query("UPDATE $tabla SET DF_RESULT = :DF_RESULT WHERE DF_ID = :DF_ID");
        $this->db->bind(':DF_RESULT', $result_Formula);
        $this->db->bind(':DF_ID', $id);
        
        if ( $this->db->execute() ){
          return "ok";
        }else{
          return "error";
        }

      } catch (\Throwable $th) {
          return $th->getMessage();
      }

    }

  }