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
    <title>Editar Produto - Loja Vinhos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	
</head>

<body>
<h1 style="text-align:center;">Editar Produtos - LOJA DE VINHOS</h1>

<br>

<ul>
  <li><a href="userauth.php">Inicio</a></li>
  <li><a href="loja.php">Produtos</a></li>
  <li><a href="contato.php">Contato</a></li>
  <li><a href="editUser.php">EditarDados</a></li>
  <li><a href="about.asp">Sobre</a></li>
  <?
	if ($tipoUser ==1){
		echo '<li class="active"><a href="editProduto.php">Editar Produto</a></li>';
		echo '<li><a href="uploadProduto.php">Carregar Produto Novo</a></li>';
	}
  ?>
  <li><a href="logout.php">Logout</a></li>
</ul>
<br>
<table>
  <?php
  if ($tipoUser != 1){
	 $_SESSION['error'] = array ('source' => 'editProduto.php','type' => 'No Permissions');
	header('Location:login.php');
	die();	
	}else{
		
  
  if($result = mysqli_query($myDb,"SELECT * FROM vinhos")){
		while($row = mysqli_fetch_row($result)){
			$id_vinho=$row[0];
			$nomeVinho=$row[1];
			$imgvinho=$row[2];
			$descvinho=$row[3];
			$tipoVinho=$row[4];
			$precovinho=$row[5];
		

		for($i=1;$i <= sizeof($id_vinho); $i++){
							
							echo'<tr>';
							echo '<th>'.$nomeVinho. '</th>';
							echo '<th><img src="data:image/jpeg;base64,'.base64_encode( $imgvinho ).'"/></tr>';
							echo '<th>'.$descvinho. '</th>';;
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
							echo '<th>'.$tipoVinho. '</th>';
							echo '<th>'.$precovinho. '</th>';
							echo '<th><a href="editaProduto.php?id='.$id_vinho.'"><input type="submit" value="Editar" name="Editar"></a></th></tr>';
						}
						}
			}
		}
	}
?>
</table>



</body>
</html>