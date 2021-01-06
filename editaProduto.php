<?php
    error_reporting(E_ALL || E_NOTICE);
    session_start();

    //verificar se tem sessão iniciada
    if (empty($_SESSION) || !array_key_exists('email', $_SESSION) || !isset($_SESSION['email'])) {

        $_SESSION['error'] = array('source' => 'contato.php', 'type' => 'No Permissions');
        header('Location:index.php');
        die();
    } else {

        require_once 'dbmanager.php';
        $myDb = ligarDb();
        $email = $_SESSION['email'];
        require_once 'checkType.php';
        if ($tipoUser != 1) {header('Location:index.php');
            die();}

        $id = $_GET['id'];

        if ($result = mysqli_query($myDb, "SELECT * FROM vinhos WHERE id_vinho='$id'")) {
            while ($row = mysqli_fetch_row($result)) {
                $idVinho = $row[0];
                $nomeVinho = $row[1];
                $imgvinho = $row[2];
                $descvinho = $row[3];
                $tipoVinho = $row[4];
                $precovinho = $row[5];
            }
        }

        if (isset($_POST['delete'])) {
            $query = "DELETE FROM vinhos WHERE id_vinho='$idVinho'";
            $result = mysqli_query($myDb, $query);
            $delete = true;
        }
    }

?>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Editar Dados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
	<link rel="stylesheet" type="text/css" href="estilo.css">

</head>

<body>
<ul>
  <li><a href="userauth.php">Inicio</a></li>
  <li><a href="loja.php">Produtos</a></li>
  <li><a href="contato.php">Contato</a></li>
  <li><a href="editUser.php">Editar</a></li>
  <li><a href="about.asp">Sobre</a></li>
  <?
	if ($tipoUser ==1){
		echo '<li class="active"><a href="editProduto.php">Editar Produto</a></li>';
		echo '<li><a href="uploadProduto.php">Carregar Produto Novo</a></li>';
	}
  ?>
  <li><a href="logout.php">Logout</a></li>
</ul>
<br><br>
<form method="post" enctype="multipart/form-data" action ="upload.php?id=<?echo $id;?>">
   <!--Selecione uma imagem: <input name="arquivo" type="file" />
   <br/>
   <input type="submit" value="Salvar" />-->
   Nome do Vinho: <input name ="nomevinho" type="text"><br>
   Tipo de Vinho: <select name="tipovinho">
					  <option value="1">Tinto</option>
					  <option value="2">Porto</option>
					  <option value="3">Favaios</option>
					  <option value="4">Verde</option>
					  <option value="5">Rosé</option>
					</select> <br>
   Descrição:<textarea name ="descvinho" rows="10" cols="30"></textarea> <br>
   Imagem:<input name="imagem" type="file" /><br>
   Preço:<input name ="preco" type="text"><br>
<input type="submit" value="Atualizar..." name="update"><br><br><br>

</form>
<form method="POST" action="">
<input type="submit" value="Apagar item" name="delete">
</form>
<?if($delete){echo 'Produto apagado com sucesso <br>';}?>
<button onclick="window.location.href='editProduto.php'">Continuar</button>
  </body>
  </html>