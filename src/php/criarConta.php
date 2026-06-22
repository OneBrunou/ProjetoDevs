<?php
include 'conexao.php'; 

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebe e limpa os dados do HTML (trim remove espaços extras no início e fim)
    $vnome     = trim($_POST['txtnome'] ?? '');
    $vemail    = trim($_POST['txtemail'] ?? '');
    $vsenha    = $_POST['txtsenha'] ?? '';
    $vtelefone = !empty($_POST['txttelefone']) ? $_POST['txttelefone'] : 'n/a';

    // 1. Validação básica de campos vazios
    if (empty($vnome) || empty($vemail) || empty($vsenha)) {
        echo "<script>
                alert('Por favor, preencha todos os campos obrigatórios.');
                history.back();
              </script>";
        exit();
    }

    // 2. Validação de formato de e-mail correto (ex: usuario@dominio.com)
    if (!filter_var($vemail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('O e-mail digitado não é válido. Verifique a grafia.');
                history.back();
              </script>";
        exit();
    }

    try {
        // 3. Verificação no Banco de Dados: O e-mail já existe?
        $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM tb_usuario WHERE Email = :email");
        $stmtCheck->execute([':email' => $vemail]);
        
        if ($stmtCheck->fetchColumn() > 0) {
            // Se o contador for maior que 0, significa que o e-mail já está cadastrado
            echo "<script>
                    alert('Este e-mail já está sendo utilizado por outra conta!');
                    history.back();
                  </script>";
            exit();
        }

        // 4. Se passou em todas as validações, realiza o cadastro
        $stmt = $conn->prepare("INSERT INTO tb_usuario (Nome, Email, Senha, Telefone) VALUES (:nome, :email, :senha, :telefone)");
        
        $stmt->execute([
            ':nome'     => $vnome,
            ':email'    => $vemail,
            ':senha'    => $vsenha, 
            ':telefone' => $vtelefone
        ]);

        // Alerta de Sucesso
        echo "<script>
                alert('Usuário cadastrado com sucesso!!!');
                location.href='criarConta.php';
              </script>";
        exit();

    } catch (PDOException $e) {
        // Alerta de Erro Crítico no Banco de Dados
        $erro = addslashes($e->getMessage()); 
        echo "<script>
                alert('Erro crítico ao salvar no banco de dados: $erro');
                history.back();
              </script>";
        exit();
    }
}
?>