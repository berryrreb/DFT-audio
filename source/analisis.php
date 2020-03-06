<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <title>DFT</title>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1>DFT</h1>
    </div>
    <div>
    <?php
        $dir_subida = '';
        $fichero_subido = $dir_subida . basename($_FILES['registro']['name']);
        $file_extension = pathinfo($_FILES["registro"]["name"], PATHINFO_EXTENSION);
        if ($file_extension == 'mp3' || $file_extension == 'wav'){
            if (move_uploaded_file($_FILES['registro']['tmp_name'], $fichero_subido))
                echo "<br><br>El fichero es válido y se subió con éxito.";
            else
                echo "<br><br>El archivo es válido pero ocurrió algún problema al subir.";
        } else
                echo "<br><br>El archivo proporcionado no es un archivo de audio válido (.mp3 | .wav)";     
    ?>
    </div>
    <div>
        <audio controls autoplay>
            <source src="<?php echo $fichero_subido; ?>" type="audio/mpeg">
            Ocurrió un problema con la reproducción de audio.
        </audio> 
    </div>
</div>
</body>
</html>