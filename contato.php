<?php
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

        if (!empty($_POST)) {
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            $errorsArray = array(
                'email' => array(false, 'Email must have a valid addresss.<br/>'),

            );

            require_once 'checkForm.php';
            $flag = false;

            if (!checkEmail($email)) {
                $errorsArray['email'][0] = true;
                $flag = true;
            }

            if (!$flag) {
                $header = "MIME-Version: \r\n";
                $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $header .= "From: \"$email\" <$email>\r\n";
                mail('incole0369@gmail.com', $subject, $message, $header);
                header('location:ok1.php');
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
	<body>
	<div style="text-align:center;">
	<ul>
<ul>
  <li><a href="userauth.php">Inicio</a></li>
  <li><a href="loja.php">Produtos</a></li>
  <li class="active"><a href="contato.php">Contato</a></li>
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
</ul>
<br>
<h2>Têm alguma dúvida? Contacte-nos!</h2>
<br>

		<form name ="myForm" action="" method="POST">
		Email:<input name="email" type="text"value="<?php
                                                        if (!empty($errorsArray) && !$errorsArray['email'][0]) {
                                                            echo $email;
                                                    }
                                                    ?>"><br/>
		<?php
            if (!empty($errorsArray) && $errorsArray['email'][0]) {
                echo $errorsArray['email'][1];
            }
        ?>
		Assunto:<input name="subject" type="text" value=""><br/>
		Mensagem: <input name="message" type="textarea" value=""><br/>

		<input type="submit" value="submit">
		</form>
		</div>
	</body>
</html>