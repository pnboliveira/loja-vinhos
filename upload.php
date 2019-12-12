<?php
$target_dir = "imagens/";
$target_file = $target_dir . basename($_FILES["imagem"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["upload"])) {
	$nomevinho = $_POST['nomevinho'];
	$descvinho = $_POST['descvinho'];
	$tipovinho = $_POST['tipovinho'];
	$preco = $_POST['preco'];
	switch($tipovinho){
		case 'Tinto':
			$tipovinho = 1;
			break;
		case 'Porto':
			$tipovinho = 2;
			break;
		case 'Favaios':
			$tipovinho = 3;
			break;
		case 'Verde':
			$tipovinho = 4;
			break;
		case 'Rosé':
			$tipovinho = 5;
			break;
	}
	
	require_once('dbmanager.php');
	$myDb = ligarDb();
	
	if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}else{
			$imagemData = addslashes(file_get_contents($_FILES['imagem']['tmp_name']));
			$imagemProps = getimageSize($_FILES['imagem']['tmp_name']);
			$query ="INSERT INTO vinhos(nome_vinho, descricao, tipo, imagem_vinho, preco) VALUES('$nomevinho','$descvinho','$tipovinho','".$imagemData."','$preco')";
			$result = mysqli_query($myDb,$query);
			header('Location:editProduto.php');
			die();		
		}
    $check = getimagesize($_FILES["imagem"]["tmp_name"]);
    if($check != false) {
        echo "O ficheiro é uma imagem - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "O ficheiro não é uma imagem.";
        $uploadOk = 0;
    }
}

if(!empty($_POST["update"])) {
	
	$nomevinho = $_POST['nomevinho'];
	$descvinho = $_POST['descvinho'];
	$tipovinho = $_POST['tipovinho'];
	$preco = $_POST['preco'];
	$id= $_GET['id'];
	switch($tipovinho){
		case 'Tinto':
			$tipovinho = 1;
			break;
		case 'Porto':
			$tipovinho = 2;
			break;
		case 'Favaios':
			$tipovinho = 3;
			break;
		case 'Verde':
			$tipovinho = 4;
			break;
		case 'Rosé':
			$tipovinho = 5;
			break;
	}
	
	if($_POST['nomevinho']){
	 require_once('dbmanager.php');
	  $myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$query ="UPDATE vinhos SET nome_vinho=\"".$_POST['nomevinho']."\" WHERE id_vinho = '$id'";
				$result = mysqli_query($myDb,$query);
						
			header('Location:editProduto.php');
			}

  }
  if($_POST['descvinho']){
	 require_once('dbmanager.php');
	  $myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$query ="UPDATE vinhos SET descricao=\"".$_POST['descvinho']."\" WHERE id_vinho = '$id'";
				$result = mysqli_query($myDb,$query);
						
			header('Location:editProduto.php');
			}

  }
  
  if($_POST['tipovinho']){
	 require_once('dbmanager.php');
	  $myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$query ="UPDATE vinhos SET tipo=\"".$_POST['tipovinho']."\" WHERE id_vinho= '$id'";
				
				
				$result = mysqli_query($myDb,$query);
						
			header('Location:editProduto.php');		
			}

  }
  if($_POST['preco']){
	 require_once('dbmanager.php');
	  $myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$query ="UPDATE vinhos SET preco=\"".$_POST['preco']."\" WHERE id_vinho = '$id'";
				$result = mysqli_query($myDb,$query);
			header('Location:editProduto.php');
			}

  }
  if($_POST['preco']){
	 require_once('dbmanager.php');
	  $myDb = ligarDb();
	  if(!$myDb){
			echo 'Something went wrong! Please try again later...';
			die();
		}
			else{
				$imagemData = addslashes(file_get_contents($_FILES['imagem']['tmp_name']));
				$imagemProps = getimageSize($_FILES['imagem']['tmp_name']);
				$query ="UPDATE vinhos SET imagem=\"".$imagemData."\" WHERE id_vinho = '$id'";
				$result = mysqli_query($myDb,$query);
			header('Location:editProduto.php');
			}

  }
		
    $check = getimagesize($_FILES["imagem"]["tmp_name"]);
    if($check != false) {
        echo "O ficheiro é uma imagem - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "O ficheiro não é uma imagem.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Erro. O ficheiro já existe.";
    $uploadOk = 0;
}


// Check file size
if ($_FILES["imagem"]["size"] > 500000) {
    echo "Erro. O ficheiro é demasiado grande.";
    $uploadOk = 0;
}


// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Erro, apenas ficheiros JPG, JPEG, PNG e GIF são permitidos.";
    $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Erro. O ficheiro não foi carregado.";
	
	
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
        echo "O ficheiro ". basename( $_FILES["imagem"]["name"]). " foi carregado.";
    } else {
        echo "Erro. Houve um erro, o ficheiro não carregado.";
    }
}
?>