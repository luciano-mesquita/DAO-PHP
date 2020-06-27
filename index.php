<?php

require_once("config.php");

$banco = new Banco();

$usuarios = $banco->select("SELECT * FROM usuario");

echo json_encode($usuarios);