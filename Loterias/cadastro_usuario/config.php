<?php

define('BD_USER', 'USUARIO'); // USE O TEU USUÁRIO DE BANCO DE DADOS
define('BD_PASS', 'SENHA'); // USE A TUA SENHA DO BANCO DE DADOS
define('BD_NAME', 'NOME_BANCO_DE_DADOS'); // USE O NOME DO TEU BANCO DE DADOS

mysql_connect('localhost', BD_USER, BD_PASS);
mysql_select_db(BD_NAME);


?>