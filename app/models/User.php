<?php

    class User{
        private $db;

        public function __construct(){
            $this->db = new Connection;
            if($this->db->error)
                throwError(CONNECTION_DATABASE_ERROR,$this->db->error);
        }

        public function login($user){
            try {
                $this->db->query("SELECT U.USUA_ID,U.USUA_PASSWORD,U.USUA_NOMBRE,U.USUA_TIPO_ID,U.USUA_EMP_ID,E.EMP_RS,E.EMP_LOGO FROM USUARIOS U INNER JOIN EMPRESAS E ON U.USUA_EMP_ID = E.EMP_ID  WHERE U.USUA_NOMBRE = :username");
                $this->db->bind(':username',$user);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
            
        }

        public function setToken($token){
            try {
                $this->db->query("UPDATE USUARIOS SET USUA_TOKEN=:token");
                $this->db->bind(':token',$token);
                return $this->db->execute();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function getToken($id){
            try {
                $this->db->query("SELECT USUA_TOKEN FROM USUARIOS WHERE USUA_ID=:id");
                $this->db->bind(':id',$id);
                return $this->db->getRegisty();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function validateRepetido($userName,$idEmpresa){
            $this->db->query("SELECT USUA_NOMBRE FROM usuarios WHERE USUA_NOMBRE=:user AND USUA_EMP_ID=:id AND USUA_ESTADO='1'");
            $this->db->bind(':user',$userName);
            $this->db->bind(':id',$idEmpresa);
            $data = $this->db->getRegisty();
            if(!empty($data->USUA_NOMBRE))
                return true;
            else
                return false; 
        }

        public function validateRepetidoActualizar($userName,$idEmpresa,$idUser){
            $this->db->query("SELECT USUA_NOMBRE FROM usuarios WHERE USUA_NOMBRE=:user AND USUA_EMP_ID=:id AND USUA_ID=:idUser AND USUA_ESTADO='1'");
            $this->db->bind(':user',$userName);
            $this->db->bind(':id',$idEmpresa);
            $this->db->bind(':idUser',$idUser);
            $data = $this->db->getRegisty();
            if(empty($data->USUA_NOMBRE))
                return true;
            else
                return false; 
        }

        public function agregarUsuario($userName,$passEncrypt,$idEmpresa,$idTipoUser){
            $this->db->query("INSERT INTO usuarios(USUA_NOMBRE,USUA_PASSWORD,USUA_TIPO_ID,USUA_EMP_ID,USUA_ESTADO) VALUES(:user,:pass,:idTipo,:idEmpresa,'1')");
            $this->db->bind(':user',$userName);
            $this->db->bind(':pass',$passEncrypt);
            $this->db->bind(':idTipo',$idTipoUser);
            $this->db->bind(':idEmpresa',$idEmpresa);
            return $this->db->execute();   
        }

        public function obtenerUnUsuario($idUser){
            $this->db->query("SELECT*FROM usuarios WHERE USUA_ID=:id AND USUA_ESTADO='1'");
            $this->db->bind(':id',$idUser);
            $data = $this->db->getRegisty();
            return $data;
        }

        public function mostrarTodosUsuarios($idEmpresa){
            $this->db->query("SELECT*FROM usuarios WHERE USUA_EMP_ID=:id AND USUA_ESTADO='1'");
            $this->db->bind(':id',$idEmpresa);
            $data = $this->db->getRegisties();
            return $data;
        }

        public function actualizarUsuario($idUser,$userName,$passEncrypt,$idTipoUser){
            $this->db->query("UPDATE usuarios SET USUA_NOMBRE=:user, USUA_PASSWORD=:pass,USUA_TIPO_ID=:idTipo WHERE USUA_ID=:idUser");
            $this->db->bind(':idUser',$idUser);
            $this->db->bind(':user',$userName);
            $this->db->bind(':pass',$passEncrypt);
            $this->db->bind(':idTipo',$idTipoUser);
            return $this->db->execute();   
        }
        
        public function eliminarUsuario($idUser){
            $this->db->query("UPDATE usuarios SET USUA_NOMBRE='0' WHERE USUA_ID=:id");
            $this->db->bind(':id',$idUser);
            return $this->db->execute();
        }
    }