<?php
// 1. LINK COM O BANCO DE DADOS: Importa o arquivo de conexão
require_once "conexao.php";

$erro = "";
$sucesso = "";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome  = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";
    $sexo  = $_POST["sexo"] ?? "";
    $dtna  = $_POST["dtna"] ?? "";
 
    // Validações
    if (empty($nome) || empty($email) || empty($senha) || empty($sexo) || empty($dtna)) {
        $erro = "Preencha todos os campos.";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } 
    elseif (strlen($nome) > 40) {
        $erro = "Nome deve ter no máximo 40 caracteres.";
    } 
    elseif (strlen($email) > 40) {
        $erro = "E-mail deve ter no máximo 40 caracteres.";
    } 
    elseif (strlen($senha) > 8) {
        $erro = "A senha deve ter no máximo 8 caracteres.";
    } 
    elseif (!in_array($sexo, ['M', 'F'])) {
        $erro = "Selecione um sexo válido.";
    }
    else {
        // A variável $conn vem de dentro do 'conexao.php'
        if ($conn->connect_error) {
            $erro = "Erro na conexão: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("INSERT INTO tb_teste (nome_t, email_t, senh_t, sexo_t, dtna_t) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nome, $email, $senha, $sexo, $dtna);
 
            if ($stmt->execute()) {
                $sucesso = "Conta criada com sucesso! Bem-vindo, " . htmlspecialchars($nome) . "!";
                $_POST = array();
                $nome = $email = $dtna = $sexo = "";
            } else {
                $erro = "Erro ao cadastrar: " . $stmt->error;
            }
            $stmt->close();
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <link rel="stylesheet" href="src/css/criarConta.css">
  
  <title>Criar Conta</title>
</head>
<body>

  <div class="card">
 
    <div class="logo-wrap">
      <img src="src/assets/Logo.png" alt="Logo">
    </div>
 
    <h1>Criar Conta</h1>
    <p class="subtitle">Preencha os dados abaixo para se cadastrar</p>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" style="color: red; margin-bottom: 15px;"><?= $erro ?></div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success" style="color: green; margin-bottom: 15px;"><?= $sucesso ?></div>
    <?php endif; ?>
 
    <form method="POST" action="">
 
      <div class="field">
        <label for="nome">Nome completo</label>
        <input type="text" id="nome" name="nome" placeholder="Seu nome" maxlength="40" value="<?= htmlspecialchars($nome ?? '') ?>" required/>
        <p class="hint">Máximo 40 caracteres</p>
      </div>
 
      <div class="field">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="seu@email.com" maxlength="40" value="<?= htmlspecialchars($email ?? '') ?>" required/>
      </div>
 
      <div class="row">
        <div class="field">
          <label for="senha">Senha</label>
          <input type="password" id="senha" name="senha" placeholder="Máx. 8 caracteres" maxlength="8" required/>
          <p class="hint">Máximo 8 caracteres</p>
        </div>
 
        <div class="field">
          <label for="dtna">Data de nascimento</label>
          <input type="date" id="dtna" name="dtna" value="<?= htmlspecialchars($dtna ?? '') ?>" required/>
        </div>
      </div>
 
      <div class="field">
        <label>Sexo</label>
        <div class="radio-group">
          <label>
            <input type="radio" name="sexo" value="M" <?= (($sexo ?? '') === 'M') ? 'checked' : '' ?> required />
            <span>♂ Masculino</span>
          </label>
          <label>
            <input type="radio" name="sexo" value="F" <?= (($sexo ?? '') === 'F') ? 'checked' : '' ?> />
            <span>♀ Feminino</span>
          </label>
        </div>
      </div>
 
      <button type="submit" class="btn">Criar Conta</button>
 
    </form>
 
    <div class="divider">ou</div>
 
    <p class="login-link">Já tem uma conta? <a href="login.html">Entrar</a></p>
 
  </div>

</body>
</html>