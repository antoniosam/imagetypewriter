<?php
ini_set('memory_limit', -1);
set_time_limit (0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include  '../src/ImageTypewriter.php';
include '../vendor/autoload.php';
$postvalida = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $DS = DIRECTORY_SEPARATOR;
    $dir_subida = __DIR__.$DS.'img'.$DS;
    if(!isset($_POST['cotinuar'])){
        $fichero_subido = $dir_subida . basename($_FILES['imagen']['name']);
        $postvalida = false;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
            $postvalida = true;
        }
    }else{
        $fichero_subido = $_POST['cotinuar'];
        $postvalida = true;
    }
    if($postvalida){
        $tw = new \Ast\ImageTypewriter\ImageTypewriter();
        $tw->createAndSaveThumb($fichero_subido,$dir_subida.'temp.png',$_POST['caracteres'],$_POST['filtro'],$_POST['indice']);
    }

}
?>
<html lang="es">
<head>
    <title> Image to Machine Letter</title>
    <style>
        @font-face {
            font-family: 'Conv_rm_typerighter_medium';
            src: url('assets/fonts/rm_typerighter_medium.eot');
            src: local('☺'), url('assets/fonts/rm_typerighter_medium.woff') format('woff'), url('assets/fonts/rm_typerighter_medium.ttf') format('truetype'), url('assets/fonts/rm_typerighter_medium.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        .renglon{
            margin: 0px; padding: 0px;
            font-size: 1rem;
            display: block;
            height: 7px;
        }
        .renglon.maker{
            font-size: 1.5rem;
            height: 15px;
                width: 220%;
        }
        .char
        {
            font-family:'Conv_rm_typerighter_medium',Sans-Serif;
            font-size: 1rem;
            width: 7px;
            display: inline-block;
            text-align: center;
        }
        .renglon.maker span
        {
            font-family:'Conv_rm_typerighter_medium',Sans-Serif;
            font-size: 1.5rem;
            width: 20px;
        }
        h3{
            margin: 0 auto 0 200px; width: 500px; display: block;
        }
        form{
            margin: 0 auto 0 200px; width: 400px; display: block;
        }
        label{
            width: 100px;
            display: inline-block;
        }
        .row{
            margin-top: 10px;
            margin-bottom: 10px;
        }
        input[type="file"],
        input[type="text"],
        select{
            width: 295px;
            display: inline-block;
        }
        body{font-family: Arial,Sans-Serif;}
        .tab{
            margin: 0 auto 0 200px; width: 500px; display: block;
        }
    </style>
</head>
<body>
<?php $caracteres =  isset($_POST['caracteres'])?$_POST['caracteres']:70; ?>
<?php $filtro =  isset($_POST['filtro'])?$_POST['filtro']:0 ?>
<?php $indice =  (isset($_POST['indice']) && $_POST['indice'] != 0)?$_POST['indice']:(($filtro == 3)?-80:(($filtro == 5)? 60:0)) ?>
<h3>Selecciona la imagen y aplica los filtros que desees</h3>
<form method="POST" enctype="multipart/form-data" >
    <?php if ($postvalida){?>
        <div class="row">
            <label>Foto</label>
            <input type="text" name="cotinuar" value="<?php echo $fichero_subido; ?>" />
        </div>
    <?php }?>

    <div class="row">
        <label>Foto</label>
        <input type="file" name="imagen" value="" />
    </div>
    <div class="row">
        <label>Caracteres</label>
        <input type="text" name="caracteres" value="<?php echo $caracteres?>"  />
    </div>
    <div class="row">
        <label>Filtro</label>
        <select name="filtro"  >
            <option value="1" <?php if ($filtro == '1'){ echo 'selected';} ?>>Ninguno </option>
            <option value="2" <?php if ($filtro == '2'){ echo 'selected';} ?>>Escala de grises </option>
            <option value="3" <?php if ($filtro == '3'){ echo 'selected';} ?>>Brillo</option>
            <option value="4" <?php if ($filtro == '4'){ echo 'selected';} ?>>Remocion media</option>
            <option value="5" <?php if ($filtro == '5'){ echo 'selected';} ?>>Detectar borde</option>
        </select>
    </div>
    <div class="row">
        <label>Indice</label>
        <input type="text" name="indice" value="<?php echo $indice?>"  />
    </div>
    <div class="row"><input type="submit" value="Enviar"></div>
</form>
<?php if ($postvalida){?>
<div class="tab">
    <img src="img/temp.png" alt="temp.png" />
</div>
<?php
    $tw->initImage($dir_subida.'temp.png', $caracteres,$_POST['filtro'],$indice);
    echo $tw->renderHtml();
    echo $tw->renderMaker();
}
?>
</body>
</html>