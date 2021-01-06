<?php
    session_start();

    $token = md5(session_id());
    //verificar se tem sessão iniciada
    if (empty($_SESSION) || !array_key_exists('email', $_SESSION) || !isset($_SESSION['email'])) {

        $_SESSION['error'] = array('source' => 'contato.php', 'type' => 'No Permissions');
        header('Location:index.php');
        die();

    } else {

        $email = $_SESSION['email'];

        require_once 'dbmanager.php';
        $myDb = ligarDb();
        require_once 'checkType.php';

        if ($result = mysqli_query($myDb, "SELECT nome, contato, morada FROM utilizadores WHERE email='$email'")) {
            while ($row = mysqli_fetch_row($result)) {

                $nomeUt = $row[0];
                $contatoUt = $row[1];
                $moradaUt = $row[2];
            }
        }

    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Loja Vinhos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
	<link rel="stylesheet" type="text/css" href="estilo.css">

</head>

<body>
<ul>
  <li class="active"><a href="userauth.php">Inicio</a></li>
  <li><a href="loja.php">Produtos</a></li>
  <li><a href="contato.php">Contato</a></li>
  <li><a href="editUser.php">EditarDados</a></li>
  <li><a href="about.asp">Sobre</a></li>
  <?
	if ($tipoUser ==1){
		echo '<li><a href="editProduto.php">Editar Produto</a></li>';
		echo '<li><a href="uploadProduto.php">Carregar Produto Novo</a></li>';
	}
  ?>
  <li><a href="logout.php">Logout</a></li>
</ul>
<br>
<h3> Bem vindo!                <?php echo $nomeUt; ?></h3>


</body>
</html>



