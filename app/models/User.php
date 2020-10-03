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
    }