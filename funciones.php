<?php

//Actualiza los datos de una persona en la base de datos
function actualizarPersona($nombre,$apellidos,$direccion,$correo,$telefono,$id){
    $db = obtener_conexion();
    $sentencia = $db->prepare("UPDATE people SET name = ?, lname = ?,address = ?, email = ?, phone = ? WHERE idPerson = ?");
    return $sentencia->execute();
}


//Obtiene los datos de una persona segun su id
function obtenerPersonasPorId($id){
    $db = obtener_conexion();
    $sentencia = $db->prepare("SELECT personId,name,lname,address,email,phone FROM people WHERE idPerson = ?");
    $sentencia->execute([$id]);
    return $sentencia->fetchObject();

}

//Obtiene una lista de todas las personas.
function obtenerPersona(){
    $db = obtener_conexion();
    $sentencia = $db->query("SELECT personId,name,lname,address,email,phone FROM people");

    return $sentencia->fetchAll();

}

function eliminarPersona($id){
    $db = obtener_conexion();
    $sentencia = $db->prepare("DELETE FROM people where idPerson = ?");
    return $sentencia->execute([$id]);
}

//inserta un registro a la base de datos
function guardarPersona($nombre,$apellidos,$direccion,$correo,$telefono){

    $db = obtener_conexion();
    $sentencia = $db->prepare("INSERT INTO people(name,lname,address,email,phone) VALUES(?,?,?,?,?)");
    
    return $sentencia->execute([$nombre,$apellidos,$direccion,$correo,$telefono]);
}

// obtiene las variables del entorno, y verifica si existe.
function obtenerVariableDelEntorno($key){
    
    if(defined(_ENV_CACHE)){
        $vars = _ENV_CACHE;
    }else{
        $file= "env.php";
        if(!file_exists($file)){
            throw new Exception("El archivo de las variables del entorno($file) no existe, por favor crearlo ");
        }
        $vars = parse_ini_file($file);
        define("_ENV_CACHE",$vars);
    }
    if (isset($vars[$key])) {
        return $vars[$key];
    } else {
        throw new Exception("El archivo de las variables del entorno(".$key.") no existe, en el archivo de variables del entorno");
    }
}

//trae las variables del entorno y regresa la conexion
function obtener_conexion(){
    $password = obtenerVariableDelEntorno("MYSQL_PASSWORD");
    $user=obtenerVariableDelEntorno("MYSQL_USER");
    $dbname=obtenerVariableDelEntorno("MYSQL_DATABASE_NAME");
    $database = new PDO('mysql:host=localhost;dbname='.$dbname,$user,$password);
    $database->query('set names: utf8');
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES,FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    return $database;
}
?>


