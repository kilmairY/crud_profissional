
<?php
// Nova rota criada para compatibilidade com links antigos de confirmação de e-mail
// Redireciona para a tela de confirmação de e-mail (form_confirm.php), repassando o token se existir
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    header('Location: ../form_confirm.php?token=' . urlencode($token));
    exit;
} else {
    header('Location: ../form_confirm.php');
    exit;
}
