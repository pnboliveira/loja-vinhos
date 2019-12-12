<?php

session_start();
session_destroy();

$_SESSION = $_POST = null;

header('Location: index.php');
exit;


?>