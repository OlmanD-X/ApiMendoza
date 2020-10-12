<?php
    class Indicators extends Controller{
        public function __construct(){
           $this->modelIndicator = $this->model('Indicator');
        }

        public function add($proc,$id){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');

            $name = validateAlfaNumeric('Indicador',validateParameter('Indicador',$_POST['name'],STRING),'Alfa');
            $responsable = validateAlfaNumeric('Responsable',validateParameter('Responsable',$_POST['responsable'],STRING),'Alfa');
            $objetivo = validateAlfaNumeric('Objetivo',validateParameter('Objetivo',$_POST['objetivo'],STRING),'Alfa');
            $lineaBase = validateAlfaNumeric('Línea Base',validateParameter('Línea Base',$_POST['lineabase'],STRING),'Alfa');
            $meta = validateAlfaNumeric('Meta',validateParameter('Meta',$_POST['meta'],STRING),'Alfanumeric');
            $frecuencia = validateAlfaNumeric('Frecuencia',validateParameter('Frecuencia',$_POST['frecuencia'],STRING),'Alfa');
            $formula = validateFormula(validateParameter('Formula',$_POST['formula'],STRING));
            $redSymbol = $_POST['redSymbol'];
            $yellowSymbol = $_POST['yellowSymbol'];
            $greenSymbol = $_POST['greenSymbol'];
            $redValue = validateParameter('Semáforo en rojo',$_POST['redValue'],NUMERIC);
            $yellowValue = validateParameter('Semáforo en rojo',$_POST['yellowValue'],NUMERIC);
            $greenValue = validateParameter('Semáforo en rojo',$_POST['greenValue'],NUMERIC);
            $variables = json_decode($_POST['variables']);
            $initiatives = json_decode($_POST['iniciativas']);

            //* Comprobar si el indicador ya ha sido registrado

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
    }