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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<style>
		body {
			background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
			font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
		}

		.card {
			border-radius: 1.5rem;
			border: none;
			backdrop-filter: blur(10px);
			background: rgba(255, 255, 255, 0.98);
			animation: slideUp 0.5s ease;
		}

		@keyframes slideUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.icon-circle {
			width: 70px;
			height: 70px;
			background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 1.5rem auto;
			box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
		}

		.btn-primary {
			background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
			border: none;
			border-radius: 10px;
			padding: 12px 20px;
			font-weight: 600;
			transition: all 0.3s ease;
			box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
		}

		.btn-primary:hover {
			transform: translateY(-2px);
			box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
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
								<i class="fas fa-check-circle fa-2x <?php if ($sucesso ?? false) {
																		echo 'text-success';
																	} else {
																		echo 'text-danger';
																	} ?>"></i>
							</div>
							<h3 class="font-weight-bold text-dark mb-3">Confirmação de E-mail</h3>
							<p class="<?php if ($sucesso ?? false) {
											echo 'text-success';
										} else {
											echo 'text-danger';
										} ?> mb-4"><?php echo $mensagem; ?></p>
							<a href="form_login.php" class="btn btn-primary w-100"><i class="fas fa-sign-in-alt mr-2"></i>Ir para o login</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>