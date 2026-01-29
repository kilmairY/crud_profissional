
<?php

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    header('Location: ../form_confirm.php?token=' . urlencode($token));
    exit;
} else {
    header('Location: ../form_confirm.php');
    exit;
}
