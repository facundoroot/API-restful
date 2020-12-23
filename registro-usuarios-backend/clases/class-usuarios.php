<?php 

    // la clase db esta required en usuarios.php
    class Usuario 
    {
        private $nombre;
        private $apellido;
        private $fechaNacimiento;
        private $pais;
        private $db;


        public function __construct($nombre,$apellido,$fechaNacimiento,$pais){

            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->fechaNacimiento = $fechaNacimiento;
            $this->pais = $pais;
        }

        public function getNombre(){
            return $this->nombre;
        }
        public function getApellido(){
            return $this->apellido;
        }
        public function getFechaNacimiento(){
            return $this->fechaNacimiento;
        }
        public function getPais(){
            return $this->pais;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
        }
        public function setApellido($apellido){
            $this->apellido = $apellido;
        }
            public function setFechaNacimiento($fechaNacimiento){
            $this->fechaNacimiento = $fechaNacimiento;
        }
        public function setPais($pais){
            $this->pais = $pais;
        }

        public function __toString(){
            return $this->nombre." ".$this->apellido;
        }

        // CRUD
        
        public function guardarUsuario(){
            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            // convierto en array asociativo
            $usuarios = json_decode($contenidoArchivo,true);
            // ahora agrego el indice 3 que contiene esto(3 ya que es el ultimo + 1 tengo 3 elementos json 0 1 2)
            $usuarios[]= array(
                "nombre" => $this->nombre,
                "apellido" => $this->apellido,
                "fechaNacimiento" => $this->fechaNacimiento,
                "pais" => $this->pais
            );
            // sobrescribo el archivo y entonces me quedan 4 elementos
            $archivo = fopen("../data/usuarios.json","w");
            fwrite($archivo,json_encode($usuarios));
            fclose($archivo);

        }

        public static function obtenerUsuarios(){
            // con el static puedo acceder a la funcion sin tener que crear un objeto usuario
            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            echo $contenidoArchivo;
        }

        public static function obtenerUsuario($indice){
            // con el static puedo acceder a la funcion sin tener que crear un objeto usuario
            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            $usuarios = json_decode($contenidoArchivo,true);
            // la forma que me construye el array asociativo es por ejemplo $usuarios[0]['nombre']);
            echo json_encode($usuarios[$indice]); 
        }

        public function actualizarUsuario($indice){
            // con el static puedo acceder a la funcion sin tener que crear un objeto usuario
            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            $usuarios = json_decode($contenidoArchivo,true);
            // la forma que me construye el array asociativo es por ejemplo $usuarios[0]['nombre']);

            // $usuario = $usuarios[$indice];

            // estos son los nuevos datos
            $usuario = array(
                "nombre" => $this->nombre,
                "apellido" => $this->apellido,
                "fechaNacimiento" => $this->fechaNacimiento,
                "pais" => $this->pais
            );

            // reemplazo
            $usuarios[$indice] = $usuario;

            $archivo = fopen('../data/usuarios.json','w');
            // ahora reescribo el json con el usuario actualizado
            fwrite($archivo,json_encode($usuarios));
            fclose($archivo);

        }

        public static function eliminarUsuario($indice){

            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            $usuarios = json_decode($contenidoArchivo,true);

            // elimino
            array_splice($usuarios , $indice , 1);

            $archivo = fopen('../data/usuarios.json','w');
            // ahora reescribo el json con el usuario eliminado
            fwrite($archivo,json_encode($usuarios));
            fclose($archivo);
        }
    }