<?php
    class Empresas extends Controller{
        public function __construct(){
            $this->modelEmpresa = $this->model('Empresa');
        }

        public function add(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            
            $emp_rs = validateAlfanumeric('Razon social',validateParameter('Razon social', trim($_POST['EMP_RS']),STRING),'Alfanumeric');
            $emp_ruc = validateRuc(trim($_POST['EMP_RUC']));
            $emp_logo = $_POST['EMP_LOGO'] ?? NULL;
            //FALTA VALIDAR IMAGEN
            $existe_ruc = $this->modelEmpresa->validateRuc($emp_ruc);
            $existe_rs = $this->modelEmpresa->validateRS($emp_rs);

            if($existe_rs) throwError(DESC_IS_INVALID,'La empresa '.$emp_rs.' ya ha sido registrada'); 
            if($existe_ruc) throwError(DESC_IS_INVALID,'Existe un registro con el ruc '.$emp_ruc);

            $insert = $this->modelEmpresa->add($emp_rs,$emp_ruc,$emp_logo);
            if($insert){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'La empresa '.$emp_rs.' fue registrada con éxito');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al insertar los datos');
            }
        }

        public function getAllEmpresas(){
            $data = $this->modelEmpresa->getAllEmpresas();
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }

        public function getEmpresa($EMP_ID){
            $data = $this->modelEmpresa->getEmpresa($EMP_ID);
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

            $emp_id = $_POST['EMP_ID'];
            $emp_rs = validateAlfanumeric('Razon social',validateParameter('Razon social', trim($_POST['EMP_RS']),STRING),'Alfanumeric');
            $emp_ruc = validateRuc(trim($_POST['EMP_RUC']));
            $emp_logo = $_POST['EMP_LOGO'] ?? NULL;
            //VALIDAR LOGO

            $update = $this->modelEmpresa->update($emp_id,$emp_rs,$emp_ruc,$emp_logo);
            if($update){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Datos actualizados exitosamente');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al actualizar los datos');
            }
        }

        public function delete($EMP_ID){
            $delete = $this->modelEmpresa->delete($EMP_ID);
            if($delete){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Registro eliminado con éxito');
            }else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al eliminar registro');
            }
        }
    }