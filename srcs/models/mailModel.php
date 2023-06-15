<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    require '/usr/local/lib/phpmailer/src/PHPMailer.php';
    require '/usr/local/lib/phpmailer/src/Exception.php';
    require '/usr/local/lib/phpmailer/src/SMTP.php';

    class Mail  {
        private $_mail;

        public function __construct($receiver, $username) {
            $this->_mail = new PHPMailer(true);
			$this->_mail->isSMTP();
            $this->_mail->isHTML(true);
			$this->_mail->Host = 'smtp.gmail.com';
			$this->_mail->Port = 587;
			$this->_mail->SMTPAuth = true;
			$this->_mail->Username = 'camagruproject42@gmail.com';
			$this->_mail->Password = 'hhubwabvikylwhtz';
			$this->_mail->SMTPSecure = 'tls';
			$this->_mail->setFrom('camagruproject42@gmail.com', 'Camagru');
            $this->_mail->addAddress($receiver, $username);
        }

        public function sendSignUpEmail($challengeId) {
            $this->_mail->Subject = "Verify your email";
            $this->_mail->Body =
            "
            <html>
                <head>
                    <title>Welcome to Camagru !</title>
                </head>
                <body style='
                font-family: 'Designer', sans-serif;
                font-size: 14px;
                background-color: rgb(0, 0, 0);
                '>
                    <h1>Hi there !</h1>
                    <br>
                    <p>Welcome to Camagru ! Here is the final step to validate your account.</p>
                    <br>
                    <p>You can valide your account by clicking this <a href='http://localhost:3001/verify/".$challengeId."'>LINK</a></p>
                    <br>
                    <p>Thank you for joining Camagru!</p>
                </body>
            </html>
            ";
            $this->_mail->send();
        }

        public function sendPasswordMail($challengeId) {
            $this->_mail->Subject = "Password Reset";
            $this->_mail->Body =
            "
            <html>
                <head>
                    <title>Change your password!</title>
                </head>
                <body style='
                font-family: 'Designer', sans-serif;
                font-size: 14px;
                background-color: rgb(0, 0, 0);
                '>
                    <h1>Hi there !</h1>
                    <br>
                    <p>Looks like you try to change your password.</p>
                    <br>
                    <p>You can change it by clicking this <a href='http://localhost:3001/resetPassword/".$challengeId."'>LINK</a></p>
                </body>
            </html>
            ";
            $this->_mail->send();
        }
    }
