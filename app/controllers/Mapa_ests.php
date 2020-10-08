<?php
    class Mapa_ests extends Controller{
        public function __construct(){
            $this->modelMapa = $this->model('Mapa_est');
        }

        public function add(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            
            $ME_CREATE_DATE = $_POST['ME_CREATE_DATE'];
            $ME_PROC_ID = $_POST['ME_PROC_ID'] ?? NULL;
            $ME_SUB_ID = $_POST['ME_SUB_ID'] ?? NULL;

            $insert = $this->modelMapa->add($ME_CREATE_DATE,$ME_PROC_ID,$ME_SUB_ID);
            if($insert){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Datos registrados exitosamente');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al registrar los datos');
            }
        }
       
        public function getAll(){
            $data = $this->modelMapa->getAll();
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }

        public function getOne($ME_ID){
            $data = $this->modelMapa->getOne($ME_ID);
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

            $ME_ID = $_POST['ME_ID'];
            $ME_CREATE_DATE = $_POST['ME_CREATE_DATE'];
            $ME_PROC_ID = $_POST['ME_PROC_ID'] ?? NULL;
            $ME_SUB_ID = $_POST['ME_SUB_ID'] ?? NULL;
            //VALIDAR LOGO

            $update = $this->modelMapa->update($ME_ID,$ME_CREATE_DATE,$ME_PROC_ID,$ME_SUB_ID);
            if($update){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Datos actualizados exitosamente');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al actualizar los datos');
            }
        }
        
        public function delete($ME_ID){
            $delete = $this->modelMapa->delete($ME_ID);
            if($delete){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Registro eliminado con éxito');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al eliminar registro');
            }
        }
    }