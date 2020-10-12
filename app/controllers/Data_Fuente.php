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

        $tabla = "resumen_data_fuente";
        $Id_Indicador = $_POST["Id_Indicador"];
        $datos = array("DF_PERIODO" => $DF_PERIODO,
                "DF_RESULT" => 0.00,
                "DF_IND_ID" => $Id_Indicador,
                "DF_RUTA_ARCHIVO" => "");

        $respuesta = $this->modelDataFuente->mdlRegistrar_DataFuente($tabla, $datos);

        if($respuesta !=-1 ){
 
          $tabla = "variable_data_fuente";
          $resp = $this->modelDataFuente->mdlRegistrar_variablesDF($tabla, $variables, $respuesta);

          if ( $resp=="ok" ){

            $tabla = "resumen_data_fuente";
            $resultadoFinal = $this->modelDataFuente->mdlActualizar_resultadoDF($tabla, $variables, $respuesta);

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

    public function ctrEditar_objEstrategico(){

      if( isset($_POST["edit_oeDesc"]) ){
  
        $OE_Desc = validateAlfaNumeric('Descripción Objetivo Estratégico.', $_POST["edit_oeDesc"], 'Alfanumeric');
        $id = $_POST["Id_ObjEstra"];
        $id_empresa = $_POST["edit_oeEmpId"];
        //Hacemos la consulta para verificar que no haya datos repetidos.
        $verificacion = $this->modelObjEstra->mdlVerificar_objEstrategicos($OE_Desc, $id);
        
        if( $verificacion == "Actualizar" ){
           
          $tabla = "objetivos_estrategicos";
          $descripcion = $_POST["edit_oeDesc"];
          $respuesta = $this->modelObjEstra->mdlEditar_objEstrategico($tabla, $descripcion, $id_empresa, $id);

          if($respuesta == "ok"){
            returnResponse(REGISTY_INSERT_SUCCESSFULLY, "Objetivo Estratégico actualizado correctamente.");
          }else{
            throwError(INSERTED_DATA_NOT_COMPLETE, "Error al actualizar el Objetivo Estratégico.");
          }

        }else{
          throwError(INSERTED_DATA_NOT_COMPLETE, "No se puede actualizar, porque el Objetivo Estratégico ya se encuentra registrado.");
        }
      }else{
        throwError(INSERTED_DATA_NOT_COMPLETE, "Campos de entrada, no definidos.");
      }
    }

    public function ctrEliminar_objEstrategico($id){

      $tabla ="objetivos_estrategicos";
      
      if ( is_numeric($id) ){

        $resp = $this->modelObjEstra->mdlEliminar_objEstrategico($tabla, $id);

        if($resp == "ok"){
          returnResponse(REGISTY_INSERT_SUCCESSFULLY, "Objetivo Estratégico eliminado correctamente.");
        }else{
          throwError(INSERTED_DATA_NOT_COMPLETE, "Error al eliminar el Objetivo Estratégico.");
        }

      }else{
        throwError(CONTENT_TYPE_NOT_VALID, "El Id que intenta ingresar no es válido, no es válido.");
      }

    }

  }