<?php
    function validate_upload_file($tmp,$ruta,$nombre,$format)
    {
        $path = dirname(RUTA_APP).$ruta;
        $file = $path.basename($tmp['name']);
        $type = strtolower(pathinfo($file,PATHINFO_EXTENSION));
        $size = $tmp['size'];
        if($size>500000){
            throwError(SIZE_FILE_NOT_VALID,'El archivo debe pesar menos de 500kb');
        }
        switch ($format) {
            case 'IMAGE':
                $dataOfImage = getimagesize($tmp['tmp_name']);
                if(!$dataOfImage){
                    throwError(CONTENT_TYPE_NOT_VALID,'El archivo debe ser una imagen');
                }
                if($type != 'jpg' && $type != 'jpeg' && $type != 'png' && $type != 'svg' && $type != 'webp' && $type != 'bmp'){
                    throwError(EXTENSION_FILE_NOT_VALID,'La imagen debe estar en formato .jpg, .jpeg, .png, .svg, .webp o .bmp');
                }
                break;
            case 'DOC':
                if($type != 'doc' && $type != 'docx'){
                    throwError(EXTENSION_FILE_NOT_VALID,'El archivo debe estar en formato .doc o .docx');
                }
                break;
            case 'PDF':
                if($type != 'pdf'){
                    throwError(EXTENSION_FILE_NOT_VALID,'El archivo debe estar en formato .pdf');
                }
            break;
        }
        
        $file = $path.$nombre.'.'.$type;
        if(!move_uploaded_file($tmp['tmp_name'],$file)){
            throwError(FILE_UPLOAD_NOT_COMPLETE,'No se pudo subir la imagen');
        }
        return $nombre.'.'.$type; 
    }

    function throwError($code,$message)
    {
        header("content-type: application/json");
        $errorMsg = json_encode(array('status' => $code,'response' => array('message'=>$message)));
        echo $errorMsg;exit;
    }

    function returnResponse($code,$message,$data=null)
    {
        header("content-type: application/json");
        $errorMsg = json_encode(array('status' => $code,'response' => array('message'=>$message,'data'=>$data)));
        echo $errorMsg;exit;
    }

    function validateParameter($fieldName,$value, $dataType,$required = true)
    {
        if ($required && empty($value)) {
            throwError(VALIDATE_PARAMETER_REQUIRED,'El campo '.$fieldName . ' es requerido.');
        }
        switch ($dataType) {
            case BOOLEAN:
                if(!is_bool($value)){
                    throwError(VALIDATE_PARAMETER_DATATYPE,'El tipo de dato no es válido para ' . $fieldName . '. Debería ser boolean.');
                }
                break;
            case INTEGER:
                if(!is_int($value)){
                    throwError(VALIDATE_PARAMETER_DATATYPE,'El tipo de dato no es válido para ' . $fieldName . '. Debería ser int.');
                }
                break;
            case DOUBLE:
                if(!is_double($value)){
                    throwError(VALIDATE_PARAMETER_DATATYPE,'El tipo de dato no es válido para ' . $fieldName . '. Debería ser double.');
                }
                break;
            case NUMERIC:
                if(!is_numeric($value)){
                    throwError(VALIDATE_PARAMETER_DATATYPE,'El tipo de dato no es válido para ' . $fieldName . '. Debería ser un número.');
                }
                break;
            case STRING:
                if(!is_string($value)){
                    throwError(VALIDATE_PARAMETER_DATATYPE,'El tipo de dato no es válido para ' . $fieldName . '. Debería ser string.');
                }
                break;
            case ARREGLO:
                if(!is_array($value)){
                    throwError(VALIDATE_PARAMETER_DATATYPE,'El tipo de dato no es válido para ' . $fieldName . '. Debería ser un array.');
                }
                break;
            case OBJECT:
                if(!is_object($value)){
                    throwError(VALIDATE_PARAMETER_DATATYPE,'El tipo de dato no es válido para ' . $fieldName . '. Debería ser un objeto.');
                }
                break;
            case FILE:
                if(!is_file($value['tmp_name'])){
                    throwError(VALIDATE_PARAMETER_DATATYPE,'El tipo de dato no es válido para ' . $fieldName . '. Debería ser un archivo.');
                }
                break;
            default:
                throwError(VALIDATE_PARAMETER_DATATYPE,'El tipo de dato no es válido para ' . $fieldName);
                break;
        }
        return $value;
    }

    function validateRuc($ruc){
        if(strlen((string) $ruc)!=11){
            throwError(RUC_IS_INVALID,'El ruc '.$ruc.' debe tener 11 dígitos');
        }
        return $ruc;
    }

    function validateEmail($email){
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            throwError(EMAIL_IS_INVALID,'El email '.$email.' no es válido');
        }
        return $email;
    }

    function validatePhone($phone){
        $numbersOfPhone = strlen((string) $phone);
        if($numbersOfPhone!=6 && $numbersOfPhone!=9){
            throwError(PHONE_IS_INVALID,'El telefono '.$phone.' debe tener 6 o 9 dígitos');
        }
        return $phone;
    }

    function validateAlfaNumeric($field,$value,$type){
        $regex = '';
        switch ($type) {
            case 'Alfanumeric':
                $regex = '/^[a-zA-Z0-9]+(\.?\s?[a-zA-Z0-9]*)*/';
                break;
            case 'Alfa':
                $regex = '/^[a-zA-Z]+(\.?\s?[a-zA-Z]*)*/';
                break;
            default:
                # code...
                break;
        }
        if(!preg_match($regex,$value)){
            throwError(PARAMETER_IS_INVALID,'El campo '.$field.' no es válido');
        }
        return $value;
    }