<?php
    class Detalles_me extends Controller{
        public function __construct(){
            $this->modelDetalles = $this->model('Detalle_me');
        }

        public function add(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            
            $DET_OBJ_ID = $_POST['DET_OBJ_ID']??NULL;
            $DET_OE_ID = $_POST['DET_OE_ID'] ?? NULL;
            $DET_PERS_ID = $_POST['DET_PERS_ID'] ?? NULL;
            $ME_ID = $_POST['ME_ID'] ?? NULL;
            $type = $_POST['type'] ?? NULL;
            $field = '';
            $ID = '';
            if($type == 'OP'){
                $field = 'DET_OBJ_ID';
                $ID = $DET_OBJ_ID;
            }  
            else if($type == 'OE'){
                $field = 'DET_OE_ID';
                $ID = $DET_OE_ID;
            }
            else if(is_null($type))
                throwError(INSERTED_DATA_NOT_COMPLETE,'Especifique el tipo de objetivo');
            $obj = $this->modelDetalles->validateIdObjetivo($ME_ID,$ID,$field);
            if(is_object($obj))
                throwError(INSERTED_DATA_NOT_COMPLETE,'El objetivo ya ha sido registrado en una perspectiva.');
            $insert = $this->modelDetalles->add($DET_OBJ_ID,$DET_OE_ID,$DET_PERS_ID,$ME_ID);
            if($insert){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Datos registrados exitosamente');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al registrar los datos');
            }
        }
       
        public function getAll($idME){
            $data = $this->modelDetalles->getAll($idME);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }

        public function getOne($DET_ID){
            $data = $this->modelDetalles->getOne($DET_ID);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }

        public function update(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');

            $DET_ID = $_POST['DET_ID'];
            $DET_OBJ_ID = $_POST['DET_OBJ_ID'] ?? NULL;
            $DET_OE_ID = $_POST['DET_OE_ID'] ?? NULL;
            $DET_PERS_ID = $_POST['DET_PERS_ID'] ?? NULL;
            //VALIDAR LOGO

            $update = $this->modelDetalles->update($DET_ID,$DET_OBJ_ID,$DET_OE_ID,$DET_PERS_ID);
            if($update){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Datos actualizados exitosamente');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al actualizar los datos');
            }
        }
        
        public function delete($DET_ID){
            $delete = $this->modelDetalles->delete($DET_ID);
            if($delete){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Registro eliminado con éxito');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al eliminar registro');
            }
        }
    }