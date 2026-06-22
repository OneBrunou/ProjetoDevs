<?php
// Certifique-se de que o caminho para o seu arquivo de conexão está correto
include 'conexao.php'; 

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['txtemail'] ?? '');
    $senha = $_POST['txtsenha'] ?? '';

    if (empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos!'); history.back();</script>";
        exit();
    }

    try {
        // Busca exatamente de acordo com os campos criados no seu script SQL
        $query = $cmd->prepare("SELECT * FROM tb_usuario WHERE Email = ? AND Senha = ?");
        $query->execute([$email, $senha]);
        $usuario = $query->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // strtolower transforma "Admin" em "admin", evitando erros de digitação
            $nivelUsuario = strtolower($usuario['Nivel']);

            if ($nivelUsuario === 'admin') {
                // Guarda os dados exatos da tabela na sessão
                $_SESSION['id']    = $usuario['Id']; 
                $_SESSION['nome']  = $usuario['Nome'];
                $_SESSION['nivel'] = 'admin'; 

                // Redireciona para a página de registros
                echo "<script>location.href='../../menu.html';</script>";
                exit();
            } else {
                // Se for "Usuario" comum
                echo "<script>alert('Bem-vindo, $usuario[Nome]!'); location.href='../../index.html';</script>";
                exit();
            }
            
        } else {
            echo "<script>alert('E-mail ou senha incorretos!'); location.href='../../login.html';</script>";
            exit();
        }

    } catch (PDOException $e) {
        $erro = addslashes($e->getMessage());
        echo "<script>alert('Erro no banco de dados: $erro'); history.back();</script>";
        exit();
    }
}
?>