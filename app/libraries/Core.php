<?php
    class Core{
        protected $currentController = '';
        protected $currentMethod = '';
        protected $parameters = [];

        public function __construct(){
            $url = $this->getUrl();
            if(isset($url[0])){
                if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
                    $this->currentController = ucwords($url[0]);
                    unset($url[0]);
                }
            }

            require_once '../app/controllers/'.$this->currentController.'.php';
            $this->currentController = new $this->currentController;

            if(isset($url[1])){
                if(method_exists($this->currentController,$url[1])){
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }
            $this->parameters = $url? array_values($url) : [];
            if($this->currentMethod!='login'){
                $this->validateToken();
            }
            call_user_func_array(array($this->currentController, $this->currentMethod), $this->parameters);
        }

        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'],'/');
                $url = filter_var($url,FILTER_SANITIZE_URL);
                $url = explode('/',$url);
                return $url;
            }
        }

        public function validateToken(){
            try {
                $token = getBearerToken();
                if(isset($_SESSION['token'])){
                    if($token === $_SESSION['token']){
                        $payload = JWT::decode($token,SECRETE_KEY,['HS256']);
                        $_SESSION['payload'] = $payload;
                    }
                    else{
                        returnResponse(INVALID_ACCESS_TOKEN,'Token inválido. Por favor inicie sesión.');
                    }
                }
                else{
                    returnResponse(INVALID_ACCESS_TOKEN,'No se encuentra logueado. Por favor inicie sesión.');
                }
            } catch (\Throwable $th) {
                throwError(ACCESS_TOKEN_ERRORS,$th->getMessage());
            }
        }
    }