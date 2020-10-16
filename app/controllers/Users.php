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
                        $data = array('token' => $token,'user'=>$user->USUA_NOMBRE,'type'=>$user->USUA_TIPO_ID,'company'=>$user->EMP_RS,'logo'=>$user->EMP_LOGO,'companyId'=>$user->USUA_EMP_ID);
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

        public function addUser(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $userName=validateAlfaNumeric('user',validateParameter('user',trim($_POST['user']),STRING),'Alfanumeric');
            $pass=validateAlfaNumeric('pass',validateParameter('pass',trim($_POST['pass']),STRING),'Alfanumeric');
            $passEncrypt=password_hash($pass,PASSWORD_DEFAULT);
            $idEmpresa=validateParameter('idEmpresa',(int)$_POST['idEmpresa'],INTEGER);
            $idTipoUser=validateParameter('type',(int)$_POST['type'],INTEGER);
            $isRegisty=$this->modelUser->validateRepetido($userName,$idEmpresa);
            if($isRegisty){
                throwError(DESC_IS_INVALID,'El usuario '.$userName.' ya ha sido registrado');
            }
            $registyOk = $this->modelUser->agregarUsuario($userName,$passEncrypt,$idEmpresa,$idTipoUser);
            if($registyOk){
                returnResponse(REGISTY_INSERT_SUCCESSFULLY,'Usuario registrado con éxito');
            }
            else{
                throwError(INSERTED_DATA_NOT_COMPLETE,'Se produjo un error al insertar los datos');
            }
        }

        public function getUser($idUser)
        {
            if($_SERVER['REQUEST_METHOD']!=='GET')
            throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');  
            $data = $this->modelUser->obtenerUnUsuario($idUser);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existe el registro');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvo el registro exitosamente',$data);
            }
        }

        public function getAllUsers($idEmpresa){
            if($_SERVER['REQUEST_METHOD']!=='GET')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');   
            $data=$this->modelUser->mostrarTodosUsuarios($idEmpresa);
            if(empty($data)){
                throwError(GET_DATA_NOT_COMPLETE,'No existen registros');
            }
            else{
                returnResponse(GET_REGISTIES_SUCCESSFULLY,'Se obtuvieron los registros exitosamente',$data);
            }
        }

        public function updateUser(){
            if($_SERVER['REQUEST_METHOD']!=='POST')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $idUser=validateParameter('idUser',(int)$_POST['idUser'],INTEGER);
            $userName=validateAlfaNumeric('user',validateParameter('user',trim($_POST['user']),STRING),'Alfanumeric');
            $pass=validateAlfaNumeric('pass',validateParameter('pass',trim($_POST['pass']),STRING),'Alfanumeric');
            $passEncrypt=password_hash($pass,PASSWORD_DEFAULT);
            $idEmpresa=validateParameter('idEmpresa',(int)$_POST['idEmpresa'],INTEGER);
            $idTipoUser=validateParameter('type',(int)$_POST['type'],INTEGER);
            $isRegisty=$this->modelUser->validateRepetidoActualizar($userName,$idEmpresa,$idUser);
            if($isRegisty){
                $rep=$this->modelUser->validateRepetido($userName,$idEmpresa);
                if($rep){
                    throwError(DESC_IS_INVALID,'El usuario '.$userName.' ya existe');
                }
            }
            $registyOk = $this->modelUser->actualizarUsuario($idUser,$userName,$passEncrypt,$idTipoUser);
            if($registyOk){
                returnResponse(REGISTY_UPDATE_SUCCESSFULLY,'Usuario actualizado con éxito');
            }
            else{
                throwError(UPDATED_DATA_NOT_COMPLETE,'Se produjo un error al actualizar los datos');
            }
        }

        public function deleteUser($idUser){
            if($_SERVER['REQUEST_METHOD']!=='GET')
                throwError(REQUEST_METHOD_NOT_VALID,'Método http no válido.');
            $registyOk = $this->modelUser->eliminarUsuario($idUser);
            if($registyOk){
                returnResponse(REGISTY_DELETE_SUCCESSFULLY,'El usuario fue eliminado con éxito');
            }
            else{
                throwError(DELETED_DATA_NOT_COMPLETE,'Se produjo un error al eliminar los datos');
            }
        }
    }