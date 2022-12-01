<?php
        session_start();
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

<html>

    <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <script>

            setInterval(() => {
                let id = "<?php if (isset($_SESSION['id'])){ echo $_SESSION['id'];};?>"
                console.log(+id)
                if (id != 0){
                    window.location.href = "http://localhost:8080/Spectrum/resultado.php"
                }
            }, 1500);
        
        </script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    </head>

    <body class="container d-flex align-items-center justify-content-center" style="background: #407070;">
        <form action="" method="post" enctype="multipart/form-data" class="border d-flex flex-column p-4" style="border-radius: 15px; background: gray;">
            <input type="file" name="file" class="mb-4">
            <input type="submit" name="acao" value="Enviar">
        </form>
    </body>

</html>