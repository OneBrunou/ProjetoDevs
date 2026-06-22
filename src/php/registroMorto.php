<?php

    echo "<link rel='stylesheet' type='text/css' href='../../src/css/registro.css'/>";
    include 'conexao.php';

    $resultado = $cmd->query("SELECT * FROM tb_usuario_apagado");
    $total_registros = $resultado->rowCount();

    if ($total_registros > 0)
    {
        echo "<body>";
        echo "<h1>Tabela de Registros Desativados</h1>";
        echo "<hr/>";
        echo "<table>";
        echo "<tr>
                <th colspan=6>
                    Dados Desativados
                </th>
              </tr>";
        echo "<tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Senha</th>
                <th>Telefone</th>
                <th>Nível</th>
              </tr>";

        while ($linha = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            $vId       = $linha['Id'];
            $vNome     = $linha['Nome'];
            $vEmail    = $linha['Email'];
            $vSenha    = $linha['Senha'];
            $vTelefone = $linha['Telefone'];
            $vNivel    = $linha['Nivel'];

            echo "<tr>
                    <td>$vId</td>
                    <td>$vNome</td>
                    <td>$vEmail</td>
                    <td>$vSenha</td>
                    <td>$vTelefone</td>
                    <td>$vNivel</td>
                  </tr>";
        }

        echo "</table>";
        echo "<br/><br/><br/>";
        echo "<a href='../../menu.html'>Menu</a>";
        echo "</body>";
    }
    else
    {
        echo "<script language=javascript> window.alert('Nenhum registro foi desativado!!!'); location.href='index.html';</script>";
    }
?>