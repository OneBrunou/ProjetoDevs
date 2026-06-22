<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../src/css/alterar.css">
    <title>Alterar Registros</title>
</head>
<body>
    <div class="form-alterar">
        <h3>Alterar Registros</h3>
        <form method="POST" action="alterar.php">
            <div class="form-group">
                <label for="txtcodi">Código (ID) para Consulta:</label>
                <input type="text" name="txtcodi" id="txtcodi" required>
            </div>

            <div class="form-group">
                <label for="txtnome">Nome:</label>
                <input type="text" name="txtnome" id="txtnome" readonly required>
            </div>

            <div class="form-group">
                <label for="txtemai">E-mail:</label>
                <input type="email" name="txtemai" id="txtemai" readonly required>
            </div>

            <div class="form-group">
                <label for="txtsenh">Senha:</label>
                <input type="password" name="txtsenh" id="txtsenh" readonly required>
            </div>

            <div class="form-group">
                <label for="txttele">Telefone:</label>
                <input type="text" name="txttele" id="txttele" readonly required>
            </div>

            <div class="form-group">
                <label for="txtnive">Nível de Acesso (Admin/Usuario):</label>
                <input type="text" name="txtnive" id="txtnive" readonly required>
            </div>

            <input type="submit" name="bt" id="bt" class="btn" value="Consultar">
        </form>

        <div class="menu-container">
            <a href="../../menu.html" class="btn btn-menu"><input type="button" value="Voltar ao Menu"></a>
        </div>
    </div>
</body>
</html>

<?php 
    include 'conexao.php';

    // Lista todos os dados cadastrados na tabela correta
    $listar = $cmd->query("select * from tb_usuario");
    $total_registros = $listar->rowCount();

    if ($total_registros > 0) {
        echo "<h2>Registros Atuais</h2>";
        echo "<table>";
        echo "<tr><th colspan='6'>Dados Cadastrados</th></tr>";
        echo "<tr>
                <th>Código (ID)</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Senha</th>
                <th>Telefone</th>
                <th>Nível</th>
              </tr>";
        
        while($linha = $listar->fetch(PDO::FETCH_ASSOC)) {
            $vcodi = $linha['Id'];
            $vnome = $linha['Nome'];
            $vemai = $linha['Email'];
            $vsenh = $linha['Senha'];
            $vtele = $linha['Telefone'];
            $vnive = $linha['Nivel'];
            
            echo "<tr>
                    <td>$vcodi</td>
                    <td>$vnome</td>
                    <td>$vemai</td>
                    <td>$vsenh</td>
                    <td>$vtele</td>
                    <td>$vnive</td>          
                  </tr>";
        }
        echo "</table>";
        
    } else {
        echo "<p style='text-align:center; color:white;'>Não existem registros para serem alterados!!!</p>";
    }
        
    // Lógica do botão de Consulta e Alteração
    if (isset($_POST['bt'])) {
        $vcodi = $_POST['txtcodi']; 
        $vbt   = $_POST['bt'];            

        if ($vbt == 'Consultar') { 
            // Busca o usuário pelo ID exato do banco de dados
            $pesq = $cmd->query("select * from tb_usuario where Id='$vcodi'");
            $total_registros = $pesq->rowCount();

            if ($total_registros > 0) {
                while($linha = $pesq->fetch(PDO::FETCH_ASSOC)) {
                    $vcodi = $linha['Id'];
                    $vnome = $linha['Nome'];
                    $vemai = $linha['Email'];
                    $vsenh = $linha['Senha'];
                    $vtele = $linha['Telefone'];
                    $vnive = $linha['Nivel'];
                    
                    // JavaScript injeta os valores de volta nos inputs e remove o 'readOnly'
                    echo "<script language=javascript>
                            document.getElementById('txtcodi').value='$vcodi';
                            document.getElementById('txtcodi').readOnly=true;
                            
                            document.getElementById('txtnome').readOnly = false;
                            document.getElementById('txtnome').value='$vnome';
                            
                            document.getElementById('txtemai').readOnly = false;
                            document.getElementById('txtemai').value='$vemai';
                            
                            document.getElementById('txtsenh').readOnly = false;
                            document.getElementById('txtsenh').value='$vsenh';
                            
                            document.getElementById('txttele').readOnly = false;
                            document.getElementById('txttele').value='$vtele';
                            
                            document.getElementById('txtnive').readOnly = false;
                            document.getElementById('txtnive').value='$vnive';
                            
                            document.getElementById('bt').value='Alterar';
                           </script>";
                }
            } else {
                echo "<script language=javascript> alert('Código (ID) inexistente!!!'); </script>";
                echo "<meta http-equiv='refresh' content='0' />"; 
            }
        }

        else if ($vbt == 'Alterar') { 
            $vcodi = $_POST['txtcodi']; 
            $vnome = $_POST['txtnome']; 
            $vemai = $_POST['txtemai'];
            $vsenh = $_POST['txtsenh'];
            $vtele = $_POST['txttele'];
            $vnive = $_POST['txtnive'];
            
            // Executa o UPDATE usando a nomenclatura exata do seu script SQL
            $alter = $cmd->query("update tb_usuario set Nome='$vnome', Email='$vemai', Senha='$vsenh', Telefone='$vtele', Nivel='$vnive' where Id='$vcodi'");
            
            echo "<script language=javascript>
                    alert('Registro alterado com sucesso!!! '); 
                    document.getElementById('bt').value='Consultar';
                    document.getElementById('txtcodi').readOnly = false;
                 </script>";
            echo "<meta http-equiv='refresh' content='0' />"; 
        }
    }                  
?>