<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {

    public static function login (Router $router) {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            //Si no hay lartas
            if (empty($alertas)) {
                //comprobar si el email existe en la DB
                $usuario = Usuario::where('email', $auth->email);
                
                if ($usuario) {

                    //verificar si password es correcto y esta verificado
                    if ($usuario->verificarPasswordAndVerificado($auth->password) ) {

                        //loguear usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = TRUE;
                        
                        if ($usuario->admin === '1') {
                            $_SESSION['1'] = $usuario->admin;
                            header('Location: /admin');
                        }else {
                            header('Location: /citas');
                        }
                    }

                } else {
                    Usuario::setAlerta('error', 'Usuario '. $auth->email.' no registrado');

                }
            }
        }
        
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/login', [
            'alertas'=>$alertas
        ]);
        
    }

    public static function logout () {
        echo 'Cerrando sesión';
    }

    public static function olvide (Router $router) {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);
            
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                //consultar la DB
                $usuario = Usuario::where('email', $auth->email);

                //Verificar que usuario exista y este confirmado
                if ($usuario && $usuario->confirmado === '1') {

                    //Generar token de un solo uso para recuperar password
                    $usuario->crearToken();

                    //Actualizar y guardar registro en la DB
                    $usuario->guardar();

                    //enviar Email
                    $mail = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $mail->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Se han enviado instruccionesa tu email');

                } else {
                    Usuario::setAlerta('error', 'Usuario NO existe o NO esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/olvide-password', [
            'alertas'=>$alertas
        ]);
    }

    public static function recuperar (Router $router) {
        $alertas = [];
        $error = FALSE;

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = TRUE;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //validar y resetear password 
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            
            if (empty($alertas)) {

                //borrar password del objeto en memoria
                $usuario->password = null;
                //asignar nuevo password
                $usuario->password = $password->password;
                //hashearpassword
                $usuario->passwordHash();
                //borrar cadena de tocken
                $usuario->token = '';
                //guardar y Actualizar
                $resultado = $usuario->guardar();

                if ($resultado) {

                    header('Location: /');
                }

            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas'=>$alertas,
            'error'=>$error
        ]);
    }

    public static function crear (Router $router) {  
        
        $usuario = new Usuario;

        //arreglo vacío para alertas
        $alertas = [];        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            //acciones a realizar si no hay alertas de error
            if (empty($alertas)) {

                //comprobar que el usuario no esta registrado
                $resultado = $usuario->verificarUsuario();

                //Si un registro coincide
                if ($resultado->num_rows) {

                    $alertas = Usuario::getAlertas();

                } else {
                    
                    //hashear password
                    $usuario->passwordHash();

                    //genera token unico
                    $usuario->crearToken();

                    //enviar email para validar token
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);                    
                    $email->enviarConfirmacion();

                    //guardar usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        // header('Location: /mensaje');

                        $router->render('auth/mensaje', ['email'=>$usuario->email]);
                    }
                    
                }

            }

        }
        
        $router->render('auth/crear-cuenta', [
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
    }


    public static function mensaje (Router $router) {

        $router->render('auth/mensaje');
    }


    public static function confirmar (Router $router) {
        $alertas = [];

        //sanitizar y leer token desde la url
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario) || $usuario->token === '') {
            //mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido...');
        }else {

            //cambiar valor de columna confirmado
            $usuario->confirmado = '1';
            //eliminar token
            $usuario->token = '';
            //Guardar y Actualizar 
            $usuario->guardar();
            //mostrar mensaje de exito
            Usuario::setAlerta('exito', 'Cuenta verificada exitosamente...');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas'=>$alertas
        ]);
    }
}
?>