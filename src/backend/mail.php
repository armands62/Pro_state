<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require ("../vendor/phpmailer/phpmailer/src/Exception.php");
require ("../vendor/phpmailer/phpmailer/src/PHPMailer.php");
require ("../vendor/phpmailer/phpmailer/src/SMTP.php");

class Mailer {
    private $mail;
    private $password = "";
    public $from_mail = "";
    public $from_name = "Pro State Bank";

    public $recipient_mail = "";
    public $recipient_name = "";
    public $subject = "Pro State Bank - ";
    public $content = "";

    /**
     * @throws Exception
     */
    public function __construct() {
        // A local key is necessary for this file to work
        // This is a file in the root folder which is not included in the git repository

        if(!file_exists("../local_key.php")) {
            echo('Local key not found! Connection terminated.');
            exit();
        }
        $localkey = new Localkey();
        $this->password = $localkey->get_mail_pass();
        $this->from_mail = $localkey->get_mail_address();


        $this->mail = new PHPMailer();
        $this->mail->SMTPDebug = false;
        $this->mail->IsSMTP();
        $this->mail->Mailer = "smtp";
        $this->mail->IsHTML();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Encoding = 'base64';
        
        $this->mail->SMTPDebug  = 1;  
        $this->mail->SMTPAuth   = TRUE;
        $this->mail->SMTPSecure = "tls";
        $this->mail->Port       = 587;
        $this->mail->Host       = "smtp.gmail.com";
        $this->mail->Username   = $this->from_mail;
        $this->mail->Password   = $this->password;

        $this->mail->AddEmbeddedImage("./images/logo-transparent.png", "psb-logo", "psb-logo");
    }

    /**
     * @throws Exception
     */
    public function send() {
        $this->mail->AddAddress($this->recipient_mail, $this->recipient_name);
        $this->mail->SetFrom($this->from_mail, $this->from_name);
        $this->mail->Subject = $this->subject;
        $this->mail->MsgHTML($this->content);
        $this->mail->Send();
    }
    public function set_recipient($mail, $name) {
        $this->recipient_mail = $mail;
        $this->recipient_name = $name;
    }
    public function set_subject($subject) {
        $this->subject .= $subject;
    }

public function set_content($content) {
$this->content = <<<EOD
<img src="cid:psb-logo" style="width: 141px; height: 108px;"/>
<h1 style="text-align: center"><b>Pro State Bank</b></h1>
<h2 style="text-align: center">Jauns ziņojums</h2>
<p>$content</p>
EOD;
}
}
