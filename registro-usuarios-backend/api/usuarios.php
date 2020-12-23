<?php
// aca se reciven todas las peticiones del usuario

// todas las respuestas de abajo tienen formato json, epro el navegador lo indica como plain text asi que indico con esto al cliente que el formato es json
header("Content-Type: application/json");

require_once '../clases/class-usuarios.php';



// dependiendo del tipo de request que me llegue ('post get put delete' o sea CRUD) las acciones que hago
switch($_SERVER['REQUEST_METHOD']){

    case 'POST':
        // file_get_contents('php//input') captura datos sin procesarlos, con json decode lo paso a array asociativo
        // me llega un json y lo transformo a un array asociativo ya que es el formato de un post, lo meto dentro de post
        $_POST = json_decode(file_get_contents('php://input'),true);

        $usuario = new Usuario($_POST['nombre'],$_POST['apellido'],$_POST['fechaNacimiento'],$_POST['pais']);
        $usuario->guardarUsuario();
        // lo guardo y le muestro la info del usuario que guarde devuelt en formato json
        $resultado['mensaje'] = "Guardar el usuario: ".json_encode($_POST);
        echo json_encode($resultado);
    break;
    case 'GET':
        // para el caso get, la informacion no se encia en formato json sino directo por la url con ?
        // ahora si viene el id retorno un usuario, si no viene, por convencion retorno todos
        if(isset($_GET['id'])){
            Usuario::obtenerUsuario($_GET['id']);
        }else{
            Usuario::obtenerUsuarios();
        }
    break;
    case 'PUT': 
        // $_PUT no existe en php pero para mantener la constancia escribo asi a la variable
        // tambien recibo el id por get para saber que usuario modificar
        $_PUT = json_decode(file_get_contents('php://input'),true);
        $usuario = new Usuario($_PUT['nombre'],$_PUT['apellido'],$_PUT['fechaNacimiento'],$_PUT['pais']);
        $usuario->actualizarUsuario($_GET['id']);


        $resultado['mensaje'] = "actualizar usuario con id = ".$_GET['id']." ".
                                "<br> informacion a actualizar: ".json_encode($_PUT);
        echo json_encode($resultado);
    break;
    case 'DELETE': 

        Usuario :: eliminarUsuario($_GET['id']);
        $resultado['mensaje'] = "Eliminar usuario con id = ".$_GET['id'];
        echo json_encode($resultado);
    break;

}

// crear

// obtener un usuario

// obtener todos los usuarios

// actualizar un usuario

// eliminar un usuario