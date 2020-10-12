<?php
    class Procesos extends Controller{
        public function __construct(){
            $this->modelProcesos = $this->model('ModelProcesos');
        }
        public function addProceso(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $descripcion=validateAlfaNumeric('descripcion',validateParameter('descripcion',trim($_POST['descripcion']),STRING),'Alfa');
            $idEmpresa=validateParameter('idEmpresa',(int)$_POST['idEmpresa'],INTEGER);
            $isRegisty=$this->modelProcesos->validateRepetido($descripcion,$idEmpresa);
            if($isRegisty){
                throwError(DESC_IS_INVALID,'El proceso '.$descripcion.' ya ha sido registrado');
            }
            $registyOk = $this->modelProcesos->agregarProceso($descripcion,$idEmpresa);
            if($registyOk){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Proceso registrado con éxito');
            }
            else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al insertar los datos');
            }
        }
        public function getProceso($idProceso)
        {
            if($_SERVER['REQUEST_METHOD']!=='GET')
            throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');  
            $data = $this->modelProcesos->obtenerUnProceso($idProceso);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existe el registro');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvo el registro exitosamente',$data);
            }
        }
        public function getAllProcesos($idEmpresa){
            if($_SERVER['REQUEST_METHOD']!=='GET')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');   
            $data=$this->modelProcesos->mostrarTodosProcesos($idEmpresa);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }
        public function updateProceso(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $descripcion=validateAlfaNumeric('descripcion',validateParameter('descripcion',trim($_POST['descripcion']),STRING),'Alfa');
            $idProceso=validateParameter('idProceso',(int)$_POST['idProceso'],INTEGER);
            $idEmpresa=validateParameter('idEmpresa',(int)$_POST['idEmpresa'],INTEGER);
            $isRegisty=$this->modelProcesos->validateRepetido($descripcion,$idEmpresa);
            if($isRegisty){
                throwError(DESC_IS_INVALID,'El proceso '.$descripcion.' ya existe');
            }
            $registyOk = $this->modelProcesos->actualizarProceso($idProceso,$descripcion);
            if($registyOk){
                returnResponse(REGISTY_UPDATE_SUCCESSFULLY,'Proceso actualizado con éxito');
            }
            else{
                throwError(UPDATED_DATA_NOT_COMPLETE,'Se produjo un error al actualizar los datos');
            }
        }
        public function deleteProceso($idProceso){   
            if($_SERVER['REQUEST_METHOD']!=='GET')
            throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $registyOk = $this->modelProcesos->eliminarProceso($idProceso);
            if($registyOk){
                returnResponse(REGISTY_DELETE_SUCCESSFULLY,'El proceso fue eliminado con éxito');
            }
            else{
                throwError(DELETED_DATA_NOT_COMPLETE,'Se produjo un error al eliminar los datos');
            }
        }
    }
