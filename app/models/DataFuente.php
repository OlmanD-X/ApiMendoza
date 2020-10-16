<?php

  class DataFuente{
    private $db;

    public function __construct(){
        $this->db = new Connection;
        if($this->db->error)
            throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
    }

    public function mdlObtener_IdsVariables($tabla, $item, $valor){

      try {
        $this->db->query("SELECT VAR_ID FROM $tabla WHERE $item = :$item");
        $this->db->bind(':'.$item, $valor);
        return $this->db->getRegisties();
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

    public function mdlEditar_DataFuente($tabla, $datos, $id){

      try {
        $this->db->query("UPDATE $tabla SET DF_PERIODO = :DF_PERIODO WHERE DF_ID = :DF_ID");
        $this->db->bind(':DF_PERIODO', $datos);
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

    public function mdlEditar_variablesDF($tabla, $variables, $Ids_variables, $id_df){

      try {

        $cont = 0;
        for ($i=0; $i < count($variables); $i++) { 
          $this->db->query("UPDATE $tabla SET VAR_VALUE = :VAR_VALUE WHERE VAR_DF_ID = :VAR_DF_ID AND VAR_ID = :VAR_ID");
          $this->db->bind(':VAR_VALUE', $variables[$i]);
          $this->db->bind(':VAR_ID', $Ids_variables[$i]["VAR_ID"]);          
          $this->db->bind(':VAR_DF_ID', $id_df);
          if ( $this->db->execute() ){
            $cont++;
            //print_r($Ids_variables[$i]["VAR_ID"]);
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

    public function mdlEliminar_DataFuente($tabla, $id){

      try {
        $tabla2 = "variable_data_fuente";
        $this->db->query("DELETE FROM $tabla2 WHERE VAR_DF_ID=:VAR_DF_ID"); 
        $this->db->bind(':VAR_DF_ID', $id);

        if ( $this->db->execute() ){
          $this->db->query("DELETE FROM $tabla WHERE DF_ID=:DF_ID"); 
          $this->db->bind(':DF_ID', $id);
          
          if ( $this->db->execute() ){
            return "ok";
          }else{
            return "error";
          }
          
        }else{
          return "error";
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