<html>

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    </head>

    <body class="container d-flex align-items-center justify-content-center" style="background: #407070;">
        <div class="border d-flex flex-column align-items-center justify-content-center p-4 text-white" style="border-radius: 15px; background: gray; gap:20px;">
        <?php
            session_start();
            if (isset($_SESSION['id'])){
                $arquivo = './arquivos/resultados/'.$_SESSION['id'].'.txt';
                if (is_file($arquivo)){
                    $handle = fopen( $arquivo, 'r' );
                    $ler = fread($handle, 1000);
                    echo $ler;
                    fclose($handle);
                };
                session_destroy();
            };
        ?>
        <a href="http://localhost:8080/upload/" class="bg-white text-dark p-2 border">Voltar</a>
        </div>
    </body>

</html>