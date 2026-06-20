<?php 
include 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vemail = $_POST['txtemail'] ?? '';
    $vsenha = $_POST['txtsenha'] ?? '';

    try {
        $stmt = $cmd->prepare("SELECT * FROM tb_Usuario WHERE Email = :email AND Senha = :senha");
        $stmt->execute([
            ':email' => $vemail,
            ':senha' => $vsenha
        ]);

        if ($stmt->rowCount() > 0) {
            echo "<script>
                    alert('Login bem-sucedido!');
                    location.href='index.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Email ou senha incorretos. Tente novamente.');
                    location.href='login.html';
                  </script>";
        }
    } catch (PDOException $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
} else {
    header("Location:login.html");
    exit();
}
?>