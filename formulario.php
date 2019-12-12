<?php

if(!empty($_POST)){

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$rpassword = $_POST['rpassword'];
	$contato = $_POST['contato'];
	$morada = $_POST['morada'];
	
	require_once('checkForm.php');
	$username = cleanFields($username);
	$email = cleanFields($email);
	$password = cleanFields($password);
	$rpassword = cleanFields($rpassword);
	$contato = cleanFields($contato);
	$morada = cleanFields($morada);
	
	$minusername = 3;
	$maxusername = 22;
	
	$minpass=8;
	$maxpass=42;

	
	$errorsArray = array('username' => array (false,"O username deve ter entre $minusername e $maxusername caracteres.</br>"),
						 'email' => array (false,"O email não é válido</br>"),
						 'password' => array (false,"A password apenas pode conter caracteres UTF-8 e -_.<br>"),
						 'rpassword' => array (false,"Passwords do not match.</br>"),
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
	if( !checkPass($minpass,$maxpass,$password)){
		
		$errorsArray['password'][0] = true;
		$flag = true;
		
	}elseif($password != $rpassword){
		
		$errorsArray['rpassword'][0] = true;
		$flag = true;
	}
	
	if(!checkContato($contato)){
		$errorsArray['contato'][0] = true;
		$flag = true;
	}
	
	if(!$flag){
		
		$myDb = mysqli_connect('localhost','alexandra','cm','Tp1');
		
		if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$password = md5($password);
				$query ="INSERT INTO utilizadores(nome, email, password, contato, morada) VALUES('$username','$email','$password','$contato','$morada')";
				$result = mysqli_query($myDb,$query);
						
			header('Location:login.php');
					die();		
			}
			

	}
}

?>
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


<Body>

<ul>
  <li><a href="index.php">Inicio</a></li>
  <li><a href="login.php">Login</a></li>
  <li><a href="loja.php">Produtos</a></li>
  <li><a href="contato.php">Contato</a></li>
  <li class="active"><a href="formulario.php">Registar</a></li>
  <li><a href="about.asp">Sobre</a></li>
</ul>

<br>
<h3>Registe-se!</h3>
<form name ="myForm" action="" method="POST">

Nome de usuário:<input name ="username" type="text" value="<?php

if(!empty($errorsArray)&& !$errorsArray['username'][0]){
	echo $username;
}

?>">
<?php
if(!empty($errorsArray) && $errorsArray['username'][0]){
		echo $errorsArray['username'][1].'<br/>';
		
}
?><br>




Email:<input name ="email" type="text" value="<?php

if(!empty($errorsArray)&& !$errorsArray['email'][0]){
	echo $email;
}

?>"><br/>
<?php
if(!empty($errorsArray) && $errorsArray['email'][0]){
		echo $errorsArray['email'][1].'<br/>';
}
?>


Password:<input name ="password" type="password"><br>
<?php
if(!empty($errorsArray) && $errorsArray['password'][0]){
		if( !checkPass($minpass,$maxpass,$password)){echo $errorsArray['password'][1].'<br/>';}
}
?>

R.Password:<input name ="rpassword" type="password">
<?php
if(!empty($errorsArray) && $errorsArray['rpassword'][0]){
		echo $errorsArray['rpassword'][1].'<br/>';
}
?><br/>




Contato:<input name ="contato" type="text" value="<?php

if(!empty($errorsArray)&& !$errorsArray['contato'][0]){
	echo $contato;
}

?>"><br/>
<?php
if(!empty($errorsArray) && $errorsArray['contato'][0]){
		echo $errorsArray['contato'][1].'<br/>';
}
?>




Morada:<input name ="morada" type="text" value="<?php

if(!empty($errorsArray)&& !$errorsArray['morada'][0]){
	echo $morada;
}

?>"><br/>
<?php
if(!empty($errorsArray) && $errorsArray['morada'][0]){
		echo $errorsArray['morada'][1].'<br/>';
}
?>
<input type="submit" value="registar" name="register">
</form>


</Body>
</html>