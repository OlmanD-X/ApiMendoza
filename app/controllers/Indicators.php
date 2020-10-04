<?php
    class Indicators extends Controller{
        public function __construct(){
            $this->modelUser = $this->model('User');
        }

        public function add(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');

            $name = validateAlfaNumeric('Indicador',validateParameter('Indicador',$_POST['name'],STRING),'Alfa');
            $responsable = validateAlfaNumeric('Responsable',validateParameter('Responsable',$_POST['responsable'],STRING),'Alfa');
            $objetivo = validateAlfaNumeric('Objetivo',validateParameter('Objetivo',$_POST['objetivo'],STRING),'Alfa');
            $lineaBase = validateAlfaNumeric('Línea Base',validateParameter('Línea Base',$_POST['lineabase'],STRING),'Alfa');
            $meta = validateAlfaNumeric('Meta',validateParameter('Meta',$_POST['meta'],STRING),'Alfanumeric');
            $frecuencia = validateAlfaNumeric('Frecuencia',validateParameter('Frecuencia',$_POST['frecuencia'],STRING),'Alfa');
            $formula = validateFormula(validateParameter('Formula',$_POST['formula'],STRING));
            // $redSymbol = 
        }
    }