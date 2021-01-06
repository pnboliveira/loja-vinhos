<!DOCTYPE html>
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
<h1 style="text-align:center;">LOJA DE VINHOS</h1>

<br>

<ul>
  <li class="active"><a href="index.php">Inicio</a></li>
  <li><a href="login.php">Login</a></li>
  <li><a href="formulario.php">Registar</a></li>
  <li><a href="about.asp">Sobre</a></li>
</ul>
<br>

<table>
  <?php
      require_once 'dbmanager.php';
      $myDb = ligarDB();
      if ($result = mysqli_query($myDb, 'SELECT * FROM vinhos')) {
          while ($row = mysqli_fetch_row($result)) {
              $id_vinho = $row[0];
              $nomeVinho = $row[1];
              $imgvinho = $row[2];
              $descvinho = $row[3];
              $tipoVinho = $row[4];
              $precovinho = $row[5];

              for ($i = 1; $i <= sizeof($id_vinho); $i++) {

                  echo '<tr>';
                  echo '<th><a href="ProdutoVer.php?id=' . $id_vinho . '">' . $nomeVinho . '</a></th>';
                  echo '<th><img height="300" src="' . $imgvinho . '"/></tr>';
                  echo '<th>' . $descvinho . '</th>';
                  switch ($tipoVinho) {
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
                  echo '<th>' . $tipoVinho . '</th>';
                  echo '<th> Preço=' . $precovinho . '€</th>';
                  echo '</tr>';
              }

          }
          die();
      }
  ?>
</table>


</body>
</html>