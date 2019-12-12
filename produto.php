<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


//verificar se tem sessão iniciada
if(empty($_SESSION) || !array_key_exists('email',$_SESSION) || !isset($_SESSION['email'])){
	$_SESSION['error'] = array ('source' => 'contato.php','type' => 'No Permissions');
	header('Location:login.php');
	die();	
}else{
	require_once('dbmanager.php');
$myDb = ligarDb();
	$email = $_SESSION['email'];

	require_once('checkType.php');
	if (isset($_GET['id'])){
		
		$id = $_GET['id'];
		$id=preg_replace('#[^0-9]#i','',$_GET['id']);
		$result = mysqli_query($myDb,"SELECT * FROM vinhos WHERE id_vinho='$id' LIMIT 1");
		$contaProdutos=mysqli_num_rows($result);
		if ($contaProdutos>0){
			while($row = mysqli_fetch_row($result)){
				$nomeVinho=$row[1];
				$imgvinho=$row[2];
				$descvinho=$row[3];
				$tipoVinho=$row[4];
				$precovinho=$row[5];
				switch($tipoVinho){
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
		}
	} else {
		echo"Esse produto não existe.";
		die();
	}
}
}
?>

<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><? echo $nomeVinho?> -  Vinhos</title>
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
<table>
  <tr>
    <th><?echo $nomeVinho;?></th>
	<th><?echo $tipoVinho;?></th>
    <th><?echo $precovinho;?></th>
  </tr>
  <tr>
    <td colspan="3"><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $imgvinho ).'"/>';?></td>
  </tr>
  <tr>
    <td colspan="3"><?echo $descvinho;?></td>
  </tr>
</table>
</body>
</html>