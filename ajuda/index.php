<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$target_dir = "uploads/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Função para evitar path traversal
function safeFileName($file) {
    return basename($file);
}

// Função para listar arquivos
function listarArquivos($diretorio) {
    $arquivos = array_diff(scandir($diretorio), array('.', '..'));
    if (empty($arquivos)) {
        echo '<tr><td colspan="4" style="text-align:center;">Nenhum arquivo enviado.</td></tr>';
        return;
    }
    foreach ($arquivos as $arquivo) {
        $arquivo_esc = htmlspecialchars($arquivo);
        $caminho = $diretorio . $arquivo;
        $tamanho = filesize($caminho);
        $data = date('d/m/Y H:i', filemtime($caminho));
        echo "<tr>
                <td style='word-break:break-all;'>$arquivo_esc</td>
                <td>" . formatBytes($tamanho) . "</td>
                <td>$data</td>
                <td style='text-align:center;'>
                    <div class='action-group'>
                        <a class='download_link' href='?download=" . urlencode($arquivo) . "'>Baixar</a>
                        <a class='download_link' href='?renomear=" . urlencode($arquivo) . "'>Renomear</a>
                        <a class='download_link' href='?deletar=" . urlencode($arquivo) . "' onclick=\"return confirm('Tem certeza que deseja excluir este arquivo?');\">Excluir</a>
                    </div>
                </td>
              </tr>";
    }
}

// Função para formatar bytes
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

// Variável para mensagens de feedback
$msg = '';
$msg_type = 'info';

// Excluir arquivo
if (isset($_GET['deletar'])) {
    $arquivo_para_deletar = $target_dir . safeFileName($_GET['deletar']);
    if (file_exists($arquivo_para_deletar)) {
        if (unlink($arquivo_para_deletar)) {
            $msg = "Arquivo excluído com sucesso.";
            $msg_type = 'success';
        } else {
            $msg = "Erro ao excluir o arquivo.";
            $msg_type = 'error';
        }
    } else {
        $msg = "Arquivo não encontrado.";
        $msg_type = 'error';
    }
}

// Renomear arquivo
if (isset($_POST['renomear']) && isset($_POST['novonome'])) {
    $nome_antigo = $target_dir . safeFileName($_POST['renomear']);
    $extensao_antiga = pathinfo($nome_antigo, PATHINFO_EXTENSION);
    $novo_nome_input = safeFileName($_POST['novonome']);
    // Garante que a extensão seja mantida
    if ($extensao_antiga) {
        $extensao_novo = pathinfo($novo_nome_input, PATHINFO_EXTENSION);
        if (strtolower($extensao_novo) !== strtolower($extensao_antiga)) {
            $novo_nome_input .= '.' . $extensao_antiga;
        }
    }
    $novo_nome = $target_dir . $novo_nome_input;
    if (file_exists($nome_antigo)) {
        if (file_exists($novo_nome)) {
            $msg = "Já existe um arquivo com esse nome.";
            $msg_type = 'error';
        } elseif (rename($nome_antigo, $novo_nome)) {
            $msg = "Arquivo renomeado com sucesso.";
            $msg_type = 'success';
        } else {
            $msg = "Falha ao renomear o arquivo.";
            $msg_type = 'error';
        }
    } else {
        $msg = "Arquivo não encontrado.";
        $msg_type = 'error';
    }
}

// Download de arquivo
if (isset($_GET['download'])) {
    $arquivo_para_baixar = $target_dir . safeFileName($_GET['download']);
    if (file_exists($arquivo_para_baixar)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($arquivo_para_baixar).'"');
        header('Content-Length: ' . filesize($arquivo_para_baixar));
        flush();
        readfile($arquivo_para_baixar);
        exit;
    } else {
        $msg = "Arquivo não encontrado.";
        $msg_type = 'error';
    }
}

