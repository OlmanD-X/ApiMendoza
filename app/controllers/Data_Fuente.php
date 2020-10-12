<?php

  class Data_Fuente extends Controller{

    public function __construct(){
      $this->modelDataFuente = $this->model('DataFuente');
    }

    public function ctrMostrar_ListaDF($valor0){
            
      $aux = array();

      // || ID || PERIODO || #VARIABLES || RESULTADO || ACCIONES
      // Traemos los datos de la data fuente
      $tabla = "resumen_data_fuente";
      $item0 = "DF_IND_ID";
      $respuesta = $this->modelDataFuente->mdlMostrar_DataFuente($tabla, $item0, $valor0);
      $array = json_decode(json_encode($respuesta), true);

      for ($i=0; $i < count($array); $i++) { 
        $listaDatos = array();
        array_push($listaDatos, $array[$i]["DF_ID"], $array[$i]["DF_PERIODO"]);
      
        // Juntamos las variables
        $tabla = "variable_data_fuente";
        $item = "VAR_DF_ID";
        $valor = $array[$i]["DF_ID"];
        $respuesta2 = $this->modelDataFuente->mdlMostrar_variablesDF($tabla, $item, $valor);
        $array2 = json_decode(json_encode($respuesta2), true);
        for ($j=0; $j < count($array2) ; $j++) { 
          array_push($listaDatos, $array2[$j]["VAR_VALUE"]);
        }
        
        array_push($listaDatos, $array[$i]["DF_RESULT"]);
        $aux[] = $listaDatos;
        unset($listaDatos);
      }

      //print_r($aux);
      echo json_encode($aux);
    
    }

    public function ctrCrear_DataFuente(){

      $variables = $_POST["new_variables"];

      $verificarVariables = true;
      for ($i=0; $i < count($variables); $i++) { 
        if ( !(preg_match('/^\d{1,8}(\.\d{1,3})?$/', $variables[$i])) && $verificarVariables){
          $verificarVariables = false;
        }
      }

      if( isset($_POST["new_dfPeriodo"]) && $verificarVariables ){
                
        $DF_PERIODO = validateAlfaNumeric('Periodo.', $_POST["new_dfPeriodo"], 'Alfanumeric');

        $Id_Indicador = $_POST["Id_Indicador"];
        $datos = array("DF_PERIODO" => $DF_PERIODO,
                "DF_RESULT" => 0.00,
                "DF_IND_ID" => $Id_Indicador,
                "DF_RUTA_ARCHIVO" => "");

        $respuesta = $this->modelDataFuente->mdlRegistrar_DataFuente("resumen_data_fuente", $datos);

        if($respuesta !=-1 ){
 
          $resp = $this->modelDataFuente->mdlRegistrar_variablesDF("variable_data_fuente", $variables, $respuesta);

          if ( $resp=="ok" ){

            $resultadoFinal = $this->modelDataFuente->mdlActualizar_resultadoDF("resumen_data_fuente", $variables, $respuesta);

            if ( $resultadoFinal=="ok" ){
              returnResponse(REGISTY_INSERT_SUCCESSFULLY, "Data Fuente, y variables creados correctamente.");
            }else{
              throwError(INSERTED_DATA_NOT_COMPLETE, "Error al registrar el resultado de las variables de la DATA FUENTE.");
            }
            
          }else{
            throwError(INSERTED_DATA_NOT_COMPLETE, "Error al registrar las variables de la DATA FUENTE.");
          }
          
        }else{
          throwError(INSERTED_DATA_NOT_COMPLETE, "Error al registrar los datos de la DATA FUENTE.");
        }

      }else{
        throwError(INSERTED_DATA_NOT_COMPLETE, "Datos que intenta ingresar no son válidos. Verifique que el valor de las variables no contenga COMAS(,).");
      }
    }

    public function ctrEditar_DataFuente(){

      $variables = $_POST["edit_variables"];

      $verificarVariables = true;
      for ($i=0; $i < count($variables); $i++) { 
        if ( !(preg_match('/^\d{1,8}(\.\d{1,3})?$/', $variables[$i])) && $verificarVariables){
          $verificarVariables = false;
        }else{
          print_r($variables[$i]);
        }
      }

      if( isset($_POST["edit_dfPeriodo"]) && $verificarVariables ){
                
        $DF_PERIODO = validateAlfaNumeric('Periodo.', $_POST["edit_dfPeriodo"], 'Alfanumeric');
        $Id_DF = $_POST["edit_DF_ID"];
        $respuesta = $this->modelDataFuente->mdlEditar_DataFuente("resumen_data_fuente", $DF_PERIODO, $Id_DF);

        if($respuesta=="ok" ){
 
          $temporal = $this->modelDataFuente->mdlObtener_IdsVariables("variable_data_fuente", "VAR_DF_ID", $Id_DF);
          $Ids_variables = json_decode(json_encode($temporal), true);
          $resp = $this->modelDataFuente->mdlEditar_variablesDF("variable_data_fuente", $variables, $Ids_variables, $Id_DF);

          if ( $resp=="ok" ){

            $resultadoFinal = $this->modelDataFuente->mdlActualizar_resultadoDF("resumen_data_fuente", $variables, $Id_DF);

            if ( $resultadoFinal=="ok" ){
              returnResponse(REGISTY_INSERT_SUCCESSFULLY, "Data Fuente, y variables actualizados correctamente.");
            }else{
              throwError(INSERTED_DATA_NOT_COMPLETE, "Error al actualizar el resultado de las variables de la DATA FUENTE.");
            }
            
          }else{
            throwError(INSERTED_DATA_NOT_COMPLETE, "Error al actualizar las variables de la DATA FUENTE.");
          }
          
        }else{
          throwError(INSERTED_DATA_NOT_COMPLETE, "Error al actualizar los datos de la DATA FUENTE.");
        }

      }else{
        throwError(INSERTED_DATA_NOT_COMPLETE, "Datos que intenta actualizar no son válidos. Verifique que el valor de las variables no contenga COMAS(,).");
      }
    }

    public function ctrEliminar_DataFuente($id){
     
      if ( is_numeric($id) ){

        $resp = $this->modelDataFuente->mdlEliminar_DataFuente("resumen_data_fuente", $id);

        if($resp == "ok"){
          returnResponse(REGISTY_INSERT_SUCCESSFULLY, "Data Fuente eliminada correctamente.");
        }else{
          throwError(INSERTED_DATA_NOT_COMPLETE, "Error al eliminar la data fuente seleccionada.");
        }

      }else{
        throwError(CONTENT_TYPE_NOT_VALID, "El Id que intenta ingresar no es válido, no es válido.");
      }

    }

  }

  //prueba