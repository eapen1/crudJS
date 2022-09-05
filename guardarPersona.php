<?php 

$cargaUtil = json_decode(file_get_contents("php://input"));
//responde con un codigo de error 500 si no hay datos
if(!$cargaUtil){
    http_response_code(500);
    exit;
}
//extraer valores
$nombre=$cargaUtil->nombre;
$apellidos=$cargaUtil->apellidos;
$direccion=$cargaUtil->direccion;
$correo=$cargaUtil->correo;
$telefono=$cargaUtil->telefono;

include_once "funciones.php";

$respuesta = guardarPersona($nombre,$apellidos,$direccion,$correo,$telefono);

json_encode($respuesta);

?>

