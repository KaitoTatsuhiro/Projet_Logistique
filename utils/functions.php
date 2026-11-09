<?php
//FONCTIONS UTILITAIRES

//Fonction de creation de l'objet pdo

function connect(){
    return new pdo("mysql:host={$_ENV['dbhost']};dbname={$_ENV['dbname']}", $_ENV['dblogin'], $_ENV['dbpassword'],[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}

function normalize(string $data){
    return trim($data);
}

function e(string $message){
    return htmlspecialchars($message);
}