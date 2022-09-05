<?php 

$cargaUtil = json_decode(file_get_contents("php://input"));
//responde con un codigo de error 500 si no hay datos
if(!$cargaUtil){
    http_response_code(500);
    exit;
}
//extraer valores
$id=$cargaUtil->id;
$nombre=$cargaUtil->nombre;
$apellidos=$cargaUtil->apellidos;
$direccion=$cargaUtil->direccion;
$correo=$cargaUtil->correo;
$telefono=$cargaUtil->telefono;

include_once "funciones.php";

$respuesta = actualizarPersona($nombre,$apellidos,$direccion,$correo,$telefono,$id);

json_encode($respuesta);

?>

