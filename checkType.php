<?

	if($result = mysqli_query($myDb,"SELECT tipo_user, id_utilizadores FROM utilizadores WHERE email='$email'")){
			while($row = mysqli_fetch_row($result)){

				$tipoUser = $row[0];
				$idutilizador = $row[1];

			}
		}


?>
