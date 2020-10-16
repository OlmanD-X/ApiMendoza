<?php
    class SubProcesos extends Controller{
        public function __construct(){
            $this->modelSubProcesos = $this->model('ModelSubProcesos');
        }
        public function addSubProceso(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $descripcion=validateAlfaNumeric('descripcion',validateParameter('descripcion',trim($_POST['descripcion']),STRING),'Alfa');
            $idProceso=validateParameter('idProceso',(int)$_POST['idProceso'],INTEGER);
            $isRegisty=$this->modelSubProcesos->validateRepetido($descripcion,$idProceso);
            if($isRegisty){
                throwError(DESC_IS_INVALID,'El subproceso '.$descripcion.' ya ha sido registrado');
            }
            $registyOk = $this->modelSubProcesos->agregarSubProceso($descripcion,$idProceso);
            if($registyOk){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Subproceso registrado con éxito');
            }
            else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al insertar los datos');
            }
        }
        public function getSubProceso($idSubProceso)
        {
            if($_SERVER['REQUEST_METHOD']!=='GET')
            throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');  
            $data = $this->modelSubProcesos->obtenerUnSubProceso($idSubProceso);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existe el registro');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvo el registro exitosamente',$data);
            }
        }
        public function getAllSubProcesos($idProceso){
            if($_SERVER['REQUEST_METHOD']!=='GET')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');   
            $data=$this->modelSubProcesos->mostrarTodosSubProcesos($idProceso);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }
        public function updateSubProceso(){
           if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.'); 
            $descripcion=validateAlfaNumeric('descripcion',validateParameter('descripcion',trim($_POST['descripcion']),STRING),'Alfa');
            $idProceso=validateParameter('idProceso',(int)$_POST['idProceso'],INTEGER);
            $idSubProceso=validateParameter('idSubProceso',(int)$_POST['idSubProceso'],INTEGER);
            $isRegisty=$this->modelSubProcesos->validateRepetido($descripcion,$idProceso);
            if($isRegisty){
                throwError(DESC_IS_INVALID,'El subproceso '.$descripcion.' ya existe');
            }
            $registyOk = $this->modelSubProcesos->actualizarSubProceso($idSubProceso,$descripcion);
            if($registyOk){
                returnResponse(REGISTY_UPDATE_SUCCESSFULLY,'Subproceso actualizado con éxito');
            }
            else{
                throwError(UPDATED_DATA_NOT_COMPLETE,'Se produjo un error al actualizar los datos');
            }
        }
        public function deleteSubProceso($idSubProceso){   
            if($_SERVER['REQUEST_METHOD']!=='GET')
            throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $registyOk = $this->modelSubProcesos->eliminarSubProceso($idSubProceso);
            if($registyOk){
                returnResponse(REGISTY_DELETE_SUCCESSFULLY,'El subproceso fue eliminado con éxito');
            }
            else{
                throwError(DELETED_DATA_NOT_COMPLETE,'Se produjo un error al eliminar los datos');
            }
        }
    }
