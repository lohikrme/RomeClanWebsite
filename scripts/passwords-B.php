<?php

function importDbNameAndPassword () {

    $databasePassword = "Tosivahvasalasana";
    $databaseUsername = "Parrot";

    // create an array so u can return password and username, because in php variables are not global
    $array = array();
    $array['name'] = $databaseUsername;
    $array['password'] = $databasePassword;

    return $array;
}
?>