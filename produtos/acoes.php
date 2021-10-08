<?php
    require("../database/conexao.php");
    switch ($_POST['acao']) {
        case 'inserir':
            
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
        
        default:
            # code...
            break;
    }

?>