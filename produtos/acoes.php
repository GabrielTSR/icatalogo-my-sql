<?php

session_start();
    require("../database/conexao.php");

    function validarCampos(){

        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';
        // exit;

        // foreach($_POST as $key => $value) {
        //     echo "indice ->" . $key . "VALR ->" . $value . "<br>";

        //     if($_POST["$key"] == '' || !isset($_POST["$key"])) {
        //         $upperKey = strtoupper($key);

        //         $erros[] = "O CAMPO $upp É OBRIGATÓRIO";
        //     }
        // }


        //ARRAY DAS MENSAGENS DE ERRO
        $erros = [];

        //VALIDAÇÃO DE DESCRIÇÃO
        if(trim($_POST['descricao']) == '' || !isset($_POST['descricao']) ) {
            $erros[] = "O CAMPO DESCRIÇÃO É OBRIGATÓRIO";
        }

        //VALIDAÇÃO DE PESO
        if( trim($_POST['peso']) == '' || !isset($_POST['peso']) ) {
            $erros[] = "O CAMPO PESO É OBRIGATÓRIO";
        } else if( !is_numeric( str_replace(",", ".", $_POST['peso'])) ){
            $erros[] = "O CAMPO PESO DEVE SER UM NÚMERO";
        }


        //VALIDAÇÃO DE QUANTIDADE
        if( trim($_POST['quantidade']) == '' || !isset($_POST['quantidade']) ) {
            $erros[] = "O CAMPO QUANTIDADE É OBRIGATÓRIO";
        } else if( !is_numeric( str_replace(",", ".", $_POST['quantidade'])) ){
            $erros[] = "O CAMPO QUANTIDADE DEVE SER UM NÚMERO";
        }

        //VALIDAÇÃO DE COR
        if( trim($_POST['cor']) == '' || !isset($_POST['cor']) ) {
            $erros[] = "O CAMPO COR É OBRIGATÓRIO";
        }

        //VALIDAÇÃO DE TAMANHO
        if( trim($_POST['tamanho']) == '' || !isset($_POST['tamanho']) ) {
            $erros[] = "O CAMPO TAMANHO É OBRIGATÓRIO";
        }

        //VALIDAÇÃO DE VALOR
        if( trim($_POST['valor']) == '' || !isset($_POST['valor']) ) {
            $erros[] = "O CAMPO VALOR É OBRIGATÓRIO";
        } else if( !is_numeric( str_replace(",", ".", $_POST['valor'])) ){
            $erros[] = "O CAMPO VALOR DEVE SER UM NÚMERO";
        }

        //VALIDAÇÃO DE DESCONTO
        if( trim($_POST['desconto']) == '' || !isset($_POST['desconto']) ) {
            $erros[] = "O CAMPO DESCONTO É OBRIGATÓRIO";
        } else if( !is_numeric( str_replace(",", ".", $_POST['desconto'])) ){
            $erros[] = "O CAMPO DESCONTO DEVE SER UM NÚMERO";
        }

        //VALIDAÇÃO DE CATEGORIA
        if( trim($_POST['categoria']) == '' || !isset($_POST['categoria']) ) {
            $erros[] = "O CAMPO CATEGORIA É OBRIGATÓRIO";
        } else if( !is_numeric( str_replace(",", ".", $_POST['categoria'])) ){
            $erros[] = "O CAMPO CATEGORIA DEVE SER UM NÚMERO";
        }

        //VALIDAÇÃO DA IMAGEM
        if($_FILES["foto"]["error"] == UPLOAD_ERR_NO_FILE){
            $erros[] = "O ARQUIVO PRECISA SER UMA IMAGEM";
        } else {

            $imagemInfos = getimagesize($_FILES["foto"]["tmp"]);

            if($_FILES["foto"]["size"] > 1024 * 1024 * 2) {
                $erros[] = "O ARQUIVO NÃO PODE SER MAIS QUE 2MB";
            }

            $width = $imagemInfos[0];
            $height = $imagemInfos[1];

            if($width != $height){
                $erros[] = "A IMAGEM PRECISA SER QUADRADA";
            }
        }

        return $erros;

    }

    switch ($_POST['acao']) {
        case 'inserir':

            $erros = validarCampos();

            if(count($erros) > 0){
                $_SESSION["erros"] = $erros;

                header("location: ./novo/index.php");

                exit;
            }
            
            //TRATAMENTO DA IMAGEM PARA UPLOAD:

            //RECUPERA O NOME DO ARQUIVO
            $nomeArquivo = $_FILES["foto"]["name"];

            //RECUPERA A EXTENSÃO DO ARQUIVO
            $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

            //DEFINIR UM NOVO NOME PARA O ARQUIVO DE IMAGEM
            $novoNome = md5(microtime()) . "." . $extensao;

            //echo $novoNome;

            //UPLOAD DO ARQUIVO:
            move_uploaded_file($_FILES['foto']['tmp_name'], "fotos/$novoNome");

            //INSER
            $descricao = $_POST['descricao'];
            $peso = $_POST['peso'];
            $quantidade = $_POST['quantidade'];
            $cor = $_POST['cor'];
            $tamanho = $_POST['tamanho'];
            $valor = $_POST['valor'];
            $desconto = $_POST['desconto'];
            $categoriaId = $_POST['categoria'];

            // echo $descricao . '<br>';
            // echo $peso . '<br>';
            // echo $quantidade . '<br>';
            // echo $cor . '<br>';
            // echo $tamanho . '<br>';
            // echo $valor . '<br>';
            // echo $desconto . '<br>';
            // echo $categoriaId;
            // exit;

            //CRIAÇÃO DA INSTRUÇÃO SQL DE INSERÇÃO:
            $sql = "INSERT INTO tbl_produto
            (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id)
            VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, $desconto, '$novoNome', $categoriaId)";

            //EXECUÇÃO DO SQL DE INSERÇÃO:
            $resultado = mysqli_query($conexao, $sql);
            //var_dump($sql);
            //var_dump($resultado);

            //REDIRECIONAR PARA A INDEX
            header('location: index.php');

            break;


        case 'deletar':

            $id = $_POST['produtoId'];

            $sql = "SELECT imagem FROM tbl_produto WHERE id=$id";

            $resultado = mysqli_query($conexao, $sql);

            $imagemSelecionada = mysqli_fetch_array($resultado);

            $nomeDaImagem = $imagemSelecionada['imagem'];

            unlink("fotos/$nomeDaImagem");

            $sql = "DELETE from tbl_produto WHERE id=$id";

            $resultado = mysqli_query($conexao, $sql);

            header('location: index.php');

            break;
        
        default:
            # code...
            break;
    }

?>