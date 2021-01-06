<?php

$myDb = null;

function ligarDb()
{

    $hostname = 'Localhost';
    $username = 'alexandra';
    $password = 'cm';
    $dbName = 'Tp1';
    $myDb = mysqli_connect($hostname, $username, $password, $dbName);

    if (!$myDb) {
        return (false);
    } else {
        return ($myDb);
    }
}
