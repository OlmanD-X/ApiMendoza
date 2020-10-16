<?php
    class Perspectivas extends Controller{
        public function __construct(){
            $this->modelPers = $this->model('Perspectiva');
        }

        public function add(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            
            $PERS_NAME = validateAlfanumeric('perspectiva',validateParameter('Perspectiva', trim($_POST['PERS_NAME']),STRING),'Alfa');
            $PERS_ORDEN = $_POST['PERS_ORDEN'] ?? NULL;
            $PERS_ME_ID = $_POST['PERS_ME_ID'] ?? NULL;
            $bool = $this->modelPers->validateName($PERS_NAME,$PERS_ME_ID);
            if($bool)
                throwError(INSERTED_DATA_NOT_COMPLETE,"La perspectiva $PERS_NAME ya existe");
            $bool = $this->modelPers->validateLevel($PERS_ORDEN,$PERS_ME_ID);
            if($bool)
                throwError(INSERTED_DATA_NOT_COMPLETE,"El orden $PERS_ORDEN ya existe");
            $insert = $this->modelPers->add($PERS_NAME,$PERS_ORDEN,$PERS_ME_ID);
            if($insert){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Datos registrados exitosamente');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al registrar los datos');
            }
        }
       
        public function getAll($id){
            $data = $this->modelPers->getAll($id);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }

        public function getOne($PERS_ID){
            $data = $this->modelPers->getOne($PERS_ID);
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

            $PERS_ID = $_POST['PERS_ID'];
            $PERS_NAME = validateAlfanumeric('perspectiva',validateParameter('Perspectiva', trim($_POST['PERS_NAME']),STRING),'Alfa');
            $PERS_ORDEN = $_POST['PERS_ORDEN'] ?? NULL;
            $PERS_ME_ID = $_POST['PERS_ME_ID'] ?? NULL;
            
            //* Verificar si el id es el mismo que permita el registro del mismo dato

            $update = $this->modelPers->update($PERS_ID,$PERS_NAME,$PERS_ORDEN,$PERS_ME_ID);
            if($update){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Datos actualizados exitosamente');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al actualizar los datos');
            }

        }
        
        public function delete($PERS_ID){
            $valida = $this->modelPers->verificarDeletePerspectiva_det($PERS_ID);
            if($valida)
                $this->modelPers->delete_det_me($PERS_ID);
            
            $delete = $this->modelPers->delete($PERS_ID);
            if($delete){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Registro eliminado con éxito');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al eliminar registro');
            }
        }
    }