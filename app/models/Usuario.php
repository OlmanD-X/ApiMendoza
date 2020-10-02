<?php

    class Usuario{
        private $db;

        public function __construct(){
            $this->db = new Connection;
        }

        public function login($user){
            $this->db->query("SELECT idUsuario,idTipoUsuario,nameUser,pass,idEmpresa FROM Usuarios WHERE nameUser=:username;");
            $this->db->bind(':username',$user);
            return $this->db->getRegisty();
        }
    }