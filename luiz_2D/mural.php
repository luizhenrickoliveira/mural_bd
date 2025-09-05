<?php
include "conexao.php";

if(isset($_POST['cadastra'])){
    $nome  = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $msg   = mysqli_real_escape_string($conexao, $_POST['msg']);

    $sql = "INSERT INTO recados (nome, email, mensagem) VALUES ('$nome', '$email', '$msg')";
    mysqli_query($conexao, $sql) or die("Erro ao inserir dados: " . mysqli_error($conexao));
    header("Location: mural.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<title>Mural de Pedidos</title>
<link rel="stylesheet" href="style.css"/>
</head>
<body>
<div class="container">
    <header>
        <h1>Mural de Pedidos</h1>
    </header>

    <section class="formulario">
        <form method="post">
            <label>Nome:</label>
            <input type="text" name="nome" required><br>
            
            <label>Email:</label>
            <input type="email" name="email" required><br>
            
            <label>Mensagem:</label>
            <textarea name="msg" required></textarea><br>
            
            <input type="submit" value="Publicar" name="cadastra" class="btn">
        </form>
    </section>

    <section class="recados">
        <h2>Mensagens já publicadas</h2>
        <?php
        $seleciona = mysqli_query($conexao, "SELECT * FROM recados ORDER BY id DESC");
        if(mysqli_num_rows($seleciona) == 0){
            echo "<p>Ainda não há mensagens no mural.</p>";
        }else{
            while($res = mysqli_fetch_assoc($seleciona)){
                echo '<div class="card">';
                echo '<p><strong>Nome:</strong> '.htmlspecialchars($res['nome']).'</p>';
                echo '<p><strong>Email:</strong> '.htmlspecialchars($res['email']).'</p>';
                echo '<p><strong>Mensagem:</strong><br>'.nl2br(htmlspecialchars($res['mensagem'])).'</p>';
                echo '</div>';
            }
        }
        ?>
    </section>
</div>
</body>
</html>