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

        switch (isset($_POST)) {
            case isset($_POST['ascNome']):
                $query = 'SELECT * FROM vinhos ORDER BY nome_vinho ASC';
                break;
            case isset($_POST['descNome']):
                $query = 'SELECT * FROM vinhos ORDER BY nome_vinho DESC';
                break;
            case isset($_POST['ascPreco']):
                $query = 'SELECT * FROM vinhos ORDER BY preco ASC';
                break;
            case isset($_POST['descPreco']):
                $query = 'SELECT * FROM vinhos ORDER BY preco DESC';
                break;
            case (int) $_POST['tipovinho'] == 1:
                $query = 'SELECT * FROM vinhos WHERE tipo=1';
                break;
            case (int) $_POST['tipovinho'] == 2:
                $query = 'SELECT * FROM vinhos WHERE tipo=2';
                break;
            case (int) $_POST['tipovinho'] == 3:
                $query = 'SELECT * FROM vinhos WHERE tipo=3';
                break;
            case (int) $_POST['tipovinho'] == 4:
                $query = 'SELECT * FROM vinhos WHERE tipo=4';
                break;
            case (int) $_POST['tipovinho'] == 5:
                $query = 'SELECT * FROM vinhos WHERE tipo=5';
                break;
            default:
                $query = 'SELECT * FROM vinhos';
                break;
        }

    ?>

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


<Body>

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
<table>
<br>
<tr>
	<form name="Table Properties" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<th>Nome  <input type="submit" value="^" name="ascNome"></input><input type="submit" value="v" name="descNome"></input></th>
		<th>Imagem</th>
		<th>Descrição</th>
		<th>Tipo <select name="tipovinho" selected="selected">
					  <option value="1">Tinto</option>
					  <option value="2">Porto</option>
					  <option value="3">Favaios</option>
					  <option value="4">Verde</option>
					  <option value="5">Rosé</option>
					</select> <input type="submit" value="Tipo Vinho"></th>
		<th>Preço  <input type="submit" value="^"name="ascPreco"></input><input type="submit" value="v"name="descPreco"></input></th>
	</form>
</tr>
<?php
    if ($result = mysqli_query($myDb, $query)) {
            while ($row = mysqli_fetch_row($result)) {

                $id_vinho = $row[0];
                $nomeVinho = $row[1];
                $imgvinho = $row[2];
                $descvinho = $row[3];
                $tipoVinho = $row[4];
                $precovinho = $row[5];

                for ($i = 1; $i <= sizeof($id_vinho); $i++) {

                    echo '<tr>';
                    echo '<th><a href="ProdutoVer.php?id=' . $id_vinho . '">' . $nomeVinho . '</a></th>';
                    echo '<th><img width="200px" height="300px" src="data:image/jpeg;base64,' . base64_encode($imgvinho) . '"/></th>';
                    echo '<th>' . $descvinho . '</th>';
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
                    echo '<th>' . $tipoVinho . '</th>';
                    echo '<th>' . $precovinho . '€</th>';
                    echo '<th><a href="editaProduto.php?id=' . $id_vinho . '"><input type="submit" value=" Adicionar ao carrinho" name="comprar"></a></th></tr>';
                }
            }
        }

    }

?>
</table>
</body>
</html>