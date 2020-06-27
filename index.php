<?php

require_once("config.php");

// Lista apenas um usuário
//$usuario1 = new Usuario();
//$usuario1->loadById(5);
//echo $usuario1;

// Lista todos os usuários
//$lista = Usuario::getList();
//echo json_encode($lista);

// Carrega uma lista de usuário buscando pelo email
//$search = Usuario::search("ad");
//echo json_encode($search);

// Carrega um usuário usando o login e a senha
$usuario = new Usuario();
$usuario->login("admin@admin.com", "1234567890");

echo $usuario;