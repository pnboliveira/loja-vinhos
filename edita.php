	<?php
	error_reporting(E_ALL || E_NOTICE);
session_start();

//verificar se tem sessão iniciada
if(empty($_SESSION) || !array_key_exists('email',$_SESSION) || !isset($_SESSION['email'])){
	
	$_SESSION['error'] = array ('source' => 'contato.php','type' => 'No Permissions');
	header('Location:index.php');
	die();	
}else{
	
	require_once('dbmanager.php');
	$myDb = ligarDb();
	$email = $_SESSION['email'];
	
		require_once('checkType.php');
		
	
		
		if($result = mysqli_query($myDb,"SELECT nome, contato, morada, email, password, id_utilizadores FROM utilizadores WHERE email='$email'")){
			while($row = mysqli_fetch_row($result)){
				
				$nomeUt = $row[0];
				$contatoUt = $row[1];
				$moradaUt = $row[2];
				$emailUt = $row[3];
				$passUt = $row[4];
				$idUt = $row[5];
			}
		}
		if(!empty($_POST)){

	$username = $_POST['username'];
	$email = $_POST['email'];
	$contato = $_POST['contato'];
	$morada = $_POST['morada'];
	
	require_once('checkForm.php');
	$username = cleanFields($username);
	$email = cleanFields($email);
	$contato = cleanFields($contato);
	$morada = cleanFields($morada);
	
	$minusername = 3;
	$maxusername = 22;
	


	
	$errorsArray = array('username' => array (false,"O username deve ter entre $minusername e $maxusername caracteres.</br>"),
						 'email' => array (false,"O email não é válido</br>"),
						 'contato' => array (false,"O contato inserido não é válido.<br>"),
						 'morada' => array(false,"A morada inserida não é válida.<br>")
						);
	
	$flag = false;
	
	if( !checkStringAndLength($minusername, $maxusername, $username)){
		
		$errorsArray['username'][0] = true;
		$flag = true;
		
	}
	if( !checkEmail($email)){
		
		$errorsArray['email'][0] = true;
		$flag = true;
		
	}

	if(!checkContato($contato)){
		$errorsArray['contato'][0] = true;
		$flag = true;
	}
	

		}



}
if(!empty($_POST['Concluir'])){
	if($_POST['Nome']){
	 require_once('dbmanager.php');
	  $myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$query ="UPDATE utilizadores SET nome=\"".$_POST['Nome']."\" WHERE id_utilizadores = '$idUt'";
				$result = mysqli_query($myDb,$query);
						
			header('Location:edita.php');
			}

  }
  if($_POST['Contato']){
	 require_once('dbmanager.php');
	  $myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$query ="UPDATE utilizadores SET contato=\"".$_POST['Contato']."\" WHERE id_utilizadores = '$idUt'";
				$result = mysqli_query($myDb,$query);
						
			header('Location:edita.php');
			}

  }
  
  if($_POST['Morada']){
	 require_once('dbmanager.php');
	  $myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$query ="UPDATE utilizadores SET morada=\"".$_POST['Morada']."\" WHERE id_utilizadores = '$idUt'";
				$result = mysqli_query($myDb,$query);
						
			header('Location:edita.php');		
			}

  }
  if($_POST['Email']){
	 require_once('dbmanager.php');
	  $myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$query ="UPDATE utilizadores SET email=\"".$_POST['Email']."\" WHERE id_utilizadores = '$idUt'";
				$result = mysqli_query($myDb,$query);
						
			header('Location:logout.php');
			}

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
  <li class="active"><a href="editUser.php">Editar</a></li>
  <li><a href="about.asp">Sobre</a></li>
  <?
	if ($tipoUser ==1){
		echo '<li><a href="editProduto.php">Editar Produto</a></li>';
		echo '<li><a href="uploadProduto.php">Carregar Produto Novo</a></li>';
	}
  ?>
  <li><a href="logout.php">Logout</a></li>
</ul>
<form name ="myForm" action="" method="POST">
<table style="width:50%;">
<tr></tr>
  <tr>
    <th>Nome de usuário:<input name ="Nome" type="text" value="<?php

if(!empty($errorsArray)&& !$errorsArray['username'][0]){
	echo $username;
}

?>">
<?php
if(!empty($errorsArray) && $errorsArray['username'][0]){
		echo $errorsArray['username'][1].'<br/>';
		
}
?><br></th>
    <th>Contato:<input name ="Contato" type="text" value="<?php

if(!empty($errorsArray)&& !$errorsArray['contato'][0]){
	echo $contato;
}

?>"><br/>
<?php
if(!empty($errorsArray) && $errorsArray['contato'][0]){
		echo $errorsArray['contato'][1].'<br/>';
}
?></th> 
    <th>Morada:<input name ="Morada" type="text" value="<?php

if(!empty($errorsArray)&& !$errorsArray['morada'][0]){
	echo $morada;
}

?>"><br/>
<?php
if(!empty($errorsArray) && $errorsArray['morada'][0]){
		echo $errorsArray['morada'][1].'<br/>';
}
?></th>
	<th>Email:<input name ="Email" type="text" value="<?php

if(!empty($errorsArray)&& !$errorsArray['email'][0]){
	echo $email;
}

?>"><br/>
<?php
if(!empty($errorsArray) && $errorsArray['email'][0]){
		echo $errorsArray['email'][1].'<br/>';
}
?></th>
  </tr>
  <tr>
  <th><input type="submit" value="Nome" name="Concluir"></th>
  
  <th><input type="submit" value="Contato" name="Concluir"></th>
  
  <th><input type="submit" value="Morada" name="Concluir"></th>

  <th><input type="submit" value="Email" name="Concluir"></th>
  
  </tr>
  </table>
  <br><br>
  <input type="submit" value="Concluir" name="Concluir">
  </form>
  <a href="editarpass.php"><input type="submit" value="Deseja Alterar a Password?" name="Password"></a>
  </body>
  </html>