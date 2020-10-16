<?php
    class Relaciones_objetivos extends Controller{
        public function __construct(){
            $this->modelRelacion = $this->model('Relacion_objetivo');
        }

        public function add(){
            //* Validar que no se registre una relación doble vez por ejemplo Det1 -> O2 dos veces
            //? Validar que no se registre una relación de un nivel superior a uno inferior por ejemplo del 1 al 4

            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            
            $REL_OE_ID = $_POST['REL_OE_ID'] ?? NULL;
            $REL_OBJ_ID = $_POST['REL_OBJ_ID'] ?? NULL;
            $REL_DET_ID = $_POST['REL_DET_ID'] ?? NULL;

            $insert = $this->modelRelacion->add($REL_OE_ID,$REL_OBJ_ID,$REL_DET_ID);
            if($insert){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Datos registrados exitosamente');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al registrar los datos');
            }
        }
       
        public function getAll($DET_ID){
            $data = $this->modelRelacion->getAll($DET_ID);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }

        public function getOne($REL_ID){
            $data = $this->modelRelacion->getOne($REL_ID);
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

            $REL_ID = $_POST['REL_ID'];
            $REL_OE_ID = $_POST['REL_OE_ID'] ?? NULL;
            $REL_OBJ_ID = $_POST['REL_OBJ_ID'] ?? NULL;
            $REL_DET_ID = $_POST['REL_DET_ID'] ?? NULL;
            //VALIDAR LOGO

            $update = $this->modelRelacion->update($REL_ID,$REL_OE_ID,$REL_OBJ_ID,$REL_DET_ID);

            if($update){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Datos actualizados exitosamente');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al actualizar los datos');
            }
        }
        
        public function delete($REL_ID){
            $delete = $this->modelRelacion->delete($REL_ID);
            if($delete){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Registro eliminado con éxito');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al eliminar registro');
            }
        }
    }