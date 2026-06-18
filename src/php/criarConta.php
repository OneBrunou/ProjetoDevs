<?php
include 'conexao.php'; 

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebe os dados do HTML (se telefone não for enviado, assume 'n/a')
    $vnome     = $_POST['txtnome'] ?? '';
    $vemail    = $_POST['txtemail'] ?? '';
    $vsenha    = $_POST['txtsenha'] ?? '';
    $vtelefone = !empty($_POST['txttelefone']) ? $_POST['txttelefone'] : 'n/a';

    try {
      
        $stmt = $conn->prepare("INSERT INTO tb_usuario (Nome, Email, Senha, Telefone) VALUES (:nome, :email, :senha, :telefone)");
        
        
        $stmt->execute([
            ':nome'     => $vnome,
            ':email'    => $vemail,
            ':senha'    => $vsenha, // Dica: no futuro, use password_hash($vsenha, PASSWORD_DEFAULT) para maior segurança
            ':telefone' => $vtelefone
        ]);

        echo "<script>
                alert('Usuário cadastrado com sucesso!!!');
                location.href='CriarConta.html';
              </script>";

    } catch (PDOException $e) {

        echo "Erro ao salvar no banco de dados: " . $e->getMessage();
    }
} else {
    // Se tentarem acessar o arquivo PHP diretamente pelo navegador, joga de volta para o HTML
=======
        echo "Erro no banco de dados: " . $e->getMessage();
    }
} else {

    header("Location: CriarConta.html");
    exit();
}
?>