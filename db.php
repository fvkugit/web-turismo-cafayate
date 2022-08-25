<?php 

class DBController{
    protected $username = 'root';
    protected $password = '123';
    protected $server = 'localhost';
    protected $db = 'cafayate';

    public $conexion = null;

    public function __construct(){
        $this->conexion = mysqli_connect($this->server,$this->username,$this->password,$this->db);
        if ($this->conexion->connect_error){
            echo "Hay problemas con la conexión a la base de datos.";
        }
    }

    public function usuarioExiste($email){
        $res = mysqli_query($this->conexion, "SELECT * FROM usuarios WHERE correo LIKE '$email'");
        return $res;
    }

    public function nuevoUsuario($name,$lastname,$tel,$email,$pass,$dni){
        $id_rol = 1;
        if ($this->usuarioExiste($email)){
            return array(false, "El correo ya se encuentra registrado.");
        }
        mysqli_query($this->conexion, "INSERT INTO usuarios(nombre, apellido, telefono, correo, password, dni, id_rol) VALUES('$name', '$lastname', '$tel', '$email', md5('$pass'), '$dni', '$id_rol')")
        or die($this->conexion);
    }
}
$db = new DBController();

?>