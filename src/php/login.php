<?php
// Certifique-se de que o caminho para o seu arquivo de conexão está correto
include 'conexao.php'; 

// Inicia a sessão no topo do arquivo (boa prática para evitar erros de Headers)
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe e limpa os dados do formulário
    $email = trim($_POST['txtemail'] ?? '');
    $senha = $_POST['txtsenha'] ?? '';

    // Verifica se os campos não estão vazios
    if (empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos!'); history.back();</script>";
        exit();
    }

    try {
        // Usando a variável $cmd que você definiu no seu conexao.php
        $query = $cmd->prepare("SELECT * FROM tb_usuario WHERE Email = ? AND Senha = ?");
        $query->execute([$email, $senha]);
        
        // Pega os dados do usuário encontrado
        $usuario = $query->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Guarda os dados na sessão
            // IMPORTANTE: Verifique se no seu banco de dados as colunas começam com Letra Maiúscula
            $_SESSION['id']    = $usuario['Id'] ?? $usuario['id']; 
            $_SESSION['nome']  = $usuario['Nome'] ?? $usuario['nome'];
            $_SESSION['nivel'] = $usuario['Nivel'] ?? $usuario['nivel'] ?? 'usuario'; 

            // Redireciona para a página de registros
            echo "<script>location.href='registros.php';</script>";
            exit();
        } else {
            // Se não encontrou nenhuma linha correspondente, cai aqui
            echo "<script>alert('E-mail ou senha incorretos!'); location.href='../../login.html';</script>";
            exit();
        }

    } catch (PDOException $e) {
        // Se houver algum erro de banco (como nome de tabela errado), ele mostra o alerta abaixo
        $erro = addslashes($e->getMessage());
        echo "<script>alert('Erro no banco de dados: $erro'); history.back();</script>";
        exit();
    }
}
?>