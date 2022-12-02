<?php
    session_start();
    $extensao = '';
    if(isset($_POST['acao'])){
        $dbHost = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'autista';
    
        $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
                
        $sql = 'Select Max(Postagem) from n_total';
        $result = $conexao->query($sql);
        $result = mysqli_fetch_assoc($result);
        $new = $result['Max(Postagem)'] + 1;

        if(empty($result['Max(Postagem)'])){
            $sql = 'INSERT INTO n_total VALUES (1)';
        }else{
            $sql = "INSERT INTO n_total VALUES ($new)";
        };

        $result = $conexao->query($sql);
               
        $arquivo = $_FILES['file'];
        $extensao = explode('.',$arquivo['name'])[1];
                
        move_uploaded_file($arquivo['tmp_name'],'./arquivos/a fazer/'.$new.'.'.$extensao);

        $_SESSION['id'] = $new;
        $_SESSION['ext'] = $extensao;
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style-w-h.css">
    <style>
        .br-15{
            border-radius: 15px;
        }
    </style>
</head>
<body class="p-4 d-flex" style="height: 100vh; background-color: #212121;">
    <div class="w-100 d-flex align-items-center justify-content-center">
        <div class="p-4 d-flex flex-column align-items-center border br-15 text-light" style="background-color: #616161; width: 400px;">
            <h1 class="display-4">Spectrum</h1>
            <small id="noticiar" class="text-center"></small>
            <form action="" method="post" enctype="multipart/form-data" id="formulario" class="mt-4 mb-2">
                <label for="file" class="btn br-15 text-light" style="background-color: #424242;">Selecionar imagem</label>
                <input type="file" name="file" id="file" class="d-none" required>
                <label for="acao" class="btn br-15 text-light" style="background-color: #424242;" onclick="verificar()" >Enviar</label>
                <input type="submit" name="acao" id="acao" class="d-none">
            </form>
        </div>
    </div>
    <script>

        let id = "<?php if (isset($_SESSION['id'])){ echo $_SESSION['id'];};?>"
        let extensao = "<?php if (isset($_SESSION['id'])){ echo $extensao;};?>"

        if(extensao != 'png' && extensao != 'jpg' && extensao != 'jfif' && extensao != ''){
            document.getElementById('noticiar').innerHTML = 'Formato de arquivo não suportado ou nome do arquivo contém um ponto'
        }else{
            if(id != 0){
                document.getElementById('noticiar').innerHTML = 'Sua imagem está em processamento'
                setTimeout(()=>{window.location.href = "http://localhost:80/Spectrum/resultado.php"},3000) 
            }
        }

        function verificar(){
            let arquivo = document.getElementById('file').files.length
        
            if(arquivo == 0){
                document.getElementById('noticiar').innerHTML = 'Nenhum arquivo selecionado' 
            }else{
                document.getElementById('acao').submit()
            }
        }

        

    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>