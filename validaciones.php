
<?php
function validarEmail($email){
    $error = "";
    if ($email == ""){
        $error .= "El campo del correo no puede estar vacio.</br>";
    }
    $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
    if (!preg_match ($pattern, $email) ){  
        $error .= "El correo es invalido.</br>";  
    }
    return $error;  
}

# Esta función, toma un valor junto a un minimo y un maximo.
# Comprueba que la longitud del string este dentro del minimo y el máximo.
# Ademas, solo permite que el string tenga letras y no numeros.
# Es utilizada para validar nombre y apellido en los formularios, como otros datos.
function validarString($string, $min, $max){
    $pattern = "/^[a-zA-z]*$/";
    $error = "";
    if ($string == ""){
        $error .= "El campo no puede estar vacio.</br>";
    }else{
        
        if (strlen($string) < $min) {$error .= "El campo no puede tener menos de {$min} caracteres.</br>";}
        elseif (strlen($string) > $max) {$error .= "El campo no puede tener mas de {$max} caracteres.</br>";}
    }
    if (!preg_match ($pattern, $string) ){  
        $error .= "El campo tiene caracteres invalidos.</br>";  
    }
    return $error;
}

function validarNumerico($val, $min, $max){
    $pattern = "/^[0-9]*$/";
    $error = "";
    if ($val == ""){
        $error .= "El campo no puede estar vacio.</br>";
    }else{
        
        if (strlen($val) < $min) {$error .= "El campo no puede tener menos de {$min} caracteres.</br>";}
        elseif (strlen($val) > $max) {$error .= "El campo no puede tener mas de {$max} caracteres.</br>";}
    }
    if (!preg_match ($pattern, $val) ){  
        $error .= "El campo tiene caracteres invalidos.</br>";  
    }
    return $error; 
}

function validarPassword($val, $min, $max){
    $pattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]*$/";
    $error = "";
    if ($val == ""){
        $error .= "La contraseña no puede estar vacia.</br>";
    }else{
        if (strlen($val) < $min) {$error .= "La contraseña no puede tener menos de {$min} caracteres.</br>";}
        elseif (strlen($val) > $max) {$error .= "La contraseña no puede tener mas de {$max} caracteres.</br>";}
    }
    if (!preg_match ($pattern, $val) ){  
        $error .= "La contraseña no cumple los requisitos, debe incluir 1 número.</br>";  
    }
    return $error; 
}

function validarCampo($value, $type){
    $res = "";
    if ($type == "email"){
        $res = validarEmail($value);
        return $res;
    }
    if ($type == "name"){
        $res = validarString($value, 3, 20);
        return $res;
    }
    if ($type == "lastname"){
        $res = validarString($value, 3, 30);
        return $res;
    }
    if ($type == "tel"){
        $res = validarNumerico($value, 7, 20);
        return $res;
    }
    if ($type == "dni"){
        $res = validarNumerico($value, 7, 9);
        return $res;
    }
    if ($type == "pass"){
        $res = validarPassword($value, 6, 20);
        return $res;
    }
}
?>