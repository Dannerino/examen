<?php
require_once('modelo/Singleton.php');
require_once('modelo/Conexion.php');
require_once('modelo/Config.php');
require_once('modelo/Medoo.php');
error_reporting(E_ALL & ~E_DEPRECATED); // deshabilita la salida de errores deprecated
// librería nusoap
require_once('lib/nusoap.php');

function duplicateName($nombre, $id = null)
    {
        $database = medoo::getInstance();
        $database->openConnection(unserialize(MYSQL_CONFIG));
        $datos = ($database->count('viajes', ["AND" => ['nombre' => $nombre, 'id[!]' => $id]]) > 0) ? true : false;
        $database->closeConnection();
        return $datos;
    }

//instanciamos un nuevo servidor soap 
$server = new soap_server;

//Namespace 
$ns = '';

//asignamos el nombre y namespace al servicio 
$server->configureWSDL("", $ns);
      
//registramos la función 
$server->register('duplicateName', array('nombre' => 'xsd:string'), //tipo de dato recibido
        array('return' => 'xsd:boolean'), //tipo de dato a enviar
        $ns, false, 'rpc', //tipo documento 
        'literal', //tipo codificación 
        'Documentacion de duplicateName'); //documentación


//Establecer servicio 
$server->service(file_get_contents("php://input"));