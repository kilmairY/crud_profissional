
<?php
// Importa dependências e inicia sessão
require_once __DIR__ . '/Dados/db.php';
require_once __DIR__ . '/Dados/Carros.php';

session_start();

// Verifica se o usuário está logado
if (!$_SESSION["usuario"]) {
    header("Location: form_login.php");
    exit();
}

// Busca marcas para o select
$conn = DataBase::conectar();
$stmt = $conn->query('SELECT * FROM marcas ORDER BY nome ASC');
$marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inicializa variáveis do carro
$editMode = false;
$carro = [
    'id' => '',
    'marca_id' => '',
    'modelo_id' => '',
    'cor' => '',
    'ano' => '',
    'preco' => '',
    'imagem' => ''
];
$modelos = [];

// Se estiver editando, busca dados do carro e modelos da marca
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $editMode = true;
    $carroObj = new Carros();
    $carro = $carroObj->obterPorId($_GET['id']);
    // Buscar modelos da marca do carro
    $stmtModelo = $conn->prepare('SELECT * FROM modelos WHERE marca_id = :marca_id ORDER BY nome ASC');
    $stmtModelo->bindParam(':marca_id', $carro['marca_id']);
    $stmtModelo->execute();
    $modelos = $stmtModelo->fetchAll(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Carros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 1rem;
            min-width: 500px;
            min-height: 600px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        .form-label,
        .form-group label {
            font-size: 1.2rem;
        }

        .form-check-label {
            font-size: 1.1rem;
        }

        .imagem-preview {
            width: 100%;
            height: 220px;
            background: #e9ecef;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <form action="Views/CarrosController.php" method="POST" enctype="multipart/form-data">
        <?php if ($editMode): ?>
            <input type="hidden" name="acao" value="editarCarro">
            <input type="hidden" name="id" value="<?= htmlspecialchars($carro['id']) ?>">
        <?php else: ?>
            <input type="hidden" name="acao" value="cadastrarCarro">
        <?php endif; ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12">
                    <div class="card shadow-lg border-0 p-5 mt-5">
                        <div class="card-body">
                            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
                                <div class="alert alert-success d-flex align-items-center small" role="alert">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <div><strong>Sucesso!</strong> Carro cadastrado com Sucesso</div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_GET['sucessoed']) && $_GET['sucessoed'] == 1): ?>
                                <div class="alert alert-success d-flex align-items-center shadow-sm p-2 mb-3" role="alert" style="font-size:1.1em;">
                                    <i class="fas fa-check-circle mr-2" style="font-size:1.5em;"></i>
                                    <div><strong>Sucesso!</strong> As informações do carro foram <b>atualizadas</b> corretamente.</div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
                                <div class="alert alert-danger d-flex align-items-center small" role="alert">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <div>Ocorreu algum erro em inserir os dados</div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_GET['erro']) && $_GET['erro'] == 2): ?>
                                <div class="alert alert-danger d-flex align-items-center small" role="alert">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <div>Termine o cadastro corretamente.</div>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-6 text-left">
                                    <a href="form_inicio.php?" class="btn btn-primary shadow-sm">
                                        <i class="fas fa-home mr-2"></i> Início
                                    </a>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="form_visualizar_carros.php" class="btn btn-primary shadow-sm">
                                        <i class="fas fa-eye mr-2"></i> Visualizar Carros
                                    </a>
                                </div>
                            </div>

                            <label class="text-center mb-4">Cadastro de Carros</label>
                            <div class="row mb-3">
                                <div class="col-md-6 form-group">
                                    <label for="marcaCarro">Selecione a Marca</label>
                                    <select class="form-control" id="marca" name="marca_id" required>
                                        <option value="">-- Selecione --</option>
                                        <?php foreach ($marcas as $marca): ?>
                                            <option value="<?= htmlspecialchars($marca['id']) ?>" <?= $editMode && $carro['marca_id'] == $marca['id'] ? 'selected' : '' ?>><?= htmlspecialchars($marca['nome']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="modeloCarro">Selecione o Modelo</label>
                                    <select class="form-control" id="modeloCarro" name="modelo_id" required <?= $editMode ? '' : 'disabled' ?>>
                                        <option value="">-- Selecione o modelo --</option>
                                        <?php if ($editMode): ?>
                                            <?php foreach ($modelos as $modelo): ?>
                                                <option value="<?= htmlspecialchars($modelo['id']) ?>" <?= $carro['modelo_id'] == $modelo['id'] ? 'selected' : '' ?>><?= htmlspecialchars($modelo['nome']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row-md-12">
                                    <label class="form-label">Cor</label><br>
                                    <input type="hidden" name="cor" id="cor" value="<?= htmlspecialchars($carro['cor']) ?>" required>
                                    <div class="col-md-2 form-check form-check-inline">
                                        <button type="button" class="btn btn-outline-dark btn-lg text-black btnSelecionaCor p-4" data-cor="Preto" id="corPreto">
                                            <span style="display:inline-block;width:20px;height:20px;background:#222;border:1px solid #ccc;margin-right:6px;"></span>Preto
                                        </button>
                                    </div>
                                    <div class="col-md-2 form-check form-check-inline">
                                        <button type="button" class="btn btn-outline-success btn-lg text-black btnSelecionaCor p-4" data-cor="Verde" id="corVerde">
                                            <span style="display:inline-block;width:20px;height:20px;background:#008000;border:1px solid #ccc;margin-right:6px;"></span>Verde
                                        </button>
                                    </div>
                                    <div class="col-md-2 form-check form-check-inline">
                                        <button type="button" class="btn btn-outline-secondary btn-lg text-dark btnSelecionaCor p-4" data-cor="Prata" id="corPrata">
                                            <span style="display:inline-block;width:20px;height:20px;background:linear-gradient(135deg,#eee 60%,#aaa 100%);border:1px solid #ccc;margin-right:6px;"></span>Prata
                                        </button>
                                    </div>
                                    <div class="col-md-3 form-check form-check-inline">
                                        <button type="button" class="btn btn-outline-danger btn-lg text-black btnSelecionaCor p-4" data-cor="Vermelho" id="corVermelho">
                                            <span style="display:inline-block;width:20px;height:20px;background:#c00;border:1px solid #ccc;margin-right:6px;"></span>Vermelho
                                        </button>
                                    </div>
                                    <div class="col-md-2 form-check form-check-inline">
                                        <button type="button" class="btn btn-outline-primary btn-lg text-black btnSelecionaCor p-4" data-cor="Azul" id="corAzul">
                                            <span style="display:inline-block;width:20px;height:20px;background:#007bff;border:1px solid #ccc;margin-right:6px;"></span>Azul
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ano" class="form-label">Ano</label>
                                    <input type="number" class="form-control" id="ano" name="ano" min="1900" max="<?= date('Y') ?>" value="<?= htmlspecialchars($carro['ano']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="valor" class="form-label">Valor</label>
                                    <input type="text" class="form-control" id="valor" name="valor" min="0" step="0.01" placeholder="R$0.00" oninput="maskMoney(this)" value="<?= htmlspecialchars($carro['preco']) ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <?php if ($editMode): ?>
                                    <!-- IMAGENS ATUAIS -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Imagens Atuais</label>
                                        <div class="row" id="imagensAtuais">
                                            <?php
                                            require_once __DIR__ . '/Dados/ImagensCarros.php';
                                            $imagens = ImagensCarros::buscarPorCarro($carro['id']);

                                            if (!empty($imagens)):
                                                foreach ($imagens as $img):
                                            ?>
                                                    <div class="col-md-3 mb-3 imagem-item" data-img-id="<?= $img['id'] ?>">
                                                        <div class="card">
                                                            <img src="Arquivos/<?= htmlspecialchars($img['nome_arquivo']) ?>"
                                                                class="card-img-top"
                                                                style="height: 150px; object-fit: cover;">
                                                            <div class="card-body p-2 text-center">
                                                                <?php if ($img['is_principal']): ?>
                                                                    <span class="badge badge-primary mb-2">Principal</span>
                                                                <?php else: ?>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-primary btn-definir-principal mb-2"
                                                                        data-img-id="<?= $img['id'] ?>">
                                                                        Definir como Principal
                                                                    </button>
                                                                <?php endif; ?>
                                                                <br>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger btn-deletar-imagem"
                                                                    data-img-id="<?= $img['id'] ?>">
                                                                    <i class="fas fa-trash"></i> Excluir
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <div class="col-12">
                                                    <p class="text-muted">Nenhuma imagem cadastrada</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- UPLOAD DE NOVAS IMAGENS -->
                                <div class="col-md-12">
                                    <label for="imagensCarro" class="form-label">
                                        <?= $editMode ? 'Adicionar Mais Imagens' : 'Imagens do Carro' ?>
                                    </label>
                                    <input type="file"
                                        class="form-control"
                                        id="imagensCarro"
                                        name="imagens[]"
                                        accept="image/*"
                                        multiple
                                        <?= $editMode ? '' : 'required' ?>>
                                    <small class="text-muted">Você pode selecionar múltiplas imagens</small>

                                    <!-- Preview das imagens selecionadas -->
                                    <div id="previewNovasImagens" class="row mt-3"></div>
                                </div>
                            </div>
                            <div class="d-grid text-right col-lg-2 align-items-right mt-4 ml-auto">
                                <?php if ($editMode): ?>
                                    <button type="submit" id="editarCarro" class="btn btn-primary fas fa-car py-2 fw-bold shadow-sm">
                                        Salvar Alterações
                                    </button>
                                <?php else: ?>
                                    <button type="submit" id="cadastrarCarro" class="btn btn-primary fas fa-car py-2 fw-bold shadow-sm">
                                        Cadastrar Carro
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
    <script>
        document.getElementById('marca').addEventListener('change', function() {
            var marcaId = this.value;
            var modeloSelect = document.getElementById('modeloCarro');
            modeloSelect.innerHTML = '<option value="">Carregando...</option>';
            modeloSelect.disabled = true;
            if (marcaId) {
                fetch('Views/BuscarModelo.php?id=' + marcaId)
                    .then(response => response.json())
                    .then(data => {
                        modeloSelect.innerHTML = '<option value="">-- Selecione --</option>';
                        data.forEach(function(modelo) {
                            modeloSelect.innerHTML += `<option value="${modelo.id}">${modelo.nome}</option>`;
                        });
                        modeloSelect.disabled = false;
                    })
                    .catch(() => {
                        modeloSelect.innerHTML = '<option value="">Erro ao carregar</option>';
                    });
            } else {
                modeloSelect.innerHTML = '<option value="">-- Selecione a marca primeiro --</option>';
                modeloSelect.disabled = true;
            }
        });



        // Seleção de cor
        const corInput = document.getElementById('cor');
        const botoesCor = document.querySelectorAll('.btnSelecionaCor');

        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($editMode): ?>
                const corAtual = "<?= htmlspecialchars($carro['cor'], ENT_QUOTES) ?>";
                const botoesCor = document.querySelectorAll('.btnSelecionaCor');

                setTimeout(() => {
                    botoesCor.forEach(btn => {
                        if (btn.dataset.cor === corAtual) {
                            btn.click();
                        }
                    });
                }, 50);
            <?php endif; ?>
        });
        botoesCor.forEach((btn) => {
            // Salva a cor base do outline para cada botão
            btn.dataset.outline = Array.from(btn.classList).find(c => c.startsWith('btn-outline-'));
            const cor = btn.getAttribute('data-cor');
            let bgCor = '';
            switch (cor) {
                case 'Preto':
                    bgCor = 'linear-gradient(135deg,#222 60%,#000 100%)';
                    break;
                case 'Verde':
                    bgCor = 'linear-gradient(135deg,#008000 60%,#004d00 100%)';
                    break;
                case 'Prata':
                    bgCor = 'linear-gradient(135deg,#eee 60%,#aaa 100%)';
                    break;
                case 'Vermelho':
                    bgCor = 'linear-gradient(135deg,#c00 60%,#800 100%)';
                    break;
                case 'Azul':
                    bgCor = 'linear-gradient(135deg,#007bff 60%,#004080 100%)';
                    break;
            }
            btn.dataset.bgcor = bgCor;
            btn.addEventListener('click', function() {
                botoesCor.forEach(b => {
                    b.classList.remove('btn-primary');
                    // Remove todas as classes
                    b.classList.forEach(cls => {
                        if (cls.startsWith('btn-outline-')) {
                            b.classList.remove(cls);
                        }

                    });
                    // Restaura a classe outline
                    if (b.dataset.outline) {
                        b.classList.add(b.dataset.outline);
                    }
                    // Remove background
                    b.style.background = '';
                    // Restaura cor do texto padrão
                    if (b.getAttribute('data-cor') === 'Prata') {
                        b.style.color = '#222';
                    } else {
                        b.style.color = '';
                    }
                });
                // Adiciona destaque ao selecionado
                this.classList.remove(this.dataset.outline);
                this.classList.add('btn-primary');

                // Aplica o background correspondente
                this.style.background = this.dataset.bgcor;
                switch (this.getAttribute('data-cor')) {
                    case 'Prata':
                        this.style.color = '#0a0909';
                        break;
                    default:
                        this.style.color = '#fff';
                }
                // Atualiza input hidden
                corInput.value = this.getAttribute('data-cor');
            });
        });

        function maskMoney(input) {

            let valor = input.value;
            valor = valor.replace(/\D/g, '');

            if (valor === '') {
                input.value = 'R$ 0,00';
                return;
            }
            valor = Number(valor) / 100;

            input.value = valor.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });

        }

        maskMoney(document.getElementById('valor'));
    </script>

    <script>
        // Dropzone
        const dropzone = document.getElementById('dropzoneImagem'); // Área visual
        const inputImagem = document.getElementById('imagemCarro'); // Input de arquivo oculto
        const previewImagem = document.getElementById('previewImagem'); // Imagem de preview
        const iconeImagem = document.getElementById('iconeImagem'); // Ícone e texto

        //abre o seletor de arquivos
        dropzone.addEventListener('click', () => inputImagem.click());

        // Ao arrastar arquivo sobre a área
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.style.background = '#d1e7dd';
        });
        // Restaura cor de fundo
        dropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropzone.style.background = '';
        });

        // Define arquivo no input e mostra preview
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.style.background = '';
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                inputImagem.files = e.dataTransfer.files;
                mostrarPreview(inputImagem.files[0]);
            }
        });

        // arquivos selecionados pelo input
        inputImagem.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                mostrarPreview(this.files[0]);
            }
        });

        // Função para exibir preview da imagem selecionada
        function mostrarPreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImagem.src = e.target.result;
                previewImagem.style.display = 'block';
                iconeImagem.style.display = 'none'; // Esconde ícone/texto
            };
            reader.readAsDataURL(file);
        }

        //Tratativa de imagens atuais (definir principal e deletar)
        document.getElementById('imagensCarro').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('previewNovasImagens');
            previewContainer.innerHTML = '';

            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    col.innerHTML = `
                <div class="card">
                    <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                    <div class="card-body p-2 text-center">
                        <small class="text-muted">Nova imagem ${index + 1}</small>
                    </div>
                </div>
            `;
                    previewContainer.appendChild(col);
                };

                reader.readAsDataURL(file);
            });
        });

        <?php if ($editMode): ?>
            // Deletar imagem
            document.querySelectorAll('.btn-deletar-imagem').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (!confirm('Tem certeza que deseja excluir esta imagem?')) return;

                    const imgId = this.getAttribute('data-img-id');

                    fetch('Views/DeletarImagem.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'img_id=' + imgId
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.sucesso) {
                                document.querySelector(`.imagem-item[data-img-id="${imgId}"]`).remove();
                                alert('Imagem excluída com sucesso!');
                            } else {
                                alert('Erro ao excluir imagem');
                            }
                        });
                });
            });

            // Definir como principal
            document.querySelectorAll('.btn-definir-principal').forEach(btn => {
                btn.addEventListener('click', function() {
                    const imgId = this.getAttribute('data-img-id');

                    fetch('Views/DefinirImagemPrincipal.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'img_id=' + imgId
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.sucesso) {
                                location.reload();
                            } else {
                                alert('Erro ao definir imagem principal');
                            }
                        });
                });
            });
        <?php endif; ?>
    </script>
</body>

</html>