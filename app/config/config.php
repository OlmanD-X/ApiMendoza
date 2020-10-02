<?php

    define('NOMBRE_SITIO','Vensoft');
    define('RUTA_APP',dirname(dirname(__FILE__)));
    define("WEB_DEVELOPMENT", true);

    define('DB_HOST','localhost');
    define('DB_USER',"");
    define('DB_PASSWORD',"");
    define('DB_NAME','BSC');
    define('RUTA_URL','http://localhost/apiMendoza');

    // Error Codes
    define('VALIDATE_PARAMETER_REQUIRED', 	100);
    define('VALIDATE_PARAMETER_DATATYPE', 	101);
    define('PARAMETER_IS_INVALID',          102);
    define('CONTENT_TYPE_NOT_VALID',        103);
    define('SIZE_FILE_NOT_VALID',           104);
    define('EXTENSION_FILE_NOT_VALID',      105);
    define('FILE_IS_NULL',                  106);
    define('RUC_IS_INVALID',                107);
    define('EMAIL_IS_INVALID',              108);
    define('PHONE_IS_INVALID',              109);
    define('UNIT_IS_INVALID',               110);
    define('DESC_IS_INVALID',               111);

    //Server Errors
    define('FILE_UPLOAD_NOT_COMPLETE',      300);
    define('INSERTED_DATA_NOT_COMPLETE',    301);
    define('UPDATED_DATA_NOT_COMPLETE',     302);
    define('DELETED_DATA_NOT_COMPLETE',     303);
    define('GET_DATA_NOT_COMPLETE',         304);

    //Success Codes
    define('REGISTY_INSERT_SUCCESSFULLY',     200);
    define('REGISTY_UPDATE_SUCCESSFULLY',     201);
    define('REGISTY_DELETE_SUCCESSFULLY',     202);
    define('GET_REGISTIES_SUCCESSFULLY',      203);

    /*Data Type*/
	define('BOOLEAN', 	'1');
	define('INTEGER', 	'2');
    define('STRING', 	'3');
    define('DOUBLE', 	'4');
    define('NUMERIC', 	'5');
    define('ARREGLO', 	'6');
    define('OBJECT', 	'7');
    define('FILE', 	    '8');
   