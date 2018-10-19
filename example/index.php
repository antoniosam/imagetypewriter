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
    if(!file_exists($dir_subida)){
        mkdir($dir_subida,0777, true);
    }
    $postvalida = false;

    if( ($_FILES['imagen']['name']!='') ){
        $fichero_subido = $dir_subida . basename($_FILES['imagen']['name']);
        $postvalida = false;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
            $postvalida = true;
        }
    }elseif ( isset($_POST['continuar']) ) {
        $fichero_subido = $_POST['continuar'];
        $postvalida = true;
    }

    if($postvalida){
        $tw = new \Ast\ImageTypewriter\ImageTypewriter(false);
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
            height: 19px;
        }
        .renglon.maker{
            font-size: 1.5rem;
            height: 15px;
                width: 220%;
        }
        .singlechar{
            width: 18px;
            height: 20px;
            display: inline-block;
            background-size: 18px 20px;
        }
        .charA{background-image: url("../src/files/letras/A.jpg");}
        .charB{background-image: url("../src/files/letras/B.jpg");}
        .charC{background-image: url("../src/files/letras/C.jpg");}
        .charD{background-image: url("../src/files/letras/D.jpg");}
        .charE{background-image: url("../src/files/letras/E.jpg");}
        .charF{background-image: url("../src/files/letras/F.jpg");}
        .charG{background-image: url("../src/files/letras/G.jpg");}
        .charH{background-image: url("../src/files/letras/H.jpg");}
        .charI{background-image: url("../src/files/letras/I.jpg");}
        .charJ{background-image: url("../src/files/letras/J.jpg");}
        .charK{background-image: url("../src/files/letras/K.jpg");}
        .charL{background-image: url("../src/files/letras/L.jpg");}
        .charM{background-image: url("../src/files/letras/M.jpg");}
        .charN{background-image: url("../src/files/letras/N.jpg");}
        .charO{background-image: url("../src/files/letras/O.jpg");}
        .charP{background-image: url("../src/files/letras/P.jpg");}
        .charQ{background-image: url("../src/files/letras/Q.jpg");}
        .charR{background-image: url("../src/files/letras/R.jpg");}
        .charS{background-image: url("../src/files/letras/S.jpg");}
        .charT{background-image: url("../src/files/letras/T.jpg");}
        .charU{background-image: url("../src/files/letras/U.jpg");}
        .charV{background-image: url("../src/files/letras/V.jpg");}
        .charW{background-image: url("../src/files/letras/W.jpg");}
        .charX{background-image: url("../src/files/letras/X.jpg");}
        .charY{background-image: url("../src/files/letras/Y.jpg");}
        .charZ{background-image: url("../src/files/letras/Z.jpg");}
        .char2{background-image: url("../src/files/letras/2.jpg");}
        .char3{background-image: url("../src/files/letras/3.jpg");}
        .char4{background-image: url("../src/files/letras/4.jpg");}
        .char5{background-image: url("../src/files/letras/5.jpg");}
        .char6{background-image: url("../src/files/letras/6.jpg");}
        .char7{background-image: url("../src/files/letras/7.jpg");}
        .char8{background-image: url("../src/files/letras/8.jpg");}
        .char9{background-image: url("../src/files/letras/9.jpg");}
        .char_A{background-image: url("../src/files/letras/_A.jpg");}
        .char_B{background-image: url("../src/files/letras/_B.jpg");}
        .char_C{background-image: url("../src/files/letras/_C.jpg");}
        .char_D{background-image: url("../src/files/letras/_D.jpg");}
        .char_E{background-image: url("../src/files/letras/_E.jpg");}
        .char_F{background-image: url("../src/files/letras/_F.jpg");}
        .char_G{background-image: url("../src/files/letras/_G.jpg");}
        .char_H{background-image: url("../src/files/letras/_H.jpg");}
        .char_I{background-image: url("../src/files/letras/_I.jpg");}
        .char_J{background-image: url("../src/files/letras/_J.jpg");}
        .char_K{background-image: url("../src/files/letras/_K.jpg");}
        .char_L{background-image: url("../src/files/letras/_L.jpg");}
        .char_M{background-image: url("../src/files/letras/_M.jpg");}
        .char_N{background-image: url("../src/files/letras/_N.jpg");}
        .char_O{background-image: url("../src/files/letras/_O.jpg");}
        .char_P{background-image: url("../src/files/letras/_P.jpg");}
        .char_Q{background-image: url("../src/files/letras/_Q.jpg");}
        .char_R{background-image: url("../src/files/letras/_R.jpg");}
        .char_S{background-image: url("../src/files/letras/_S.jpg");}
        .char_T{background-image: url("../src/files/letras/_T.jpg");}
        .char_U{background-image: url("../src/files/letras/_U.jpg");}
        .char_V{background-image: url("../src/files/letras/_V.jpg");}
        .char_W{background-image: url("../src/files/letras/_W.jpg");}
        .char_X{background-image: url("../src/files/letras/_X.jpg");}
        .char_Y{background-image: url("../src/files/letras/_Y.jpg");}
        .char_Z{background-image: url("../src/files/letras/_Z.jpg");}
        .char_-{background-image: url("../src/files/letras/_-.jpg");}
        .char_semi{background-image: url("../src/files/letras/_semi.jpg");}
        .char_excl{background-image: url("../src/files/letras/_excl.jpg");}
        .char_quest{background-image: url("../src/files/letras/_quest.jpg");}
        .char_apos{background-image: url("../src/files/letras/_apos.jpg");}
        .char_quot{background-image: url("../src/files/letras/_quot.jpg");}
        .char_lpar{background-image: url("../src/files/letras/_lpar.jpg");}
        .char_rpar{background-image: url("../src/files/letras/_rpar.jpg");}
        .char_slash{background-image: url("../src/files/letras/_slash.jpg");}
        .char_amp{background-image: url("../src/files/letras/_amp.jpg");}
        .char_num{background-image: url("../src/files/letras/_num.jpg");}
        .char_percnt{background-image: url("../src/files/letras/_percnt.jpg");}
        .char_plus{background-image: url("../src/files/letras/_plus.jpg");}
        .char_equal{background-image: url("../src/files/letras/_equal.jpg");}
        .char_currency{background-image: url("../src/files/letras/_currency.jpg");}
        .char_space{background-image: url("../src/files/letras/_space.jpg");}

        .char
        {
            font-family:'Conv_rm_typerighter_medium',Sans-Serif;
            font-size: 25px;
            width: 10px;
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
            <input type="hidden" name="continuar" value="<?php echo $fichero_subido; ?>" />
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