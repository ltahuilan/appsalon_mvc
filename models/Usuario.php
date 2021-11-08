<?php 

namespace Model;

class Usuario extends ActiveRecord{

    //Sobrecarga de atributos -- Base de Datos
    // protected static $db = 'appsalon_mvc';
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'password', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefon;
    public $password;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args=[]) {
        
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';

    }

    //Validar los campos del formulario para la creación de una nueva cuenta
    public function validarNuevaCuenta () {

        if (!$this->nombre) {
            // self::$alertas['error'][] = 'El nombre es obligatorio';
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if (!$this->apellido) {
            self::setAlerta('error', 'El apellido es obligatorio');
        }
        if (!$this->email) {
            self::setAlerta('error', 'El email es obligatorio');
        }
        if (!$this->telefono) {
            self::setAlerta('error', 'El telefono es obligatorio');
        }
        if (!$this->password) {
            self::setAlerta('error', 'El password es obligatorio');
        }
        if (strlen($this->password) < 6) {
            self::setAlerta('error', 'El password debe tener 6 o más caracteres');
        }        

        return self::$alertas;

    }

    //Validar datos ingresados en login
    public function validarLogin () {

        if (!$this->password && !$this->email) {
            self::setAlerta('error', 'El email y password son obligatorios...');
        }
        if (!$this->email && $this->password) {
            self::setAlerta('error', 'El email es obligatorio');
        }
        if ($this->email && !$this->password) {
            self::setAlerta('error', 'El password es obligatorio');
        }

        return self::$alertas;
    }

    public function validarEmail () {

        if (!$this->email) {
            self::setAlerta('error', 'El email es obligatorio');
        } 
        return self::$alertas;
    }

    public function validarPassword () {
        if (!$this->password) {
            self::setAlerta('error', 'El password es obligatorio');
        }
        if (strlen($this->password) < 6) {
            self::setAlerta('error', 'El password debe tener 6 o más caracteres');
        }

        return self::$alertas;
    }

    //verificar si un usario ya existe
    public function verificarUsuario () {

        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        
        $resultado = self::$db->query($query);

        // debuguear($resultado->num_rows);

        if($resultado->num_rows) {

            self::setAlerta('error', "El correo '$this->email' ya esta registrado");
        }

        return $resultado;
    }


    //Hashear password
    public function passwordHash () {

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Generar token
    public function crearToken () {

        $this->token = uniqid();
    }

    //verificar password y si usuario esta verificado
    public function verificarPasswordAndVerificado ($password) {

        /**La expresión !$this->confirmado convierte el sting a tipo bool, ver manual de PHP
         * https://www.php.net/manual/es/language.types.boolean.php
         * "un valor será convertido automáticamente si un operador, función o estructura de control
         * requiere un argumento de tipo boolean" */

        $resultado = password_verify($password, $this->password);

        if (!$resultado || !$this->confirmado) {
            self::setAlerta('error', 'Usuario no verificado o password incorrecto');
        }else {
            return TRUE;
        }
    }
}

?>
