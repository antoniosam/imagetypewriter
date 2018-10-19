<?php
/**
 * Created by PhpStorm.
 * User: marcosamano
 * Date: 17/09/18
 * Time: 12:10 PM
 */

namespace Ast\ImageTypewriter;

use Ast\ColorImage\ColorImage;

class ImageTypewriter
{
    private $mapa = [];
    private $BASE_SIZE_X = 15;
    private $BASE_SIZE_Y = 16;

    private $resource;
    private $thumb;

    private $DIR_STOCK = 'stock';

    private $universo = [
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z',
        '_a',
        '_b',
        '_c',
        '_d',
        '_e',
        '_f',
        '_h',
        '_i',
        '_k',
        '_l',
        '_m',
        '_n',
        '_o',
        '_r',
        '_s',
        '_t',
        '_u',
        '_v',
        '_w',
        '_x',
        '_z',
        "2",
        '3',
        '4',
        '5',
        '6',
        '7',
        "8",
        '9',
        '_-',
        '_semi',//;
        '_excl',//!
        '_quest',//?
        '_apos',//'
        '_quot',//"
        '_lpar',//(
        '_rpar',//)
        '_slash',//  /
        '_amp',// &
        '_num',// #
        '_percnt',// %
        '_plus',//+,
        '_equal',//=
        '_currency',// $
        '_space'
    ];

    private $character_biggers = ['_lpar','_rpar','_slash','_num','_percnt','3','9'];

    private $character_makers = ['_semi'=>';',
        '_excl'=>'!',
        '_quest'=>'?',
        '_apos'=>"'",
        '_quot'=>'"',
        '_lpar'=>'(',
        '_rpar'=>')',
        '_slash'=>'/',
        '_amp'=>'&',
        '_num'=>'#',
        '_percnt'=>'%',
        '_plus'=>'+',
        '_equal'=>'=',
        '_currency'=>'$',
        '_space'=>'space '];


    const FILTER_NONE = 1;
    const FILTER_GRAY = 2;
    const FILTER_MEAN_BRIGHTNESS = 3;
    const FILTER_MEAN_REMOVAL = 4;
    const FILTER_EDGEDETECT = 5;

    private $includelarge = false;

    function __construct($includelarge = true)
    {
        $this->includelarge = $includelarge;
    }

    public function createAndSaveThumb($filename,$destino,$width,$filter = self::FILTER_NONE,$indice = null){

        $DS = DIRECTORY_SEPARATOR;
        $ext = pathinfo($filename)['extension'];
        if($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png'){
            if($ext == 'jpeg' || $ext == 'jpg'){
                $this->resource = imagecreatefromjpeg($filename);
            }elseif ($ext == 'png'){
                $this->resource = imagecreatefrompng($filename);
            }
            $this->createThumb($width,$filter,$indice);
            imagepng($this->thumb,$destino);
            return $destino;
        }
        return null;
    }



    public function proccessImage($filename, $characters = 60,$filter = self::FILTER_NONE,$indice = null)
    {
        $this->initImage($filename, $characters,$filter,$indice);
        return $this->renderHtml();
    }

    public function initImage($filename, $characters = 60,$filter = 1,$indice = null)
    {
        $ext = pathinfo($filename)['extension'];

        if (file_exists($filename)) {
            if($ext == 'jpeg' || $ext == 'jpg'){
                $this->resource = imagecreatefromjpeg($filename);
            }elseif ($ext == 'png'){
                $this->resource = imagecreatefrompng($filename);
            }
            $this->process($characters,$filter,$indice);
        } else {
            echo 'No se encontro';
        }
    }

    function renderHtml()
    {
        if (count($this->mapa) > 0) {
            $html = '<br/>';
            foreach ($this->mapa as $renglon) {
                $html .= '<p class="renglon">';
                foreach ($renglon as $letra) {
                    $html .= '<span class="singlechar char'.$letra.'"></span>';
                }
                $html .= '</p>';
            }
            return $html;
        }
        return 'Empty';
    }

    public function renderMaker(){
        if (count($this->mapa) > 0) {
            $html = '<br/>';
            $anterior = '';
            foreach ($this->mapa as $i=>$renglon) {
                $html .= '<p class="renglon maker">';
                $anterior = '';
                $cont = 0;
                foreach ($renglon as $character) {
                    $letra = isset($this->character_makers[$character])?$this->character_makers[$character]:str_replace('_','',$character);
                    if ($anterior == '') {
                        $anterior = $letra;
                        $cont = 1;
                    } else {
                        if ($anterior == $letra) {
                            $cont++;
                        } else {
                            $html .= '<span > '.$anterior .' ('. $cont.'), </span>';
                            $anterior = $letra;
                            $cont = 1;
                        }
                    }
                }
                $html .= '<span > '.$anterior.' ('. $cont.'), </span>';
                $html .= '</p><br/>';
            }
            return $html;
        }
        return 'Empty';
    }

    private function process($characters,$filter,$indice)
    {
        $this->createThumb($characters,$filter,$indice);
        $info = ColorImage::getInfo($this->thumb);
        $paletacolores = $this->getPalete($info->getMinPixel(), $info->getMaxPixel());
        $this->mapa = [];
        foreach ($info->getPixels() as $cont => $fila) {
            foreach ($fila as $pixel) {
                $this->mapa[$cont][] = $paletacolores[$pixel];
            }
        }
    }

