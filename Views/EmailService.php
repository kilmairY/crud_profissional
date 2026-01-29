<?php
// Serviço de envio de e-mail de recuperação de senha
// Este script recebe o e-mail via POST e envia o link de recuperação

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Dados/ResetSenha.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class EmailService{

    public $mail;
    public $subject = "";
    public $body = "";
    public $altBody = "";

        public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Encoding = 'base64';
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'kilmair.y@estudante.ifmt.edu.br'; // Remetente
        $this->mail->Password   = 'denf zchv dgfk pfck'; // Senha do remetente
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;
        $this->mail->setFrom('kilmair.y@estudante.ifmt.edu.br', 'Kilmair');
        $this->mail->isHTML(true);
        
    }

    public function enviarEmailConfirmacao($email, $token)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'E-mail inválido.';
        }

        $link = 'http://' . $_SERVER['HTTP_HOST'] . '/Cod2/crud_profissional/Views/ConfirmAcao.php?token=' . $token;
        $this->mail->Subject = '=?UTF-8?B?' . base64_encode('Confirmação de E-mail') . '?=';
        $this->mail->Body = '<p>Olá,</p><p>Por favor, confirme seu e-mail clicando no link abaixo:</p>';
        $this->mail->Body .= '<p><a href="' . $link . '">' . $link . '</a></p>';
        $this->mail->Body .= '<p>Se você não se registrou, ignore este e-mail.</p>';
        $this->mail->AltBody = "Olá,\nPor favor, confirme seu e-mail copiando e colando o link no navegador: $link";
        try {
            $this->mail->addAddress($email);
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Erro ao enviar e-mail: " . $this->mail->ErrorInfo;
        }
    }


    public function enviarEmailRecuperacao($email, $token)
    {
        // Validação básica do e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'E-mail inválido.';
        }

        // Monta o link de recuperação
        $link = 'http://' . $_SERVER['HTTP_HOST'] . '/Cod2/crud_profissional/form_resetar_senha.php?token=' . $token;

        // Conteúdo do e-mail
        $this->mail->Subject = '=?UTF-8?B?' . base64_encode('Redefinição de Senha') . '?=';
        $this->mail->Body = '<p>Olá,</p><p>Recebemos uma solicitação para redefinir sua senha. Clique no link abaixo para continuar:</p>';
        $this->mail->Body .= '<p><a href="' . $link . '">' . $link . '</a></p>';
        $this->mail->Body .= '<p>Se você não solicitou, ignore este e-mail.</p>';
        $this->mail->AltBody = "Olá,\nRecebemos uma solicitação para redefinir sua senha. Copie e cole o link no navegador: $link";

        try {
            $this->mail->addAddress($email);
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Erro ao enviar e-mail: " . $this->mail->ErrorInfo;
        }
    }
}


