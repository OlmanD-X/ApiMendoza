<?php
    class ObjetivosProceso extends Controller{
        public function __construct(){
            $this->modelObjetivosProceso = $this->model('ModelObjetivosProceso');
        }
        public function addObjetivosProceso(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $descripcion=validateAlfaNumeric('descripcion',validateParameter('descripcion',trim($_POST['descripcion']),STRING),'Alfa');
            $idProceso=validateParameter('idProceso',(int)$_POST['idProceso'],INTEGER);
            $isRegisty=$this->modelObjetivosProceso->validateRepetido($descripcion,$idProceso);
            if($isRegisty){
                throwError(DESC_IS_INVALID,'El objetivo '.$descripcion.' ya ha sido registrado');
            }
            $registyOk = $this->modelObjetivosProceso->agregarObjetivosProceso($descripcion,$idProceso);
            if($registyOk){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Objetivo registrado con éxito');
            }
            else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al insertar los datos');
            }
        }
        public function getObjetivosProceso($idObjetivo)
        {
            if($_SERVER['REQUEST_METHOD']!=='GET')
            throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');  
            $data = $this->modelObjetivosProceso->obtenerUnObjetivo($idObjetivo);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existe el registro');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvo el registro exitosamente',$data);
            }
        }
        public function getAllObjetivosProceso($idProceso){
            if($_SERVER['REQUEST_METHOD']!=='GET')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');   
            $data=$this->modelObjetivosProceso->mostrarTodosObjetivos($idProceso);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }
        public function updateObjetivosProceso(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $descripcion=validateAlfaNumeric('descripcion',validateParameter('descripcion',trim($_POST['descripcion']),STRING),'Alfa');
            $idProceso=validateParameter('idProceso',(int)$_POST['idProceso'],INTEGER);
            $idObjetivo=validateParameter('idObjetivo',(int)$_POST['idObjetivo'],INTEGER);
            $isRegisty=$this->modelObjetivosProceso->validateRepetido($descripcion,$idProceso);
            if($isRegisty){
                throwError(DESC_IS_INVALID,'El proceso '.$descripcion.' ya existe');
            }
            $registyOk = $this->modelObjetivosProceso->actualizarObjetivos($idObjetivo,$descripcion);
            if($registyOk){
                returnResponse(REGISTY_UPDATE_SUCCESSFULLY,'Objetivo actualizado con éxito');
            }
            else{
                throwError(UPDATED_DATA_NOT_COMPLETE,'Se produjo un error al actualizar los datos');
            }
        }
        public function deleteObjetivosProceso($idObjetivo){   
            $registyOk = $this->modelObjetivosProceso->eliminarObjetivos($idObjetivo);
            if($registyOk){
                returnResponse(REGISTY_DELETE_SUCCESSFULLY,'El objetivo fue eliminado con éxito');
            }
            else{
                throwError(DELETED_DATA_NOT_COMPLETE,'Se produjo un error al eliminar los datos');
            }
        }
    }
