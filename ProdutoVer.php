<?php
    session_start();
    //verificar se tem sessão iniciada
    if (empty($_SESSION) || !array_key_exists('email', $_SESSION) || !isset($_SESSION['email'])) {
        $_SESSION['error'] = array('source' => 'contato.php', 'type' => 'No Permissions');
        header('Location:login.php');
        die();
    } else {
        require_once 'dbmanager.php';

        $myDb = ligarDb();
        $email = $_SESSION['email'];
        require_once 'checkType.php';
        $idvinho = $_GET['id'];

        if ($result = mysqli_query($myDb, "SELECT * FROM vinhos WHERE id_vinho='$idvinho'")) {
            while ($row = mysqli_fetch_row($result)) {
                $id_vinho = $row[0];
                $nomeVinho = $row[1];
                $imgvinho = $row[2];
                $descvinho = $row[3];
                $tipoVinho = $row[4];
                $precovinho = $row[5];
            }
        }
        if (!empty($_POST)) {
            require_once 'dbmanager.php';
            $comentario = $_POST['comentario'];
            if (!$myDb) {
                echo 'Something went wrong! Please try again later...';
                die();
            } else {
                $query = "INSERT INTO comentariosVinhos (comentario,id_vinho,id_utilizador) VALUES ('$comentario','$idvinho','$idutilizador')";
                $result = mysqli_query($myDb, $query);

                header('Location:ProdutoVer.php?id=' . $id_vinho . '');
            }
        }

        if ($result = mysqli_query($myDb, "SELECT * FROM comentariosVinhos WHERE id_vinho='$idvinho'")) {
            while ($row = mysqli_fetch_row($result)) {
                $idcoment[] = $row[0];
                $idut[] = $row[1];
                $comentario[] = $row[3];
                $dataStamp[] = $row[4];
            }

        }

    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Produtos - Loja Vinhos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
	<link rel="stylesheet" type="text/css" href="estilo.css">

</head>


<body>
<ul>
  <li><a href="userauth.php">Inicio</a></li>
  <li class="active"><a href="loja.php">Produtos</a></li>
  <li><a href="contato.php">Contato</a></li>
  <li><a href="editUser.php">EditarDados</a></li>
  <li><a href="about.asp">Sobre</a></li>
  <?php
      if ($tipoUser == 1) {
          echo '<li><a href="editProduto.php">Editar Produto</a></li>';
          echo '<li><a href="uploadProduto.php">Carregar Produto Novo</a></li>';
      }
  ?>
  <li><a href="logout.php">Logout</a></li>
</ul>

<?php
    echo '<a href="ProdutoVer.php?id=' . $id_vinho . '">' . $nomeVinho . '</a><br>';
    echo '<img width="200px" height="300px" src="data:image/jpeg;base64,' . base64_encode($imgvinho) . '"/><br>';
    echo '' . $descvinho . '';
    switch ($tipoVinho) {
        case 1:
            $tipoVinho = 'Tinto';
            break;
        case 2:
            $tipoVinho = 'Porto';
            break;
        case 3:
            $tipoVinho = 'Favaios';
            break;
        case 4:
            $tipoVinho = 'Verde';
            break;
        case 5:
            $tipoVinho = 'Rosé';
            break;
    }
    echo '<br>' . $tipoVinho . '<br>';
    echo 'Preço = ' . $precovinho . '<br>';
    echo '<a href="ProdutoVer.php?id=' . $id_vinho . '"><input type="submit" value=" Adicionar ao carrinho" name="comprar"></a><br>';
?>
<form method="POST" action="">
Adicionar Comentário:
<textarea name ="comentario" rows="10" cols="30"></textarea>
<input type="submit" value="comentario" name="comentar">
</form>
<br>
<div class="coment">
<?php
    if (!empty($idcoment)) {
        for ($i = 0; $i < sizeof($idcoment); $i++) {
            echo $idut[$i] . '<br>';
            echo $comentario[$i] . '<br>';
            echo $dataStamp[$i] . '<br>';
            echo '<br>';
        }
    }

?>
</div>
</body>
</html>