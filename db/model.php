<?php
include_once("./utils/nodirecto.php");
class DBConexion{
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
        $suc = true;
        $res = mysqli_query($this->conexion, $query) or ($this->conexion->error);
        if ($res === false) { 
            $suc = false; 
            $res = $this->conexion->error;
        }
        return ([$suc, $res]);
    }
}


class DBModelo{
    public function __construct($table, $db){
        $this->table = $table;
        $this->db = $db;
    }

    protected function formatInsert($data){
        $fields = array();
        $values = array();
        foreach ($data as $key => $value) {
            array_push($fields, $key);
            array_push($values, $value);
        }
        return ("INSERT INTO {$this->table}" . "(" . implode(", ", $fields) . ")" . " VALUES(" . implode(", ", $values) . ")");
    }

    protected function formatWhere($data){
        $i = 1;
        $where = '';
        foreach ($data as $key => $value) {
            $where .= ($key . " LIKE " . $value);
            if($i < count($data)){
                $where .= " AND ";
            }
            $i++;
        }
        return $where;
    }

    protected function formatUpdate($data){
        $i = 1;
        $upd = '';
        foreach ($data as $key => $value) {
            $upd .= ($key . " = " . $value);
            if($i < count($data)){
                $upd .= ", ";
            }
            $i++;
        }
        return $upd;
    }

    public function crear($data){
        // Sin validaciones
        $query = $this->formatInsert($data);
        $res = $this->db->query($query);
        if ($res[0] === false) { return $res; }
        return array($res[0], "Consulta realizada con exito.");
    }
    public function eliminar($where){
        $where = $this->formatWhere($where);
        $query = ("DELETE FROM " . $this->table . " WHERE " . $where);
        $res = $this->db->query($query);
        if ($res[0] === false) { return $res; }
        return array($res[0], "Consulta realizada con exito.");
    }
    public function actualizar($newdata, $where){
        $query = ("UPDATE {$this->table} SET " . ($this->formatUpdate($newdata)) . " WHERE " . ($this->formatWhere($where)));
        $res = $this->db->query($query);
        return ([true, $res[1]]);
    }
    public function obtener($valorBusqueda){
        $where = $this->formatWhere($valorBusqueda);
        $query = ("SELECT * FROM " . $this->table . " WHERE " . $where);
        $res = $this->db->query($query);
        return ($res[1]);
    }
    public function obtenerTodo(){
        $query = ("SELECT * FROM " . $this->table);
        $res = $this->db->query($query);
        return ($res[1]);
    }
    public function obtenerUno($valorBusqueda){
        $where = $this->formatWhere($valorBusqueda);
        $query = ("SELECT * FROM " . $this->table . " WHERE " . $where);
        $res = $this->db->query($query);
        $row = mysqli_fetch_assoc($res[1]);
        if (is_array($row) && !empty($row)){
            return array(true, $row);
        }
        return array(false, "Error en consulta.");
    }
    public function existe($valorBusqueda){
        $where = $this->formatWhere($valorBusqueda);
        $query = ("SELECT * FROM " . $this->table . " WHERE " . $where);
        $res = $this->db->query($query);
        return (mysqli_num_rows($res[1]));
    }
}

class Usuarios extends DBModelo{
    public function crear($data){
        // Validaciones
        $correoRegistrado = ($this->existe(["correo"=>"{$data["correo"]}"]));
        if ($correoRegistrado > 0){
            return ([false, "El correo ya se encuentra registrado."]);
        }
        //super
        return parent::crear($data);
    }
    public function login($data){
        $cuenta = $this->obtenerUno(["correo"=>$data["correo"]]);
        
        if ($cuenta[0] === false){
            return ([false, "La cuenta no existe."]);
        }

        if (!password_verify($data["password"], $cuenta[1]["password"])){
            return ([false, "Contraseña incorrecta."]);
        }

        return ([true, $cuenta[1]]);
    }
    public function obtenerUno($valorBusqueda){
        $where = $this->formatWhere($valorBusqueda);
        $query = ("SELECT u.*, r.nombre as 'rol', sc.id_solicitud FROM " . $this->table . " u JOIN roles r USING(id_rol) LEFT JOIN solicitudes_comerciante sc USING(id_usuario)" . " WHERE " . $where);
        $res = $this->db->query($query);
        $row = mysqli_fetch_assoc($res[1]);
        if (is_array($row) && !empty($row)){
            return array(true, $row);
        }
        return array(false, "Error en consulta.");
    }
    public function obtenerTodo(){
        $query = ("SELECT u.*, r.nombre as 'rol' FROM " . $this->table . " u JOIN roles r USING(id_rol)");
        $res = $this->db->query($query);
        return ($res[1]);
    }
}

class Novedades extends DBModelo{
    public function obtenerTodo(){
        $query = ("SELECT sc.*, nc.descripcion as cat FROM " . $this->table . " sc LEFT JOIN novedades_categorias nc USING(id_categoria)");
        $res = $this->db->query($query);
        return ($res[1]);
    }
    protected function formatWhere($data){
        $i = 1;
        $where = '';
        foreach ($data as $key => $value) {
            $where .= ($key . " LIKE CONCAT ('%'," . $value . ", '%')");
            if($i < count($data)){
                $where .= " AND ";
            }
            $i++;
        }
        return $where;
    }
    public function obtener($valorBusqueda){
        $where = $this->formatWhere($valorBusqueda);
        $query = ("SELECT * FROM " . $this->table . " WHERE " . $where);
        $res = $this->db->query($query);
        return ($res[1]);
    }
}

class Solicitudes extends DBModelo{
    public function obtenerTodo(){
        $query = ("SELECT sc.*, CONCAT(u.nombre, ' ', u.apellido) as propietario FROM " . $this->table . " sc LEFT JOIN usuarios u USING(id_usuario)");
        $res = $this->db->query($query);
        return ($res[1]);
    }
}

class DPublica extends DBModelo{
    public function obtenerUno($valorBusqueda){
        $query = ("SELECT * FROM " . $this->table);
        $res = $this->db->query($query);
        $row = mysqli_fetch_assoc($res[1]);
        if (is_array($row) && !empty($row)){
            return array(true, $row);
        }
        return array(false, "Error en consulta.");
    }
}

class Comercios extends DBModelo{
    public function crear($data){
        $com = $this->obtenerUno(["id_usuario"=>$data["id_usuario"]]);
        if($com[0] && $com[1]["id_comercio"]){
            $data["id_comercio"] = $com[1]["id_comercio"];
        }
        $update =  $this->formatUpdate($data);
        $insert = $this->formatInsert($data);
        $query = ($insert . " ON DUPLICATE KEY UPDATE " . $update);
        $res = $this->db->query($query);
        if ($res[0] === false) { return $res; }
        return array($res[0], "Consulta realizada con exito.");
    }
    public function obtenerTodo(){
        $query = ("SELECT sc.*, ci.url, CONCAT(u.nombre, ' ', u.apellido) as propietario FROM " . $this->table . " sc LEFT JOIN usuarios u USING(id_usuario) LEFT JOIN (SELECT * FROM comercios_imagenes GROUP BY id_comercio) ci USING(id_comercio);");
        $res = $this->db->query($query);
        return ($res[1]);
    }
}

class Comercios_Imagenes extends DBModelo{
    
}


?>
