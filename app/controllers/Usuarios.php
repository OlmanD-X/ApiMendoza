<?php
    class Usuarios extends Controller{
        public function __construct(){
            // $this->modelUsuarios = $this->model('Usuario');
        }

        public function getUsers(){
            header('Access-Control-Allow-Origin:*');
            header('Content-Type: application/json');
            $arraycito = array('Nombre'=>'Olman','Apellido'=>'Quispe','Usuario'=>'olmanD');
            echo json_encode($arraycito);
            // $data = $this->modelUsuarios->getUsuarios();

            // if(empty($data)){
            //     throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            // }
            // else{
            //     returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            // }
        }

        public function addUser($id,$nombre){
            echo $id,$nombre;
        }
    }

//mira este cambio