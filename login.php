<?php

    if (!empty($_POST)) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        require_once 'checkForm.php';
        $email = cleanFields($email);
        $password = cleanFields($password);
        $minName = 3;
        $maxName = 22;

        $minPass = 8;
        $maxPass = 42;

        $errorsArray = array('email' => array(false, 'Invalid email</br>'),
            'password' => array(false, 'Invalid Password</br>'),
            'auth' => array(false, 'Incorrect email/password: please try again<br>'),
        );

        $flag = false;

        if (!checkemail($email)) {

            $errorsArray['email'][0] = true;
            $flag = true;

        }
        if (!checkPass($minPass, $maxPass, $password)) {

            $errorsArray['password'][0] = true;
            $flag = true;

        }

        if (!$flag) {
            require_once 'dbmanager.php';
            $myDb = ligarDb();
            if (!$myDb) {
                echo 'Something went wrong, please try again later.';
                die();
            }
            $password = md5($password);
            $query = "SELECT * FROM utilizadores WHERE email='$email' AND password='$password'";
            $result = mysqli_query($myDb, $query);

            if (!$result) {
                echo 'Something went a little wrong..';
                die();
            } elseif (mysqli_num_rows($result) == 1) {
                session_start();
                $_SESSION['email'] = $email;
                header('Location:userauth.php');
                die();
            } else {
                $errorsArray['auth'][0] = true;
                $_POST = array();
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

<body>
<ul>
  <li><a href="index.php">Inicio</a></li>
  <li class="active"><a href="login.php">Login</a></li>
  <li><a href="formulario.php">Registar</a></li>
  <li><a href="about.asp">Sobre</a></li>
</ul>
<br>
<h3>Login</h3>
<?
if(!empty($errorsArray)&& $errorsArray['auth'][0]){
	echo $errorsArray['auth'][1];
}
?>
<form name="myForm" action="" method="post">

Email:<input name ="email" type="text" value="<?php

                                                  if (!empty($errorsArray) && !$errorsArray['email'][0]) {
                                                      echo $email;
                                                  }

                                              ?>"><br/>
<?php
    if (!empty($errorsArray) && $errorsArray['email'][0]) {
        echo $errorsArray['email'][1];
    }
?>
Password:<input name ="password" type="password">
<?php
    if (!empty($errorsArray) && $errorsArray['password'][0]) {
        echo $errorsArray['password'][1];
}
?><br/>
<input type="submit" value="login" action="logon.php" name="login">

</form>

</body>
</html>