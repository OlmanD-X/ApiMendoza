<?php

    define('NOMBRE_SITIO','Vensoft');
    define('RUTA_APP',dirname(dirname(__FILE__)));
    define("WEB_DEVELOPMENT", true);

    define('DB_HOST','localhost:3307');
    define('DB_USER',"root");
    define('DB_PASSWORD',"");
    define('DB_NAME','bsc');
    define('RUTA_URL','http://localhost/apiMendoza');

    /*Security*/
	define('SECRETE_KEY', 'OD$$QR**');

    // Error Codes
    define('REQUEST_METHOD_NOT_VALID',		100);
    define('VALIDATE_PARAMETER_REQUIRED', 	101);
    define('VALIDATE_PARAMETER_DATATYPE', 	102);
    define('PARAMETER_IS_INVALID',          103);
    define('CONTENT_TYPE_NOT_VALID',        104);
    define('SIZE_FILE_NOT_VALID',           105);
    define('EXTENSION_FILE_NOT_VALID',      106);
    define('FILE_IS_NULL',                  107);
    define('RUC_IS_INVALID',                108);
    define('EMAIL_IS_INVALID',              109);
    define('PHONE_IS_INVALID',              110);
    define('UNIT_IS_INVALID',               111);
    define('DESC_IS_INVALID',               112);
    define('INVALID_USER_PASS', 			113);
    define('INVALID_ACCESS_TOKEN', 			114);

    //Server Errors
    define('JWT_PROCESSING_ERROR',			300);
	define('ATHORIZATION_HEADER_NOT_FOUND',	301);
    define('ACCESS_TOKEN_ERRORS',			302);
    define('LOGIN_FAILED',                  303);
    define('CONNECTION_DATABASE_ERROR',     304);
    define('FILE_UPLOAD_NOT_COMPLETE',      305);
    define('INSERTED_DATA_NOT_COMPLETE',    306);
    define('UPDATED_DATA_NOT_COMPLETE',     307);
    define('DELETED_DATA_NOT_COMPLETE',     308);
    define('GET_DATA_NOT_COMPLETE',         309);


    //Success Codes
    define('SUCCESS_RESPONSE',                200);
    define('REGISTY_INSERT_SUCCESSFULLY',     201);
    define('REGISTY_UPDATE_SUCCESSFULLY',     202);
    define('REGISTY_DELETE_SUCCESSFULLY',     203);
    define('GET_REGISTIES_SUCCESSFULLY',      204);

    /*Data Type*/
	define('BOOLEAN', 	'1');
	define('INTEGER', 	'2');
    define('STRING', 	'3');
    define('DOUBLE', 	'4');
    define('NUMERIC', 	'5');
    define('ARREGLO', 	'6');
    define('OBJECT', 	'7');
    define('FILE', 	    '8');
   