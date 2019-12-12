<?php

if(!empty($_POST)){
	
	$email1 = $_POST['email1'];
	$password = $_POST['password1'];
	
	require_once('checkForm.php');
	$email1 = cleanFields($email1);
	$password = cleanFields($password);
	
	$errorsArray = array('email1' => array (false,"Invalid email1</br>"),
						 'password1' => array (false,"Invalid Password</br>"),
						 'auth' => array(false,"Incorrect email1/password: please try again<br>")
						);
		
		$flag = false;
		
		
	if( !checkemail1($email1)){
		
		$errorsArray['email1'][0] = true;
		$flag = true;
		
	}
	if( !checkPass($minPass,$maxPass,$password)){
		
		$errorsArray['password1'][0] = true;
		$flag = true;
		
	}
	
						
if(!$flag){
	require_once('dbmanager.php');
	$myDb = ligarDb();
	if(!$myDb){
			echo "Something went wrong, please try again later.";
			die();
		}
	$password = md5($password);	
	$query = "SELECT * FROM users WHERE email='$email1' AND password='$password'";
	$result = mysqli_query($myDb,$query);
	
	if(!$result){
		echo "Something went a little wrong..";
		die();
	}
	elseif(mysqli_num_rows($result) == 1){
		session_start();
		$_SESSION['email1'] = $email1;
		header('Location:ok.php');
		die();
	}
	else{
		$errorsArray ['auth'][0] = true;
		$_POST = array();
	}
	
	}
}
?>
