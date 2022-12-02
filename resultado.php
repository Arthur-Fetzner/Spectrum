<?php
            session_start();
            $arq = '';
            $pred = 'vazio';
            if (isset($_SESSION['id'])){
                $arquivo = './arquivos/resultados/'.$_SESSION['id'].'.txt';
                if (is_file($arquivo)){
                    $arq = './arquivos/feitos/'.$_SESSION['id'].'.'.$_SESSION['ext'];
                    $handle = fopen( $arquivo, 'r' );
                    $ler = fread($handle, 1000);
                    $pred = json_encode($ler);
                    fclose($handle);
                    session_destroy();
                }else{
				session_destroy();
                    echo"Seu arquivo está em processamento, recarrege a pagina";
                };
            };
        ?>

<html>

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    </head>

    <body class="container d-flex align-items-center justify-content-center" style="background: #407070;">
        <div class="border w-50 d-flex flex-column align-items-center justify-content-center p-4 text-white" style="border-radius: 15px; background: gray; gap:20px;">
        <h3 id="escrever"></h3>
        <canvas id="Canvas" class="w-100"></canvas>
        <a href="https://3db9-2804-14d-4c84-8e1d-2814-3eee-9d68-dc59.sa.ngrok.io/Spectrum/" class="bg-white text-dark p-2 border">Voltar</a>
        </div>
    </body>
    <script>
        let arq = '<?php echo"$arq"; ?>';
        if(arq != ''){
            let canvas = document.getElementById('Canvas');
            let ctx= canvas.getContext('2d');
            let img = new Image();
            img.src = arq;
            img.onload=()=>{
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                //ctx.fillRect(0, 0, 100, 100);
            };
            
            let pred = <?php echo $pred; ?>;
            if (pred != 'vazio'){
                pred = pred.replace(/["]/g, '');
                console.log(pred);
                let pred_array = pred.split("/");
                for(let i = 0; i < pred_array.length; i++){
                    pred_array[i] = pred_array[i].split(",");
                };
                img.onload=()=>{
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    for(let i = 0; i < pred_array.length; i++){
                        let j = pred_array[i];
                        ctx.fillStyle = "red";
                        ctx.lineWidth = 3;
                        ctx.strokeRect(j[1], j[2], j[3], j[4]);
                        ctx.font = "bold 2em Arial";
                        ctx.fillText(j[0], j[1], j[2]-10);
                    };
                };
                console.log(pred_array);
            };
        };
    </script>
</html>