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
            echo"Seu arquivo está em processamento, recarrege a pagina";
        };
    }else{
        session_destroy();
        header('Location: /Spectrum');
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
    <style>
        .br-15{
            border-radius: 15px;
        }
    </style>
</head>
<body class="p-4 d-flex" style="height: 100vh; background-color: #212121;">
    <div class="w-100 d-flex align-items-center justify-content-center">
        <div class="p-4 d-flex flex-column align-items-center border br-15 text-light" style="background-color: #616161; width:400px;">
            <canvas id="Canvas" class="w-100 mb-4"></canvas>
            <a href="https://aaa9-2804-14d-4c84-8e1d-89fe-7c25-c255-aa47.sa.ngrok.io/Spectrum/unset.php" class="btn br-15 text-light" style="background-color: #424242;">Voltar</a>
        </div>
    </div>
    <script>
        let arq = '<?php echo $arq; ?>'
        console.log(arq)
        if(arq != ''){
            let canvas = document.getElementById('Canvas')
            let ctx= canvas.getContext('2d')
            let img = new Image()
            img.src = arq
            let pred = '<?php echo $pred; ?>'
            if(pred != 'vazio'){
                pred = pred.replace(/["]/g, '')
                let pred_array = pred.split("/")
                for(let i = 0; i < pred_array.length; i++){
                    pred_array[i] = pred_array[i].split(",")
                }
                img.onload=()=>{
                    let tamanholetra = 2
                    canvas.width = img.width
                    canvas.height = img.height
                    ctx.drawImage(img, 0, 0)

                    if((img.width*img.height) > 500000){
                        tamanholetra = 3
                    }
                    for(let i = 0; i < pred_array.length; i++){
                        let j = pred_array[i]
                        ctx.fillStyle = "red"
                        ctx.lineWidth = 3
                        ctx.strokeRect(j[1], j[2], j[3], j[4])
                        ctx.font = `bold ${tamanholetra}em Arial`
                        ctx.fillText(j[0], j[1], j[2]-10)
                    }
                }
            }
        }    
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>