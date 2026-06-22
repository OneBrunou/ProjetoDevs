<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Registros</title>
    <link rel='stylesheet' type='text/css' href='../css/excluir.css'/>
</head>
<body>

    <h1>Excluir Registros</h1>
    <hr>

    <form method="post" action="excluir.php">
        <label for="txtcodi">Código (ID) do registro a ser apagado :</label> 
        <input type="text" name="txtcodi" id="txtcodi" placeholder="digite o ID do usuário" required/>
        
        <input type="submit" name="bt" value="Excluir">
        <input type="button" value="Menu" onclick="location.href='../../menu.html'">
    </form>

    <br><br>

    <?php
        include 'conexao.php';

        if (isset($_POST['bt']) && !empty($_POST['txtcodi'])) {
            $codigo_para_excluir = $_POST['txtcodi'];

            
            $stmt = $cmd->prepare("DELETE FROM tb_usuario WHERE Id = :codigo");
            $stmt->bindValue(':codigo', $codigo_para_excluir, PDO::PARAM_INT);
          
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                echo "<script>
                        alert('Registro excluído com sucesso!');
                        location.href='excluir.php';
                      </script>";
                exit();
            } else {
                echo "<script>alert('Código (ID) inválido ou não encontrado');</script>";
            }
        }

        $lista = $cmd->query("select * from tb_usuario");
        $total_registros = $lista->rowCount();

        if ($total_registros == 0) {
            echo "<p style='text-align:center;'>Não existem registros cadastrados.</p>";
        } else {
            echo "<h2>Registros</h2>";
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

            while ($linha = $lista->fetch(PDO::FETCH_ASSOC)) {
                
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
        }
    ?>
    
</body>
</html>