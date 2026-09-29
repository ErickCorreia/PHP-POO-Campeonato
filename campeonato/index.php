<?php
require_once 'Time.php';

// Configuração de Conexão PDO
$host = 'localhost';
$db_name = 'campeonato';
$username = 'root'; // Altere se o seu usuário não for root
$password = 'ceub123456';     // Altere se tiver senha no seu banco

try {
    $pdo = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

$timeObj = new Time($pdo);
$timeEdit = null;

// Processar formulário (Inserir ou Atualizar)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $timeObj->nome = $_POST['nome'];
    $timeObj->cor = $_POST['cor'];
    $timeObj->ano = $_POST['ano'];
    $timeObj->presidente = $_POST['presidente'];

    if (!empty($_POST['id'])) {
        $timeObj->id = $_POST['id'];
        $timeObj->atualizar();
    } else {
        $timeObj->inserir();
    }
    header("Location: index.php");
    exit;
}

// Processar ações GET (Excluir ou buscar para Editar)
if (isset($_GET['acao']) && isset($_GET['id'])) {
    $timeObj->id = $_GET['id'];
    
    if ($_GET['acao'] == 'excluir') {
        $timeObj->excluir();
        header("Location: index.php");
        exit;
    } elseif ($_GET['acao'] == 'editar') {
        $timeEdit = $timeObj->listarPorId();
    }
}