// Upload de arquivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES["arquivoParaUpload"])) {
    $arquivos = $_FILES["arquivoParaUpload"];
    $sucesso = [];
    $erros = [];
    if (is_array($arquivos["name"])) {
        $total = count($arquivos["name"]);
        for ($i = 0; $i < $total; $i++) {
            $nome = safeFileName($arquivos["name"][$i]);
            $tmp = $arquivos["tmp_name"][$i];
            $erro = $arquivos["error"][$i];
            $arquivo_alvo = $target_dir . $nome;
            if ($erro != 0) {
                $erros[] = "$nome (Erro: $erro)";
                continue;
            }
            if (file_exists($arquivo_alvo)) {
                $erros[] = "$nome (já existe)";
                continue;
            }
            if (move_uploaded_file($tmp, $arquivo_alvo)) {
                $sucesso[] = $nome;
            } else {
                $erros[] = "$nome (falha ao enviar)";
            }
        }
        if ($sucesso && !$erros) {
            $msg = "Arquivo(s) enviado(s) com sucesso: " . implode(', ', array_map('htmlspecialchars', $sucesso));
            $msg_type = 'success';
        } elseif ($sucesso && $erros) {
            $msg = "Alguns arquivos foram enviados: " . implode(', ', array_map('htmlspecialchars', $sucesso)) . ". Erros: " . implode(', ', $erros);
            $msg_type = 'info';
        } elseif (!$sucesso && $erros) {
            $msg = "Nenhum arquivo enviado. Erros: " . implode(', ', $erros);
            $msg_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Arquivos</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            width: 100%;
            min-height: 100vh;
            background: #211c1c;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .file__upload {
            width: 400px;
            margin: 20px;
            box-shadow: 0 0 5px rgba(0,0,0,.3);
        }

        .file__upload .header {
            width: 100%;
            height: 145px;
            background: #591823;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px 5px 0 0;
        }

        .file__upload .header p {
            color: #FFF;
        }

        .file__upload .header p i.fa {
            margin-right: 10px;
        }

        .file__upload .header p span {
            font-size: 2rem;
            font-weight: 100;
        }

        .file__upload .header p span span {
            font-weight: 600;
        }

        .file__upload .body {
            background: #FFF;
            width: 100%;
            border-radius: 0 0 5px 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .file__upload .body input[type="file"] {
            opacity: 0;
        }

        .btn {
            background: #591823;
            border: none;
            outline: none;
            margin: 20px 0;
            padding: .7rem 2rem;
            font-size: 1.3rem;
            color: #FFF;
            border-radius: 3px;
            opacity: .8;
            cursor: pointer;
            transition: .3s;
        }

        .btn:hover {
            opacity: 1;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        ul li {
            margin-bottom: 10px;
            background: #FFF;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .download_link {
            text-decoration: none;
            color: #FFF;
            background: #920505;
            padding: .5rem 1.2rem;
            border-radius: 3px;
            opacity: .8;
            transition: .3s;
            margin: 0 3px;
            font-size: 1rem;
            display: inline-block;
        }

        .download_link:not(:last-child) {
            margin-right: 8px;
        }

        .download_link:hover {
            opacity: 1;
            background: #591823;
        }

        .custom-file-label {
            display: inline-block;
            background: #e0e0e0;
            color: #333;
            padding: .7rem 2rem;
            border-radius: 3px;
            cursor: pointer;
            margin-bottom: 10px;
            font-size: 1.1rem;
            transition: background .3s;
        }
        .custom-file-label:hover {
            background: #d1d1d1;
        }
        #fileLabelText {
            margin-right: 10px;
        }
        #submitBtn:disabled {
            background: #ccc;
            color: #888;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .notification-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }
        .notification-close {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .notification-close:hover {
            opacity: 0.8;
        }
        .table-container {
            width: 100%;
            max-width: 700px;
            margin: 0 auto 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.08);
            overflow-x: auto;
        }
        .file-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
        }
        .file-table th, .file-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
        }
        .file-table th {
            background: #591823;
            color: #fff;
            font-weight: 500;
        }
        .file-table tr:last-child td {
            border-bottom: none;
        }
        .action-group {
            display: flex;
            flex-wrap: nowrap;
            gap: 6px;
            justify-content: center;
            align-items: center;
        }
        .modal-bg {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }
        .modal-renomear {
            background: #fff;
            border-radius: 12px;
            padding: 32px 28px 22px 28px;
            min-width: 320px;
            max-width: 95vw;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        .modal-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #591823;
            text-align: center;
        }
        .modal-filename {
            font-size: 1rem;
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }
        .modal-input-group {
            display: flex;
            align-items: center;
            gap: 0;
            border: 1.5px solid #ccc;
            border-radius: 4px;
            margin-bottom: 18px;
            background: #f7f7f7;
            overflow: hidden;
            transition: border .2s;
        }
        .modal-input-group:focus-within {
            border-color: #591823;
            background: #fff;
        }
        .modal-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.7rem 1rem;
            font-size: 1.1rem;
            outline: none;
        }
        .modal-extensao {
            padding: 0.7rem 1rem 0.7rem 0.5rem;
            font-size: 1.1rem;
            color: #591823;
            background: transparent;
            user-select: none;
        }
        .btn-modal {
            width: 100%;
            margin-top: 5px;
            font-size: 1.1rem;
            font-weight: 500;
            background: #591823;
            color: #fff;
            border-radius: 4px;
            padding: .7rem 0;
            box-shadow: 0 2px 8px rgba(89,24,35,0.08);
            transition: background .2s, color .2s;
        }
        .btn-modal:hover {
            background: #920505;
            color: #fff;
        }
        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 1.7rem;
            color: #591823;
            cursor: pointer;
            transition: color .2s;
        }
        .modal-close:hover {
            color: #920505;
        }
        @media (max-width: 500px) {
            .modal-renomear {
                min-width: 90vw;
                padding: 18px 5vw 15px 5vw;
            }
            .btn-modal {
                font-size: 1rem;
                padding: .7rem 0;
            }
        }
    </style>
