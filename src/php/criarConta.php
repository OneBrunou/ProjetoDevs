<?php
include 'conexao.php'; 

// 1. Verifica se os dados vieram do formulário HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // O operador ?? '' garante que se o campo estiver vazio, não dê erro de Undefined
    $vnome  = $_POST['txtnome'] ?? '';
    $vemail = $_POST['txtemail'] ?? '';
    $vsenha = $_POST['txtsenha'] ?? '';
    $vsexo  = $_POST['txtsexo'] ?? '';
    $vdata  = $_POST['txtdata'] ?? '';

    try {
        // 2. ATENÇÃO: Mude $SUA_VARIAVEL_AQUI para a variável de conexão do seu conexao.php (ex: $conn, $pdo, $conexao)
        $stmt = $SUA_VARIAVEL_AQUI->prepare("INSERT INTO tb_teste (nome_t, email_t, senh_t, sexo_t, dtna_t) VALUES (:nome, :email, :senha, :sexo, :data)");
        
        $stmt->execute([
            ':nome'  => $vnome,
            ':email' => $vemail,
            ':senha' => $vsenha,
            ':sexo'  => $vsexo,
            ':data'  => $vdata
        ]);

        echo "<script>
                alert('Dados cadastrados com sucesso!!!');
                location.href='CriarConta.html';
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