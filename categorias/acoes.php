<?php

session_start();

//CONEXÃO COM BANCO DE dados
require('../database/conexao.php');

//FUNÇÃO DE VALIDAÇÃO

function validaCampos(){

    $erros = [];

    if(!isset($_POST['descricao']) || empty($_POST['descricao'])){
        $erros[] = "O campo descrição é de preenchimento obrigatório";
    }

    return $erros;

}

//TRATAMENTO DOS DADOS VINDOS DO FORMULÁRIO

//-TIPO DA APLICAÇÃO
//- EXECUÇÃO DOS PROCESSOS DA AÇÃO SOLICITADA

switch ($_POST['acao']) {
    case 'inserir':

        //CHAMADA DA FUNÇÃO DE VALIDAÇÃO DE ERROS
        $erros = validaCampos();

        //VERIFICAR SE EXISTEM ERROS:
        if (count($erros) > 0) {
            $_SESSION['erros'] = $erros;

            header('location: index.php');

            die;

        }

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

        case 'deletar':

        $categoriaID = $_POST['categoriaId'];

        $sql = "DELETE FROM tbl_categoria WHERE id = $categoriaID";

        $resultado = mysqli_query($conexao, $sql);

        header('location: index.php');

        break;
    
    default:
    echo('fracasso');
        break;
}

die;

?>