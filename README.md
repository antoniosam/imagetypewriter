# Image TypeWritter

Es una libreria para convertir una imagen a caracteres de maquina de escribir
## Instalacion

```
composer require antoniosam/imagetypewriter

```
## Como Usarse
   
  ```
  $tw = new ImageTypewriter();
  $tw->initImage($filename, $caracteres_por_linea, $filtro , $indice);
  echo $tw->renderHtml();
  echo $tw->renderMaker();
  ```
  Tipos de Filtros
  ```
  ImageTypewriter::FILTER_NONE - Sin filtro 
  ImageTypewriter::FILTER_GRAY - Escala de grises
  ImageTypewriter::FILTER_MEAN_BRIGHTNESS - Brillo $indice es el valor del brillo
  ImageTypewriter::FILTER_MEAN_REMOVAL - Remocion media
  ImageTypewriter::FILTER_EDGEDETECT - Detecta los Bordes $indice es el valor de la deteccion
  ```
  
  Metodo **renderHtml**
  
  Imprime los caracteres resultantes de la convercion
  
  Metodo **renderMaker**
  
  Imprime los caracteres en orden para poder realizar la imagen en maquina de escribir 