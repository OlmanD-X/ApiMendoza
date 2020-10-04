<?php
    class Indicators extends Controller{
        public function __construct(){
            $this->modelUser = $this->model('User');
        }

        public function add(){
            header('Access-Control-Allow-Origin:*');
            header('Content-Type: application/json');

            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');

            $name = validateParameter('Indicador',$_POST['name'],STRING);
            
        }
    }