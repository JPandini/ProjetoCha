<?php
    //conectar ao servidor         
    $conectar = mysql_connect('localhost','root','');        //nome e senha da conta -> na satc nome é root e não tem senha
    //conectar ao banco
    $banco  = mysql_select_db('cha');

    $sql_marca       = "SELECT codigo, nome FROM marca ";
    $pesquisar_marca = mysql_query($sql_marca);

    $sql_produto       = "SELECT codigo, nome FROM produto ";
    $pesquisar_produto = mysql_query($sql_produto);


?>



    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
    <form name="formulario" method="post" action="index.php" enctype="multipart/form-data">
        <h1>Cadastro</h1>
        Codigo:<br>
        <input type="text" name="codigo" id="codigo" size=30><br><br>
        Data:
        <input type="date" name="data" id="data" size=30>
        Hora:
        <input type="time" name="hora" id="hora" size=30><br><br>
        Cod região:
        <select name="codmarca" id="codmarca">
        <option value=0>Selecionar marca</option>
            <?php
            if(mysql_num_rows($pesquisar_marca) <> 0)
            {
                while($marca = mysql_fetch_array($pesquisar_marca))
                {
                echo '<option value="'.$marca['codigo'].'">'.
                                        $marca['nome'].'</option>';
                }
            }
            ?>
        </select>
        Cod produto:
        <select name="codproduto" id="codproduto">
        <option value=0>Selecionar produtos</option>
            <?php
            if(mysql_num_rows($pesquisar_produto) <> 0)
            {
                while($produto = mysql_fetch_array($pesquisar_produto))
                {
                echo '<option value="'.$produto['codigo'].'">',
                                        $produto['nome'].'</option>';
                }
            }
            ?>
        </select>
        
            ?>
        </select><br><br>
        codigo:<br>
        <input type="text" name="chamada" id="chamada" size=30><br><br>
        Resumo:<br>
        <input type="text" name="resumo" id="resumo" size=30><br><br>
        Materia:<br>
        <textarea type="textarea" name="materia" id="materia" rows="5" cols="50"></textarea><br><br>
        Fotochamada:<br>
        <input type="file" name="fotochamada" id="fotochamada" size=30><br><br>
        Foto1:<br>
        <input type="file" name="foto1" id="foto1" size=50><br><br>
        Foto2:<br>
        <input type="file" name="foto2" id="foto2" size=30>
        <br><br>
        <input type="submit" name="gravar" id="gravar" value="Gravar">
        <input type="submit" name="alterar" id="alterar" value="Alterar">
        <input type="submit" name="excluir" id="excluir" value="Excluir">
        <input type="submit" name="pesquisar" id="pesquisar" value="Pesquisar"><br><br>
    </body>
    </html>




<?php
    //se escolher a opção GRAVAR
    if (isset($_POST['gravar']))
    {
        //receber as variaveis do HTML
        $codigo       = $_POST['codigo'];
        $hora         = $_POST['hora'];
        $data         = $_POST['data'];
        $codregiao    = $_POST['codregiao'];
        $codcategoria = $_POST['codcategoria'];
        $codcolunista = $_POST['codcolunista'];
        $chamada      = $_POST['chamada'];
        $resumo       = $_POST['resumo'];
        $materia      = $_POST['materia'];
        $fotochamada  = $_FILES['fotochamada'];
        $foto1        = $_FILES['foto1'];
        $foto2        = $_FILES['foto2'];     //gerar senha criptografada

//---------------------------------------------------------------------------------

        $pasta = "Fotos/";   //pasta para guardar as fotos

        if(!file_exists($pasta))
        {
            mkdir($pasta);              //se a pasta fotos nao existe, criar
        }

        $foto1_nome = $fotochamada["name"];
        $foto2_nome = $foto1["name"];    //pega nome arquivo da foto
        $foto3_nome = $foto2["name"];
       
        move_uploaded_file($fotochamada["tmp_name"], $foto1_nome);
        move_uploaded_file($foto1["tmp_name"], $foto2_nome);   //move a foto para a pasta
        move_uploaded_file($foto2["tmp_name"], $foto3_nome);

//---------------------------------------------------------------------------------

        //comando HTML para gravar banco
        $sql = "insert into material (codigo,hora,data,codregiao,codcategoria,codcolunista,chamada,resumo,materia,fotochamada,foto1,foto2) 
                values('$codigo','$hora','$data','$codregiao','$codcategoria','$codcolunista','$chamada','$resumo','$materia','$foto1_nome','$foto2_nome','$foto3_nome')";

        //execultar o comando SL no banco de dados
        $resultado = mysql_query($sql);

        //verificar se gravou (sem erro))
        if ($resultado)
        {   
            echo"Dados gravados com sucesso";
        }
            
        else
        {   
            echo"Erro ao gravar";
        }

    }

    //se escolher a opção ALTERAR
    if (isset($_POST["alterar"]))
    {
        //receber as variaveis do HTML
        $codigo       = $_POST['codigo'];
        $hora         = $_POST['hora'];
        $data         = $_POST['data'];
        $codregiao    = $_POST['codregiao'];
        $codcategoria = $_POST['codcategoria'];
        $codcolunista = $_POST['codcolunista'];
        $chamada      = $_POST['chamada'];
        $resumo       = $_POST['resumo'];
        $materia      = $_POST['materia'];
        $fotochamada  = $_POST['fotochamada'];
        $foto1        = $_POST['foto1'];
        $foto2        = $_POST['foto2']; 

        //comando HTML para gravar banco
        $sql = "update material set nome = '$nome'
                where codigo = '$codigo'";

        //execultar o comando SL no banco de dados
        $resultado = mysql_query($sql);

        //verificar se gravou (sem erro))
        if ($resultado)
        {   
            echo"Dados gravados com sucesso";
        }
            
        else
        {   
            echo"Erro ao alterar";
        }
    }

    //se escolher a opção Excluir
    if (isset($_POST['excluir']))
    {
        //receber as variaveis do HTML
        $codigo       = $_POST['codigo'];
        $hora         = $_POST['hora'];
        $data         = $_POST['data'];
        $codregiao    = $_POST['codregiao'];
        $codcategoria = $_POST['codcategoria'];
        $codcolunista = $_POST['codcolunista'];
        $chamada      = $_POST['chamada'];
        $resumo       = $_POST['resumo'];
        $materia       = $_POST['materia'];
        $fotochamada  = $_POST['fotochamada'];
        $foto1        = $_POST['foto1'];
        $foto2        = $_POST['foto2']; 
            
        $sql    = "delete from material where codigo = '$codigo'";

        $resultado = mysql_query($sql);
        if ($resultado)
        {
            echo "Dados excluidos com sucesso";
        }
        else
        {
            echo "Erro ao excluir";
        }
    }

    //se escolher a opção PESQUISAR
    if (isset($_POST['pesquisar']))
    {
        $sql = "select * from material";

        $resultado = mysql_query($sql);

        if (mysql_num_rows($resultado) == 0){
            echo"Sem resultado";
        }
        else
        {
            echo "Resultado: "."<br>";
            while($material = mysql_fetch_array($resultado))
            {
                echo "Titulo: ".$material['chamada']."<br>".
                    "Resumo: ".$material['resumo']."<br>".
                    "Fotos: "."<br>".
                    utf8_encode('<img src="Fotos/'.$material['fotochamada'].'"  height="100" width="150" />')."<br><hr>";
            }
        }
    }
?>