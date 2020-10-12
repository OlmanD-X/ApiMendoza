<?php
    class Indicators extends Controller{
        public function __construct(){
           // $this->modelUser = $this->model('User');
        }

        public function add(){

            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            echo 'hola';

            
        }
    }