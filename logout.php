<?php
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Destrói a sessão
session_destroy();

// Redireciona para a página inicial
header("Location: index.php");
exit();
?>