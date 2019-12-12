<?php
error_reporting(E_ALL || E_NOTICE);
session_start();
require_once('dbmanager.php');
//verificar se tem sessão iniciada
if(empty($_SESSION) || !array_key_exists('email',$_SESSION) || !isset($_SESSION['email'])){
	
	$_SESSION['error'] = array ('source' => 'contato.php','type' => 'No Permissions');
	header('Location:index.php');
	die();	
}else{
	
if(!empty($_POST)){
	
	$email = $_SESSION['email'];
		
		
		$myDb = ligarDb();
		
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

	$oldpassword = $_POST['oldpassword'];
	$password = $_POST['password'];
	$rpassword = $_POST['rpassword'];
	
	require_once('checkForm.php');
	
	$oldpassword = cleanFields($oldpassword);
	$password = cleanFields($password);
	$rpassword = cleanFields($rpassword);
	
	$minpass=8;
	$maxpass=42;

	


	
	$errorsArray = array('oldpassword' => array (false,"A password não é igual à password anterior. Tente novamente.<br>"),
						'password' => array (false,"A password apenas pode conter caracteres UTF-8 e -_.<br>"),
						 'rpassword' => array (false,"Passwords do not match.</br>")
						);
	
	$flag = false;
	
	if(md5($oldpassword) != $passUt){
		
		$errorsArray['oldpassword'][0] = true;
		$flag = true;
	}
	
	if(!checkPass($minpass,$maxpass,$password)){
		
		$errorsArray['password'][0] = true;
		$flag = true;
		
	}
	
	if($password != $rpassword){
		
		$errorsArray['rpassword'][0] = true;
		$flag = true;
	}
	

		}


if(!$flag){
		$myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$query ="UPDATE utilizadores SET password=\"".md5($password)."\" WHERE id_utilizadores = '$idUt'";
				$result = mysqli_query($myDb,$query);
						
			header('Location:editUser.php');
					die();		
			}
			

	}
	}
}

?>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Editar Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	
</head>

<body>
<ul>
  <li><a href="userauth.php">Inicio</a></li>
  <li><a href="">Produtos</a></li>
  <li><a href="contato.php">Contato</a></li>
  <li class="active"><a href="editUser.php">Editar</a></li>
  <li><a href="about.asp">Sobre</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>
<form name ="myForm" action="" method="POST">
<table style="width:50%;">
<tr></tr>
  <tr>
	
    <th>Password Antiga:<input name ="oldpassword" type="password" ><br/>
	<?php
if(!empty($errorsArray) && $errorsArray['oldpassword'][0]){
		echo $errorsArray['oldpassword'][1];
}
?></th>
    <th>Nova Password:<input name ="password" type="password"><br/>
	<?php
if(!empty($errorsArray) && $errorsArray['password'][0]){
		echo $errorsArray['password'][1];
}
?></th> 
	
    <th>Repetir Password:<input name ="rpassword" type="password"><br/>
	<?php
if(!empty($errorsArray) && $errorsArray['rpassword'][0]){
		echo $errorsArray['rpassword'][1];
}
?></th> </th>
  </tr>
  </table>
  <br><br>
  <input type="submit" value="Concluir" name="Concluir">
  </form>
  <a href="#"><input type="submit" value="Deseja Alterar a Password?" name="Password"></a>
  </body>
  </html>