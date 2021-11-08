<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct ($email, $nombre, $token) {

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }

    public function configuracion () {
        
    }

    public function enviarConfirmacion () {

        //Instanciar objeto de PHPMailer
        $mail = new PHPMailer();

        //parametros del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = TRUE;
        $mail->Port = 2525;
        $mail->Username = '40a61d3185837e';
        $mail->Password = '0f6f82fc15c8f4';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subjet = "$this->nombre Confirma tu cuenta";

        //habilitar el uso de HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
         
        //Contenido
        $contenido = "<html>";
        $contenido .= "<p>Hola<strong>" . $this->nombre. ":</strong></p>";
        $contenido .= "<p>Has creado tu cuenta en AppSalon.com";
        $contenido .= ", solo deber confirmarla presionando en el siguiente enlace: </p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tú no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        
        //envioar el email
        $mail->send();

        return $contenido;
    }


    public function enviarInstrucciones () {

        //Instanciar objeto de PHPMailer
        $mail = new PHPMailer();

        //parametros del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = TRUE;
        $mail->Port = 2525;
        $mail->Username = '40a61d3185837e';
        $mail->Password = '0f6f82fc15c8f4';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subjet = "$this->nombre Confirma tu cuenta";

        //habilitar el uso de HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
         
        //Contenido
        $contenido = "<html>";
        $contenido .= "<p>Hola<strong>" . $this->nombre . ":</strong></p>";
        $contenido .= "<p>Has solicitado recuperar tu password para tu cuenta asociada a la dirección de correo ";
        $contenido .= "<strong>" . $this->email . "</strong> en AppSalon.com";
        $contenido .= ", podrás recuperarla presionando en el siguiente enlace: </p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar-password?token=" . $this->token . "'><strong>Recuperar Password</strong></a></p>";
        $contenido .= "<p>Si tú no solicitaste estos cambios, puedes ignorar este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        
        //envioar el email
        $mail->send();

        return $contenido;
    }

}



?>