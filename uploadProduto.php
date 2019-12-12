<?php
session_start();

//verificar se tem sessão iniciada
if(empty($_SESSION) || !array_key_exists('email',$_SESSION) || !isset($_SESSION['email'])){
	
	$_SESSION['error'] = array ('source' => 'editProduto.php','type' => 'No Permissions');
	header('Location:login.php');
	die();	
	}else{
	
	$email = $_SESSION['email'];
	
	require_once('dbmanager.php');
	$myDb = ligarDb();
	
	require_once('checkType.php');	
	if($tipoUser != 1){header('Location:index.php');
	die();}
	
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Carregar Produto - Loja Vinhos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	
</head>

<body>
<h1 style="text-align:center;">Carregar Produto Novo - LOJA DE VINHOS</h1>

<br>

<ul>
  <li><a href="userauth.php">Inicio</a></li>
  <li><a href="loja.php">Produtos</a></li>
  <li><a href="contato.php">Contato</a></li>
  <li><a href="editUser.php">Editar</a></li>
  <li><a href="about.asp">Sobre</a></li>
  <?
	if ($tipoUser ==1){
		echo '<li><a href="editProduto.php">Editar Produto</a></li>';
		echo '<li class="active"><a href="uploadProduto.php">Carregar Produto Novo</a></li>';
	}
	}
  ?>
  <li><a href="logout.php">Logout</a></li>
</ul>
<br>
<form method="post" enctype="multipart/form-data" action ="upload.php">
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
<input type="submit" value="Carregar..." name="upload"><br>
</form>
</body>
</html>