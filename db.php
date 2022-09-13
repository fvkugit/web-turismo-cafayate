<?php 
// Este archivo queda sin uso, se elimina en proximos commits.

# Los return de las funciones publicas se hacen en array
# El indice 0 es el exito de la accion (bool) 
# El indice 1 es el mensaje de respuesta (string) o el resultado de la query (mysqli object)


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

    public function query($query){
        $res = mysqli_query($this->conexion, $query)
        or die($this->conexion->connect_error);
        return $res;
    }

    protected function usuarioExiste($email){
        $res = mysqli_query($this->conexion, "SELECT * FROM usuarios WHERE correo LIKE '$email'");
        return ($res->num_rows !== 0);
    }
    protected function usuarioIdExiste($id){
        $res = mysqli_query($this->conexion, "SELECT * FROM usuarios WHERE id_usuario LIKE '$id'");
        return ($res->num_rows !== 0);
    }
    protected function usuarioEmailRows($email, $id){
        $res = mysqli_query($this->conexion, "SELECT * FROM usuarios WHERE correo LIKE '$email' AND id_usuario <> '$id'");
        return ($res->num_rows);
    }

    protected function validarUsuario($email, $pass){
        $res = $this->query("SELECT * FROM usuarios WHERE correo = '$email' AND password = md5('$pass')");
        return ($res);
    }

    public function nuevoUsuario($name,$lastname,$tel,$email,$pass,$dni){
        $id_rol = 1;
        if ($this->usuarioExiste($email)){
            return array(false, "El correo ya se encuentra registrado.");
        }
        $res = $this->query("INSERT INTO usuarios(nombre, apellido, telefono, correo, password, dni, id_rol) VALUES('$name', '$lastname', '$tel', '$email', md5('$pass'), '$dni', '$id_rol')");
        return array($res, "Su cuenta ha sido creada con exito.");
    }

    public function nuevaSolicitud($id, $nombre, $rubro, $domicilio, $telefono){
        $res = $this->query("INSERT INTO solicitudes_comerciante(id_usuario, fecha, nombre, rubro, domicilio, telefono) VALUES ('$id', current_date(), '$nombre', '$rubro', '$domicilio', '$telefono')");
        return array($res, "Su solicitud ha sido creada con exito.");
    }

    public function actualizarUsuario($id, $name, $lastname, $tel, $email, $dni){
        if ($this->usuarioEmailRows($email, $id) > 0){
            return array(false, "El correo ya esta en uso.");
        }
        $res = $this->query("UPDATE usuarios SET nombre='$name', apellido='$lastname', telefono='$tel', correo='$email', dni='$dni' WHERE id_usuario='$id'");
        return array(true, "Sus datos han sido actualizado con exito.");
    }

    public function ingresarUsuario($email, $pass){
        if (!($this->usuarioExiste($email))){
            return array(false, "El correo no se encuentra registrado.");
        }
        $res = $this->validarUsuario($email, $pass);
        $row = mysqli_fetch_assoc($res);
        if (is_array($row) && !empty($row)){
            return array(true, $row);
        }
        return array(false, "Los datos de inicio no son correctos.");
    }

    public function datosUsuario($id){
        if (!($this->usuarioIdExiste($id))){
            return array(false, "El usuario no existe.");
        }
        $res = $this->query("SELECT u.nombre, u.apellido, u.telefono, u.correo, u.dni, c.id_comercio, sc.id_solicitud, r.nombre as rol FROM usuarios u LEFT JOIN solicitudes_comerciante sc USING (id_usuario) LEFT JOIN comercios c USING (id_usuario) LEFT JOIN roles r USING (id_rol) WHERE id_usuario = '$id'");
        $row = mysqli_fetch_assoc($res);
        if (is_array($row) && !empty($row)){
            return array(true, $row);
        }
        return array(false, "Los datos no son correctos.");
    }
}


?>