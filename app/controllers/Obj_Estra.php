<?php

  class Obj_Estra extends Controller{

    public function __construct(){
      $this->modelObjEstra = $this->model('ObjEstra');
    }

    public function ctrMostrar_objEstrategicos($item=null, $valor=null){
      $tabla = "objetivos_estrategicos";
      $respuesta = $this->modelObjEstra->mdlMostrar_objEstrategicos($tabla, $item, $valor);
      //print_r($respuesta);
      echo json_encode($respuesta);
    }

    public function ctrCrear_objEstrategico(){

      if( isset($_POST["new_oeDesc"]) ){

        $OE_Desc = validateAlfaNumeric('Descripción Objetivo Estratégico.', $_POST["new_oeDesc"], 'Alfanumeric');

        //Hacemos la consulta para verificar que no haya datos repetidos.
        $verificacion = $this->modelObjEstra->mdlVerificar_objEstrategicos($OE_Desc, null);

        if( $verificacion == "No hay datos" ){

          $tabla = "objetivos_estrategicos";
          $IdEmpresa = $_POST["Id_Empresa"];
          $datos = array("OE_DESC" => $_POST["new_oeDesc"],
                  "OE_EMP_ID" => $IdEmpresa);

          $respuesta = $this->modelObjEstra->mdlRegistrar_objEstrategico($tabla, $datos);

          if($respuesta == "ok"){
            returnResponse(REGISTY_INSERT_SUCCESSFULLY, "Objetivo Estratégico creado correctamente");
          }else{
            throwError(INSERTED_DATA_NOT_COMPLETE, "Error al registrar la Objetivo Estratégico.");
          }

        }else{
          throwError(INSERTED_DATA_NOT_COMPLETE, "Dicho 'objetivo estratégico' ya se encuentra registrado.");
        }
      }else{
        throwError(INSERTED_DATA_NOT_COMPLETE, "Campos de entrada, no definidos.");
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