$times = $timeObj->listar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Campeonato Brasileiro</title>
    <!-- FontAwesome para os ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --verde-cbf: #009b3a;
            --amarelo-cbf: #fedf00;
            --azul-cbf: #002776;
            --bg-color: #e9ecef;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            padding-bottom: 60px;
        }

        /* Cabeçalho */
        header {
            background-color: #fff;
            padding: 15px 40px;
            display: flex;
            align-items: center;
            border-bottom: 5px solid var(--verde-cbf);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: relative;
        }
        
        header::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--amarelo-cbf);
        }

        .logo-cbf {
            font-size: 3rem;
            color: var(--azul-cbf);
            margin-right: 20px;
        }

        .header-title h1 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }

        .header-title h2 {
            margin: 0;
            font-size: 16px;
            color: #666;
            font-weight: normal;
        }

        /* Layout Principal (Grid/Flex) */
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 30px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Cartões (Formulário e Tabela) */
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Coluna Esquerda: Formulário */
        .form-section {
            flex: 1;
            min-width: 300px;
            max-width: 400px;
            border: 2px solid var(--amarelo-cbf);
        }

        .form-header {
            background-color: var(--verde-cbf);
            color: #fff;
            text-align: center;
            padding: 15px;
            font-weight: bold;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .form-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: var(--verde-cbf);
            outline: none;
        }

        /* Ajuste para o input de cor parecer profissional */
        .input-cor {
            height: 40px;
            cursor: pointer;
            padding: 2px !important;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            text-decoration: none;
            color: white;
            box-sizing: border-box;
        }

        .btn-salvar { background-color: var(--verde-cbf); color: white; }
        .btn-salvar:hover { background-color: #007a2e; }

        .btn-cancelar { background-color: #d9534f; color: white; }
        .btn-cancelar:hover { background-color: #c9302c; }

        /* Coluna Direita: Tabela */
        .table-section {
            flex: 2;
            min-width: 600px;
            background: transparent;
            box-shadow: none;
        }

        .table-header-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        thead {
            background-color: #e3d386; /* Tom amarelado semelhante à imagem */
            color: #333;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th { font-size: 14px; }

        tbody tr:nth-child(even) {
            background-color: #f6fcf8; /* Tom esverdeado muito claro */
        }
        
        tbody tr:nth-child(odd) {
            background-color: #fdfdfd; 
        }

        tbody tr:hover {
            background-color: #eaf5eb;
        }

        /* Cores no grid */
        .color-box {
            display: inline-block;
            width: 25px;
            height: 25px;
            border-radius: 4px;
            border: 1px solid #999;
            vertical-align: middle;
        }

        /* Ações */
        .acoes a {
            text-decoration: none;
            margin-right: 10px;
            font-size: 18px;
        }
        .btn-edit { color: #0275d8; }
        .btn-delete { color: #d9534f; }

        /* Rodapé */
        footer {
            background-color: var(--verde-cbf);
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 14px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <header>
        <i class="fas fa-shield-alt logo-cbf"></i>
        <div class="header-title">
            <h1>ADMINISTRAÇÃO</h1>
            <h2>CAMPEONATO BRASILEIRO - TIMES</h2>
        </div>
    </header>

    <div class="container">
        <!-- ÁREA DO FORMULÁRIO -->
        <div class="card form-section">
            <div class="form-header">
                <i class="fas fa-futbol"></i> 
                <?= $timeEdit ? 'EDITAR TIME' : 'CADASTRAR TIME' ?>
            </div>
            
            <div class="form-body">
                <form action="index.php" method="POST">
                    <input type="hidden" name="id" value="<?= $timeEdit['id'] ?? '' ?>">
                    
                    <div class="form-group">
                        <label>NOME DO TIME</label>
                        <input type="text" name="nome" placeholder="Ex: Clube de Regatas do Flamengo" value="<?= $timeEdit['nome'] ?? '' ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>COR PRINCIPAL</label>
                        <!-- Usando input type="color" para facilitar a vida, retorna HEX -->
                        <input type="color" class="input-cor" name="cor" value="<?= $timeEdit['cor'] ?? '#000000' ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>ANO DE FUNDAÇÃO</label>
                        <input type="number" name="ano" placeholder="Ex: 1895" value="<?= $timeEdit['ano'] ?? '' ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>PRESIDENTE</label>
                        <input type="text" name="presidente" placeholder="Nome do Presidente" value="<?= $timeEdit['presidente'] ?? '' ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-salvar">
                        <i class="fas fa-save"></i> <?= $timeEdit ? 'SALVAR ALTERAÇÕES' : 'CADASTRAR' ?>
                    </button>
                    
                    <?php if($timeEdit): ?>
                        <a href="index.php" class="btn btn-cancelar">
                            <i class="fas fa-times-circle"></i> CANCELAR
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- ÁREA DA TABELA -->
        <div class="table-section">
            <div class="table-header-title">Lista de Times Cadastrados</div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ESCUDO</th>
                        <th>NOME</th>
                        <th>COR</th>
                        <th>ANO</th>
                        <th>PRESIDENTE</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($times) > 0): ?>
                        <?php foreach ($times as $t): ?>
                        <tr>
                            <td><?= $t['id'] ?></td>
                            <td><i class="fas fa-shield-halved" style="color: #666; font-size: 20px;"></i></td>
                            <td style="font-weight: 500;"><?= htmlspecialchars($t['nome']) ?></td>
                            <td>
                                <!-- A cor salva no banco é exibida visualmente numa div (color-box) -->
                                <div class="color-box" style="background-color: <?= htmlspecialchars($t['cor']) ?>;" title="<?= htmlspecialchars($t['cor']) ?>"></div>
                            </td>
                            <td><?= htmlspecialchars($t['ano']) ?></td>
                            <td><?= htmlspecialchars($t['presidente']) ?></td>
                            <td class="acoes">
                                <a href="?acao=editar&id=<?= $t['id'] ?>" class="btn-edit" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href="?acao=excluir&id=<?= $t['id'] ?>" class="btn-delete" title="Excluir" onclick="return confirm('Tem certeza que deseja remover este time do campeonato?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: #666;">
                                Nenhum time cadastrado no campeonato ainda.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        DESENVOLVIDO PARA ADS 4º SEMESTRE | PROJETO CAMPEONATO BRASILEIRO | <?= date('Y') ?>
    </footer>

</body>
</html>