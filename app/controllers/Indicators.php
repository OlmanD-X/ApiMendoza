<?php
    class Indicators extends Controller{
        public function __construct(){
           $this->modelIndicator = $this->model('Indicator');
        }

        public function add(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');

            $name = validateAlfaNumeric('Indicador',validateParameter('Indicador',$_POST['name'],STRING),'Alfa');
            $responsable = validateAlfaNumeric('Responsable',validateParameter('Responsable',$_POST['responsable'],STRING),'Alfa');
            $objetivo = validateAlfaNumeric('Objetivo',validateParameter('Objetivo',$_POST['objetivo'],STRING),'Alfa');
            $lineaBase = validateParameter('Línea Base',$_POST['lineabase'],NUMERIC);
            $meta = validateAlfaNumeric('Meta',validateParameter('Meta',$_POST['meta'],STRING),'Alfanumeric');
            $frecuencia = validateAlfaNumeric('Frecuencia',validateParameter('Frecuencia',$_POST['frecuencia'],STRING),'Alfa');
            $formula = validateFormula(validateParameter('Formula',$_POST['formula'],STRING));
            $redSymbol = $_POST['redSymbol'];
            $yellowSymbol = $_POST['yellowSymbol'];
            $greenSymbol = $_POST['greenSymbol'];
            $redValue = validateParameter('Semáforo en rojo',$_POST['redValue'],NUMERIC);
            $yellowValue = validateParameter('Semáforo en rojo',$_POST['yellowValue'],NUMERIC);
            $greenValue = validateParameter('Semáforo en rojo',$_POST['greenValue'],NUMERIC);
            $proc = $_POST['tipoProceso'];
            $id = $_POST['idProceso'];
            $variables = json_decode($_POST['variables']);
            $initiatives = json_decode($_POST['iniciativas']);

            if($proc=='proceso')
                $bool = $this->modelIndicator->getByName($name,$id);
            else
                $bool = $this->modelIndicator->getByName2($name,$id);
            if($bool)
                throwError(PARAMETER_IS_INVALID,'El indicador ya ha sido registrado');
            $response = '';
            if($proc=='proceso'){
                $response = $this->modelIndicator->add($name,$responsable,$objetivo,$lineaBase,$meta,$frecuencia,$formula,$redSymbol,$yellowSymbol,$greenSymbol,$redValue,$yellowValue,$greenValue,$id,NULL,$variables,$initiatives);
            }
            else{
                $response = $this->modelIndicator->add($name,$responsable,$objetivo,$lineaBase,$meta,$frecuencia,$formula,$redSymbol,$yellowSymbol,$greenSymbol,$redValue,$yellowValue,$greenValue,NULL,$id,$variables,$initiatives);
            }
            if($response)
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Indicador creado correctamente');
            else    
                returnResponse(INSERTED_DATA_NOT_COMPLETE,'No se pudo crear el indicador');
            
        }

        public function update()
        {
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');

            $name = validateAlfaNumeric('Indicador',validateParameter('Indicador',$_POST['name'],STRING),'Alfa');
            $responsable = validateAlfaNumeric('Responsable',validateParameter('Responsable',$_POST['responsable'],STRING),'Alfa');
            $objetivo = validateAlfaNumeric('Objetivo',validateParameter('Objetivo',$_POST['objetivo'],STRING),'Alfa');
            $lineaBase = validateParameter('Línea Base',(int)$_POST['lineabase'],NUMERIC);
            $meta = validateAlfaNumeric('Meta',validateParameter('Meta',$_POST['meta'],STRING),'Alfanumeric');
            $frecuencia = validateAlfaNumeric('Frecuencia',validateParameter('Frecuencia',$_POST['frecuencia'],STRING),'Alfa');
            $formula = validateFormula(validateParameter('Formula',$_POST['formula'],STRING));
            $redSymbol = $_POST['redSymbol'];
            $yellowSymbol = $_POST['yellowSymbol'];
            $greenSymbol = $_POST['greenSymbol'];
            $redValue = validateParameter('Semáforo en rojo',$_POST['redValue'],NUMERIC);
            $yellowValue = validateParameter('Semáforo en rojo',$_POST['yellowValue'],NUMERIC);
            $greenValue = validateParameter('Semáforo en rojo',$_POST['greenValue'],NUMERIC);
            $id = $_POST['id'];
            $variables = json_decode($_POST['variables']);
            $initiatives = json_decode($_POST['iniciativas']);
            $proc = $_POST['tipoProceso'];
            $idProc = $_POST['idProceso'];
            if($proc=='proceso')
                $bool = $this->modelIndicator->getByNameEdit($name,$idProc,$id);
            else
                $bool = $this->modelIndicator->getByName2Edit($name,$idProc,$id);
            if($bool)
                throwError(PARAMETER_IS_INVALID,'El indicador ya ha sido registrado');
            $response = $this->modelIndicator->update($name,$responsable,$objetivo,$lineaBase,$meta,$frecuencia,$formula,$redSymbol,$yellowSymbol,$greenSymbol,$redValue,$yellowValue,$greenValue,$variables,$initiatives,$id);
            if($response)
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Indicador actualizado correctamente');
            else    
                returnResponse(INSERTED_DATA_NOT_COMPLETE,'No se pudo actualizar el indicador');
        }

        public function delete($id)
        {
            $bool = $this->modelIndicator->delete($id);
            if($bool)
                returnResponse(REGISTY_DELETE_SUCCESSFULLY,'Indicador eliminado correctamente');
            else
                returnResponse(DELETED_DATA_NOT_COMPLETE,'No se pudo eliminar el indicador');
        }

        public function get($id)
        {
            $data = $this->modelIndicator->get($id);
            if($data)
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Indicador obtenido correctamente',$data);
            else
                returnResponse(GET_DATA_NOT_COMPLETE,'No se pudo obtener los registros');
        }

        public function getAll()
        {
            $data = $this->modelIndicator->getAll();
            if($data)
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Indicadores obtenido correctamente',$data);
            else
                returnResponse(GET_DATA_NOT_COMPLETE,'No se pudo obtener los registros');
        }

        public function getAllByProceso($proceso,$id)
        {
            if($proceso=='proceso')
                $data = $this->modelIndicator->getAllByProceso($id);
            else if($proceso=='subproceso')
                $data = $this->modelIndicator->getAllBySubroceso($id);
            if($data)
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Indicadores obtenido correctamente',$data);
            else
                returnResponse(GET_DATA_NOT_COMPLETE,'No se pudo obtener los registros');
        }

        public function addVariable()
        {
            $symbol = $_POST['symbol'];
            $desc = validateAlfaNumeric('Descripción',validateParameter('Descripción',$_POST['descripcion'],STRING),'Alfanumeric');
            $id = $_POST['id'];
            $bool = $this->modelIndicator->addVariable($symbol,$desc,$id);
            if($bool)
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Variable agregada correctamente');
            else
                returnResponse(INSERTED_DATA_NOT_COMPLETE,'No se pudo agregar la variable');
        }

        public function deleteVariable($id)
        {
            $bool = $this->modelIndicator->deleteVariable($id);
            if($bool)
                returnResponse(REGISTY_DELETE_SUCCESSFULLY,'Variable eliminado correctamente');
            else
                returnResponse(DELETED_DATA_NOT_COMPLETE,'No se pudo eliminar la variable');
        }

        public function updateVariable()
        {
            $symbol = $_POST['symbol'];
            $desc = validateAlfaNumeric('Descripción',validateParameter('Descripción',$_POST['descripcion'],STRING),'Alfanumeric');
            $id = $_POST['id'];
            $bool = $this->modelIndicator->updateVariable($symbol,$desc,$id);
            if($bool)
                returnResponse(REGISTY_UPDATE_SUCCESSFULLY,'Variable actualizada correctamente');
            else
                returnResponse(UPDATED_DATA_NOT_COMPLETE,'No se pudo actualizar la variable');
        }

        public function getVariable($id)
        {
            $data = $this->modelIndicator->getVariable($id);
            if($data)
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Registros obtenidos correctamente',$data);
            else
                returnResponse(GET_DATA_NOT_COMPLETE,'No se pudo obtener la variable');
        }

        public function getAllVariable()
        {
            $data = $this->modelIndicator->getAllVariable();
            if($data)
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Registros obtenidos correctamente',$data);
            else
                returnResponse(GET_DATA_NOT_COMPLETE,'No se pudo obtener laS variables');
        }

        public function getAllVariableByIndicator($id)
        {
            $data = $this->modelIndicator->getAllVariableByIndicator($id);
            if($data)
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Registros obtenidos correctamente',$data);
            else
                returnResponse(GET_DATA_NOT_COMPLETE,'No se pudo obtener laS variables');
        }

        public function addInitiative()
        {
            $desc = validateAlfaNumeric('Descripción',validateParameter('Descripción',$_POST['descripcion'],STRING),'Alfanumeric');
            $id = $_POST['id'];
            $bool = $this->modelIndicator->addInitiative($desc,$id);
            if($bool)
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Iniciativa agregada correctamente');
            else
                returnResponse(INSERTED_DATA_NOT_COMPLETE,'No se pudo agregar la iniciativa');
        }

        public function deleteInitiative($id)
        {
            $bool = $this->modelIndicator->deleteInitiative($id);
            if($bool)
                returnResponse(REGISTY_DELETE_SUCCESSFULLY,'Iniciativa eliminada correctamente');
            else
                returnResponse(DELETED_DATA_NOT_COMPLETE,'No se pudo eliminar la iniciativa');
        }

        public function updateInitiative()
        {
            $desc = validateAlfaNumeric('Descripción',validateParameter('Descripción',$_POST['descripcion'],STRING),'Alfanumeric');
            $id = $_POST['id'];
            $bool = $this->modelIndicator->updateInitiative($desc,$id);
            if($bool)
                returnResponse(REGISTY_UPDATE_SUCCESSFULLY,'Iniciativa actualizada correctamente');
            else
                returnResponse(UPDATED_DATA_NOT_COMPLETE,'No se pudo actualizar la iniciativa');
        }

        public function getInitiative($id)
        {
            $data = $this->modelIndicator->getInitiative($id);
            if($data)
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Registros obtenidos correctamente',$data);
            else
                returnResponse(GET_DATA_NOT_COMPLETE,'No se pudo obtener la iniciativa');
        }

        public function getAllInitiative()
        {
            $data = $this->modelIndicator->getAllInitiative();
            if($data)
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Registros obtenidos correctamente',$data);
            else
                returnResponse(GET_DATA_NOT_COMPLETE,'No se pudo obtener laS iniciativas');
        }

        public function getAllInitiativeByIndicator($id)
        {
            $data = $this->modelIndicator->getAllInitiativeByIndicator($id);
            if($data)
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Registros obtenidos correctamente',$data);
            else
                returnResponse(GET_DATA_NOT_COMPLETE,'No se pudo obtener laS iniciativas');
        }
    }