    private function createThumb($characters,$filter,$indice = null)
    {
        $oldancho = imagesx($this->resource);
        $oldalto = imagesy($this->resource);

        $ancho = $characters;
        $alto = (int)floor((($oldalto * $ancho) / $oldancho));

        $this->thumb = imagecreatetruecolor($ancho, $alto);

        imagecopyresized($this->thumb, $this->resource, 0, 0, 0, 0, $ancho, $alto, $oldancho, $oldalto);

        if($filter == self::FILTER_NONE){

        }elseif($filter == self::FILTER_NONE){
        }elseif($filter == self::FILTER_GRAY){
            imagefilter($this->thumb, IMG_FILTER_GRAYSCALE);
        }elseif($filter == self::FILTER_MEAN_BRIGHTNESS){
            imagefilter($this->thumb, IMG_FILTER_BRIGHTNESS,(is_null($indice)?-80:$indice));
            imagefilter($this->thumb, IMG_FILTER_GRAYSCALE);
        }elseif($filter == self::FILTER_MEAN_REMOVAL){
            imagefilter($this->thumb, IMG_FILTER_MEAN_REMOVAL);
            imagefilter($this->thumb, IMG_FILTER_GRAYSCALE);
        }elseif($filter == self::FILTER_EDGEDETECT){
            imagefilter($this->thumb, IMG_FILTER_EDGEDETECT);
            imagefilter($this->thumb, IMG_FILTER_BRIGHTNESS,(is_null($indice)?60:$indice));
        }

    }

    private function getPalete($min, $max)
    {
        $mapabase = $this->getMapaBase();
        $disponibles = count($mapabase);
        $densidad = $max - $min;
        $interval = (int)floor($densidad / $disponibles);
        $ajusteresiduo = $densidad  - ($interval * $disponibles);
        $paleta = [];
        $i = $min;
        $caracter = '';
        foreach ($mapabase as $pixel => $caracter) {
            if ($i < 255) {
                for ($j = 0; $j < $interval; $j++) {
                    $paleta [$i] = $caracter;
                    $i++;
                }
                if ($ajusteresiduo > 0) {
                    $paleta [$i] = $caracter;
                    $ajusteresiduo--;
                    $i++;
                }
            }

        }
        $paleta[$i] = $caracter;

        $mapabase = $this->getMapaBase(true);
        $claves = array_keys($mapabase);
        $index = [];
        $caracter = 'M';
        $inicio = $mapabase[$caracter];
        $fin  = 244;
        $count = 0;
        for ($i =1; $i < count($claves);$i++){
            $count = $inicio - $mapabase[$claves[$i]];
            $inicio = $mapabase[$claves[$i]];
            $index[] = [$claves[$i],($count*-1)];
        }
        $DS = DIRECTORY_SEPARATOR;
        $filename = __DIR__ . $DS . 'files' . $DS . 'log_map.json';
        file_put_contents($filename, json_encode($index));//for logs
        /*for($i = $inicio; $i<256;$i++){
            if(isset($mapabase[$i])){

            }
            if(isset($index[$caracter])){
                $index[$caracter]++;
            }else{
                $index[$caracter] = 1;
            }
        }

        $disponibles = count($mapabase);
        $densidad = $max - $min;*/


        return $paleta;
    }

    private function getMapaBase($dev = false)
    {
        $DS = DIRECTORY_SEPARATOR;
        $filename = __DIR__ . $DS . 'files' . $DS . 'log_map.json';

        $resouces = $this->getImageBase();
        $base = [];
        foreach ($resouces as $caracter => $resouce) {
            $base[$caracter] = ColorImage::getInfo($resouce)->getAvgPixel();
        }
        unset($resouces);
        asort($base);
        //file_put_contents($filename, json_encode($base));//for logs
        if($dev){
            return $base;
        }
        $mapabase = [];
        foreach ($base as $caracter => $pixel) {
            $mapabase[] = $caracter;
        }
        //file_put_contents($filename, json_encode($mapabase));//for logs

        return $mapabase;
    }
    private function getImageBase(){
        $DS = DIRECTORY_SEPARATOR;
        $resources = [];
        if($this->includelarge){
            $temp = $this->universo;
        }else{
            $temp = [];
            foreach ($this->universo as $character){
                if(!in_array($character,$this->character_biggers)){
                    $temp[] =  $character;
                }
            }
        }

        foreach ($temp as $caracter) {
            $resources[$caracter] = imagecreatefromjpeg(__DIR__ . $DS . 'files' . $DS . 'letras' . $DS . $caracter . '.jpg');
        }

        return $resources;
    }
    private function createStockImageBase($save = false)
    {
        $DS = DIRECTORY_SEPARATOR;
        $font = __DIR__ . $DS . 'files' . $DS . 'fuente' . $DS . 'rm_typerighter_medium.ttf';
        $resources = [];
        foreach ($this->universo as $caracter) {
            $im = imagecreatetruecolor($this->BASE_SIZE_X, $this->BASE_SIZE_Y);
            $white = imagecolorallocate($im, 255, 255, 255);
            $black = imagecolorallocate($im, 0, 0, 0);
            imagefilledrectangle($im, 0, 0, $this->BASE_SIZE_X, $this->BASE_SIZE_Y, $white);

            $char = str_replace('_', '', $caracter);
            $text = ($char == 'space')?' ':$char;
            $size = isset($this->adjust[$caracter]) ? $this->adjust[$caracter]['size'] : 27;
            $x = isset($this->adjust[$caracter]) ? $this->adjust[$caracter]['x'] : 1;
            $y = isset($this->adjust[$caracter]) ? $this->adjust[$caracter]['y'] : 12;
            imagettftext($im, $size, 0, $x, $y, $black, $font, $text);
            if ($save) {
                imagepng($im, $font = __DIR__ . $DS . 'files' . $DS . $this->DIR_STOCK . $DS . $caracter . '.png');
            }
            $resources[$caracter] = $im;
        }
        return $resources;

    }


}