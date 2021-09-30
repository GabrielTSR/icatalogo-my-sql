<?php

//CONEXÃO COM BANCO DE dados
require('../database/conexao.php');

//TRATAMENTO DOS DADOS VINDOS DO FORMULÁRIO

//-TIPO DA APLICAÇÃO
//- EXECUÇÃO DOS PROCESSOS DA AÇÃO SOLICITADA

switch ($_POST['acao']) {
    case 'inserir':

        // echo'INSERIR:';

        $descricao = $_POST['descricao'];

        //CONTAGEM DA INSTRUÇÃO SQL DE INSERÇÃO DE DADOS

        $sql = "INSERT INTO tbl_categoria (descricao) VALUES ('$descricao')";

        header('location: ./index.php');

        // echo $sql; exit;
        /*mysql_query parametros
        1 - Uma conexão aberta e válida.
        2 - Uma instrução sql válida
        */
        $resultado = mysqli_query($conexao, $sql);

        echo'<pre>';
            var_dump($resultado);
        echo'</pre>';

        break;
    
    default:
    echo('fracasso');
        break;
}

die;

?>