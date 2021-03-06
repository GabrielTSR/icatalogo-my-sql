<?php
session_start();

require('../../database/conexao.php');

if (isset($_POST['acao'])){

    $acao = $_POST['acao'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
        
        
    switch ($acao) {
        case 'login':
            
            realizarLogin($usuario, $senha, $conexao);
            break;


        case 'logout':
            session_destroy();
            break;

        
        default:
            # code...
            break;
    }
}

header("Location: ../../produtos");

function realizarLogin($usuario, $senha, $conexao) {
    $sql = "SELECT * FROM tbl_administrador WHERE usuario = '$usuario'";

    $resultado = mysqli_query($conexao, $sql);

    $dadosUsuario = mysqli_fetch_array($resultado);

    if (isset($dadosUsuario['usuario']) && isset($dadosUsuario['senha']) && password_verify($senha, $dadosUsuario['senha'])) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['id'] = session_id();
        $_SESSION['data_hora'] = date('d/m/Y - h:i:s');
        $_SESSION["usuarioId"] = $dadosUsuario['id'];
    } else {
        session_destroy();
    }
}