</head>
<body>

<div class="file__upload">
    <div class="header">
        <p><span>Upload</span> <span>de Arquivos</span></p>
    </div>
    <div class="body">
        <form action="" method="post" enctype="multipart/form-data" id="uploadForm">
            <label for="arquivoParaUpload" class="custom-file-label">
                <span id="fileLabelText">Nenhum arquivo selecionado</span>
                <input type="file" name="arquivoParaUpload[]" id="arquivoParaUpload" required style="display:none;" multiple>
            </label>
            <input class="btn" type="submit" value="Enviar Arquivo" name="submit" id="submitBtn" disabled>
        </form>
    </div>
</div>

<h2 style="color: #FFF;">Arquivos Enviados</h2>
<div class="table-container">
<table class="file-table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Tamanho</th>
            <th>Data</th>
            <th style="text-align:center;">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php listarArquivos($target_dir); ?>
    </tbody>
</table>
</div>

<?php if (isset($_GET['renomear'])): ?>
    <?php
        $nome_original = htmlspecialchars($_GET['renomear']);
        $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
        $extensao_str = $extensao ? '.' . $extensao : '';
        $nome_sem_ext = $extensao ? preg_replace('/\.' . preg_quote($extensao, '/') . '$/i', '', $nome_original) : $nome_original;
    ?>
    <div id="modalRenomearBg" class="modal-bg">
        <div class="modal-renomear">
            <button type="button" class="modal-close" id="closeRenomearModal">&times;</button>
            <form action="" method="post" id="formRenomear">
                <div class="modal-title">Renomear arquivo</div>
                <div class="modal-filename">Arquivo atual: <b><?= $nome_original; ?></b></div>
                <input type="hidden" name="renomear" value="<?= $nome_original; ?>">
                <div class="modal-input-group">
                    <input class="modal-input" type="text" name="novonome" id="novoNomeInput" value="<?= htmlspecialchars($nome_sem_ext); ?>" required placeholder="Novo nome do arquivo">
                    <span id="extensaoSpan" class="modal-extensao"><?= $extensao_str; ?></span>
                </div>
                <input class="btn btn-modal" type="submit" value="Renomear">
            </form>
        </div>
    </div>
<?php endif; ?>

<script>
    const fileInput = document.getElementById('arquivoParaUpload');
    const fileLabelText = document.getElementById('fileLabelText');
    const submitBtn = document.getElementById('submitBtn');

    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            const nomes = Array.from(fileInput.files).map(f => f.name).join(', ');
            fileLabelText.textContent = nomes;
            submitBtn.disabled = false;
        } else {
            fileLabelText.textContent = 'Nenhum arquivo selecionado';
            submitBtn.disabled = true;
        }
    });

    // Notificação no padrão da pasta check
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span>${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 300px;
        `;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) document.body.removeChild(notification);
            }, 300);
        }, 5000);
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) document.body.removeChild(notification);
            }, 300);
        });
    }

    // Exibir mensagem PHP como notificação, se houver
    <?php if ($msg): ?>
        window.addEventListener('DOMContentLoaded', function() {
            showNotification(<?= json_encode($msg) ?>, <?= json_encode($msg_type) ?>);
        });
    <?php endif; ?>

    // Modal de renomear
    const modalBg = document.getElementById('modalRenomearBg');
    const closeBtn = document.getElementById('closeRenomearModal');
    if (modalBg && closeBtn) {
        closeBtn.onclick = () => { modalBg.style.display = 'none'; };
        modalBg.onclick = (e) => { if (e.target === modalBg) modalBg.style.display = 'none'; };
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') modalBg.style.display = 'none';
        });
        // Foco automático no input
        const input = modalBg.querySelector('.modal-input');
        if (input) setTimeout(() => { input.focus(); input.select(); }, 200);
    }
</script>

</body>
</html>
