<?php
    class Connection{
        private $host = DB_HOST;
        private $user = DB_USER;
        private $password = DB_PASSWORD;
        private $db_name = DB_NAME;

        private $dbh; //databse handler
        private $stmt; //statement
        private $error;

        public function __construct(){
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->db_name;
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            
            try {
                $this->dbh = new PDO($dsn,"","",$options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo 'Error:'.$this->error;
            }
        }

        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }

        public function bind($parameter,$value,$type = null){
            if(is_null($type)){
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_array($value):
                        $type = NULL;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                        break;
                }
            }
            $this->stmt->bindValue($parameter,$value,$type);
        }

        public function execute(){
            return $this->stmt->execute();
        }

        public function getRegisties(){
            $this->execute();
            $dataSet = $this->stmt->fetchAll(PDO::FETCH_OBJ);
            return $dataSet;
        }

        public function getRegisty(){
            $this->execute();
            $dataSet = $this->stmt->fetch(PDO::FETCH_OBJ);
            return $dataSet;
        }

        public function rowsCount(){
            return $this->stmt->rowCount();
        }
    }