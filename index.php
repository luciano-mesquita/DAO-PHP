<?php

// Carregando o arquivo de configuração
require_once("config.php");

// Criando um usuário
$usuario1 = new Usuario();

// Utilizando um método para carregar os dados do usuário
$usuario1->loadById(5);

// Exibindo os dados carregados
echo $usuario1;