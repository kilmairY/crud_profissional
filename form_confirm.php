<?php
require_once __DIR__ . '/Dados/Confirm.php';

$mensagem = '';

if (isset($_GET['token'])) {
	$token = $_GET['token'];
	// Verificação do token e confirmação do e-mail
	if (Confirm::confirmarEmail($token)) {
		$mensagem = 'E-mail confirmado com sucesso! Agora você pode fazer login.';
		$sucesso = true;
	} else {
		$mensagem = 'Token inválido ou expirado.';
		$sucesso = false;
	}
} else {
	$mensagem = 'Token não informado.';
	$sucesso = false;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Confirmação de E-mail</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<style>
		body {
			background-color: #f4f6f9;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.card {
			border-radius: 1rem;
		}
		.icon-circle {
			width: 70px;
			height: 70px;
			background-color: #e9ecef;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 1.5rem auto;
			color: #0d6efd;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-5 col-lg-4">
				<div class="card shadow-lg border-0 p-3">
					<div class="card-body">
						<div class="text-center">
							<div class="icon-circle shadow-sm mb-3">
								<i class="fas fa-check-circle fa-2x <?php if($sucesso ?? false) { echo 'text-success'; } else { echo 'text-danger'; } ?>"></i>
							</div>
							<h3 class="fw-bold text-dark mb-3">Confirmação de E-mail</h3>
							<p class="<?php if($sucesso ?? false) { echo 'text-success'; } else { echo 'text-danger'; } ?> fw-semibold mb-4"><?php echo $mensagem; ?></p>
							<a href="form_login.php" class="btn btn-primary w-100"><i class="fas fa-sign-in-alt me-2"></i>Ir para o login</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>