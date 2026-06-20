<?php
include 'conexao.php'; 

// 1. Verifica se os dados vieram do formulário HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // O operador ?? '' garante que se o campo estiver vazio, não dê erro de Undefined
    $vnome  = $_POST['txtnome'] ?? '';
    $vemail = $_POST['txtemail'] ?? '';
    $vsenha = $_POST['txtsenha'] ?? '';
    $vdata  = $_POST['txtdata'] ?? '';

    try {

        $stmt = $cmd->prepare("INSERT INTO tb_Usuario (Nome, Email, Senha) VALUES (:nome, :email, :senha)");
        
        $stmt->execute([
            ':Nome'  => $vnome,
            ':Email' => $vemail,
            ':Senha' => $vsenha,
      
        ]);

        echo "<script>
                alert('Conta criada com sucesso!!!');
                location.href='index.html';
              </script>";

    } catch (PDOException $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
} else {
    // Se tentarem acessar o PHP direto, redireciona de volta para o formulário HTML
    header("Location: CriarConta.html");
    exit();
}
?>