<?php
    class Users extends Controller{
        public function __construct(){
            $this->modelUser = $this->model('User');
        }

        public function login(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');

            $userName = $_POST['user'] ?? NULL;
            $pass = $_POST['pass'] ?? NULL;

            if(is_null($userName) || is_null($pass))
                returnResponse(INVALID_USER_PASS,'Usuario o contraseña no enviado');

            try {
                $user = $this->modelUser->login($userName);

                if(!is_object($user))
                    returnResponse(INVALID_USER_PASS,'Usuario no encontrado en la base de datos',$user);
              
                if(password_verify($pass,$user->USUA_PASSWORD)){
                    $payload = array(
                        'iat'=>time(),
                        'iss' => 'localhost',
                        'exp' => time() + (24*60*60),
                        'userId' => $user->USUA_ID,
                        'name' => $user->USUA_NOMBRE,
                        'type' => $user->USUA_TIPO_ID,
                        'companyId' => $user->USUA_EMP_ID,
                        'company' => $user->EMP_RS,
                        'logo' => $user->EMP_LOGO
                    );

                    $token = JWT::encode($payload,SECRETE_KEY);
                    if($this->modelUser->setToken($token,$user->USUA_ID)){
                        $data = array('token' => $token,'user'=>$user->USUA_NOMBRE,'type'=>$user->USUA_TIPO_ID,'company'=>$user->EMP_RS,'logo'=>$user->EMP_LOGO);
                        returnResponse(SUCCESS_RESPONSE,'Login exitoso',$data);
                    }
                    else{
                        throwError(LOGIN_FAILED,'No se pudo crear el token de acceso');
                    }
                }
                else{
                    returnResponse(INVALID_USER_PASS,'Contraseña incorrecta',[]);
                }
            } catch (\Throwable $th) {
                throwError(LOGIN_FAILED,'Se produjo un error al momento de iniciar sesión',$th->getMessage());
            }     
        }
    }