<?php

    if (!empty($_POST)) {

        $userusername = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rpassword = $_POST['rpassword'];
        $contato = $_POST['contato'];
        $morada = $_POST['morada'];

        require_once 'checkForm.php';
        $username = cleanFields($username);
        $email = cleanFields($email);
        $password = cleanFields($password);
        $rpassword = cleanFields($rpassword);
        $contato = cleanFields($contato);
        $morada = cleanFields($morada);

        $errorsArray = array('username' => array(false, "O username deve ter entre $minusername e $maxusername caracteres.</br>"),
            'email' => array(false, 'Invalid Email</br>'),
            'password' => array(false, 'A password apenas pode conter caracteres UTF-8 e -_.<br>'),
            'rpassword' => array(false, 'Passwords do not match.</br>'),
            'contato' => array(false, 'O contato inserido não é válido.<br>'),
            'morada' => array(false, 'A morada inserida não é válida.<br>'),
        );

        $flag = false;

        if (!checkStringAndLength($minusername, $maxusername, $username)) {

            $errorsArray['username'][0] = true;
            $flag = true;

        }
        if (!checkEmail($email)) {

            $errorsArray['email'][0] = true;
            $flag = true;

        }
        if (!checkPass($password)) {

            $errorsArray['password'][0] = true;
            $flag = true;

        }
        if (!checkPassLength($minPass, $maxPass, $password)) {

            $errorsArray['password'][0] = true;
            $flag = true;

        }

        if ($password != $rpassword) {

            $errorsArray['rpassword'][0] = true;
            $flag = true;
        }

        if (!checkContato($contato)) {
            $errorsArray['contat'][0] = true;
            $flag = true;
        }

        if (!$flag) {

            $myDb = mysqli_connect('localhost', 'alexandra', 'cm', 'aulas');
            if (!$myDb) {
                echo 'Something went wrong! Please try again later...';
                die();
            } else {
                $password = md5($password);
                $query = "INSERT INTO users(nome, email, password, contato, morada) VALUES('$username','$email','$password')";
                $result = mysqli_query($myDb, $query);

                header('Location:ok.php');
                die();
            }

        }
    }
?>
<html>

<header>
<meta charset="utf-8" />
</header>

<Body>

<form name ="myForm" action="" method="POST">

Nome de usuário:<input name ="username" type="text" value="<?php

                                                                if (!empty($errorsArray) && !$errorsArray['username'][0]) {
                                                                    echo $username;
                                                                }

                                                            ?>"><br/>
<?php
    if (!empty($errorsArray) && $errorsArray['username'][0]) {
        echo $errorsArray['username'][1];
    }
?>
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
        if (!checkPass($password)) {echo $errorsArray['password'][1];}
}
?><br/>
R.Password:<input name ="rpassword" type="password">
<?php
    if (!empty($errorsArray) && $errorsArray['rpassword'][0]) {
        echo $errorsArray['rpassword'][1];
}
?><br/>
Contato:<input name ="contato" type="text">
<?php
    if (!empty($errorsArray) && $errorsArray['contato'][0]) {
        echo $errorsArray['contato'][1];
}
?><br/>
<input type="submit" value="submit">

</form>

</Body>
</html>