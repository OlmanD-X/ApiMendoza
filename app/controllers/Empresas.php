<?php
  class Empresas extends Controller{

    public function __construct(){
      $this->modelEmpresa = $this->model('Empresa');
    }

    public function ctrMostrarEmpresas($item=null, $valor=null){
      $tabla = "empresas";
      $respuesta = $this->modelEmpresa->mdlMostrarEmpresas($tabla, $item, $valor);
      //print_r($respuesta);
      echo json_encode($respuesta);
    }

    public function ctrCrearEmpresa(){

      if( isset($_POST["new_empRS"]) ){

        $Empresa = validateAlfaNumeric('Razon Social', $_POST["new_empRS"], 'Alfanumeric');
        $RUC = validateRuc($_POST["new_empRUC"]);

        //Hacemos la consulta para verificar que no haya datos repetidos.
        $verificacion = $this->modelEmpresa->mdlVerificar_Empresa($Empresa, $RUC, null);

        if( $verificacion == "No hay datos" ){

          // Validar Imagen
          $ruta = "img/productos/default/anonymous.png";
          if(isset($_FILES["new_empLogo"]["tmp_name"])){
            list($ancho, $alto) = getimagesize($_FILES["new_empLogo"]["tmp_name"]);
            $nuevoAncho = 500;
            $nuevoAlto = 500;

            // CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
            $directorio = "img/empresa/".$_POST["new_empRUC"];
            mkdir($directorio, 0755);

            // DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP/
            if($_FILES["new_empLogo"]["type"] == "image/jpeg"){
              // GUARDAMOS LA IMAGEN EN EL DIRECTORIO
              $aleatorio = mt_rand(100,999);
              $ruta = "img/empresa/".$_POST["new_empRUC"]."/".$aleatorio.".jpg";
              $origen = imagecreatefromjpeg($_FILES["new_empLogo"]["tmp_name"]);						
              $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
              imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
              imagejpeg($destino, $ruta);
            }

            if($_FILES["new_empLogo"]["type"] == "image/png"){
              // GUARDAMOS LA IMAGEN EN EL DIRECTORIO
              $aleatorio = mt_rand(100,999);
              $ruta = "img/empresa/".$_POST["new_empRUC"]."/".$aleatorio.".png";
              $origen = imagecreatefrompng($_FILES["new_empLogo"]["tmp_name"]);						
              $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
              imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
              imagepng($destino, $ruta);
            }

          }

          $tabla = "empresas";
          $datos = array("EMP_RS" => $_POST["new_empRS"],
                  "EMP_RUC" => $_POST["new_empRUC"],
                  "EMP_LOGO" => $ruta,
                  "EMP_ESTADO" => '1');

          $respuesta = $this->modelEmpresa->mdlRegistrarEmpresa($tabla, $datos);

          if($respuesta == "ok"){
            returnResponse(REGISTY_INSERT_SUCCESSFULLY, "Empresa creada correctamente");
          }else{
            throwError(INSERTED_DATA_NOT_COMPLETE, "Error al registrar la empresa.");
          }

        }else{
          throwError(INSERTED_DATA_NOT_COMPLETE, "La 'Razón Social' y/o 'RUC' ya se encuentran registrados.");
        }
      }else{
        throwError(INSERTED_DATA_NOT_COMPLETE, "Campos de entrada, no definidos.");
      }
    }

    public function ctrEditarEmpresa(){

      if( isset($_POST["edit_empRS"]) ){
  
        $Empresa = validateAlfaNumeric('Razon Social', $_POST["edit_empRS"], 'Alfanumeric');
        $RUC = validateRuc($_POST["edit_empRUC"]);
        $id = $_POST["Id_Empresa"];

        //Hacemos la consulta para verificar que no haya datos repetidos.
        $verificacion = $this->modelEmpresa->mdlVerificar_Empresa($Empresa, $RUC, $id);

        if( $verificacion == "Actualizar" ){
 
          // Validar Imagen
          // $ruta = $_POST["logoActual"];  
          // if(isset($_FILES["edit_empLogo"]["tmp_name"]) && !empty($_FILES["edit_empLogo"]["tmp_name"])){
          //   list($ancho, $alto) = getimagesize($_FILES["edit_empLogo"]["tmp_name"]);
          //   $nuevoAncho = 500;
          //   $nuevoAlto = 500;

          //   // CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
          //   $directorio = "img/empresa/".$_POST["edit_empRUC"];

          //   // PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
          //   if(!empty($_POST["logoActual"]) && $_POST["logoActual"] != "img/productos/default/anonymous.png"){
          //     unlink($_POST["logoActual"]);
          //   }else{
          //     mkdir($directorio, 0755);	
          //   }

          //   // DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP

          //   if($_FILES["edit_empLogo"]["type"] == "image/jpeg"){
          //     // GUARDAMOS LA IMAGEN EN EL DIRECTORIO
          //     $aleatorio = mt_rand(100,999);
          //     $ruta = "img/productos/".$_POST["edit_empRUC"]."/".$aleatorio.".jpg";
          //     $origen = imagecreatefromjpeg($_FILES["edit_empLogo"]["tmp_name"]);						
          //     $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
          //     imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
          //     imagejpeg($destino, $ruta);
          //   }

          //   if($_FILES["edit_empLogo"]["type"] == "image/png"){
          //     // GUARDAMOS LA IMAGEN EN EL DIRECTORIO
          //     $aleatorio = mt_rand(100,999);
          //     $ruta = "img/productos/".$_POST["edit_empRUC"]."/".$aleatorio.".png";
          //     $origen = imagecreatefrompng($_FILES["edit_empLogo"]["tmp_name"]);						
          //     $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
          //     imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
          //     imagepng($destino, $ruta);
          //   }
              
          // }
          
          $tabla = "empresas";
          $datos = array("EMP_RS" => $_POST["edit_empRS"],
                          "EMP_RUC" => $_POST["edit_empRUC"],
                          "EMP_ESTADO" => '1');

          $respuesta = $this->modelEmpresa->mdlEditarEmpresa($tabla, $datos, $id);

          if($respuesta == "ok"){
            returnResponse(REGISTY_INSERT_SUCCESSFULLY, "Empresa actualizada correctamente");
          }else{
            throwError(INSERTED_DATA_NOT_COMPLETE, "Error al actualizar la empresa.");
          }

        }else{
          throwError(INSERTED_DATA_NOT_COMPLETE, "No se puede actualizar, porque la 'Razón Social' y/o 'RUC' ya se encuentran registrados.");
        }
      }else{
        throwError(INSERTED_DATA_NOT_COMPLETE, "Campos de entrada, no definidos.");
      }
    }

    public function ctrEliminarEmpresa($id){

      $tabla ="empresas";
      
      if ( is_numeric($id) ){

        /*
        //Obtenemos los datos con el ID para eliminar la foto
        $respuesta = $this->modelEmpresa->mdlTraerDatos_Empresa($tabla, $id);
        $array = json_decode(json_encode($respuesta), true);
        print_r($respuesta);
        print_r($array);
        print_r("\n ---".$array["EMP_LOGO"]);

        if( $array["EMP_LOGO"]!="" && $array["EMP_LOGO"]!="img/empresa/default/anonymous.png"){
          unlink( $array["EMP_LOGO"] );
          rmdir('img/empresa/'.$array["EMP_RUC"]);
        }
        */

        $resp = $this->modelEmpresa->mdlEliminarEmpresa($tabla, $id);

        if($resp == "ok"){
          returnResponse(REGISTY_INSERT_SUCCESSFULLY, "Empresa eliminada correctamente");
        }else{
          throwError(INSERTED_DATA_NOT_COMPLETE, "Error al eliminar la empresa.");
        }

      }else{
        throwError(CONTENT_TYPE_NOT_VALID, "El Id que busca, no es válido.");
      }

    }
  }
