<?php
require_once('Neuron.php');
require_once('ImageHelper.php');

function OCR($arrayOfNeurons,$arrayOfImage){

    foreach($arrayOfImage as $image){
        foreach($arrayOfNeurons as $neuron){
            $neuron->output = 0;
        }
        $arrayOCR = readImage($image);
        for($y = 0;$y < count($arrayOCR);$y++){
            for($x = 0;$x < count($arrayOCR[$y]);$x++){
                foreach($arrayOfNeurons as $neuron){
                    if($arrayOCR[$y][$x] > 0)
                        //if($neuron->memory[$y][$x] == $arrayOCR[$y][$x])
                        $neuron->output = $neuron->output + $neuron->memory[$y][$x];
                }
            }
        }

        $answer = '!_err';
        $maxOutput = 0;
        foreach($arrayOfNeurons as $neuron){
            if($neuron->output > $maxOutput){
                $maxOutput = $neuron->output;
                $answer = $neuron->name;
            }
        }

        echo $answer;
    }

    echo '<br>';

}

function resize($img,$width,$height){

    // Проверяем корректность введения ширины и высоты
    $width=filter_var($width,FILTER_VALIDATE_INT)?$width:false;
    $height=filter_var($height,FILTER_VALIDATE_INT)?$height:false;

    // Если ширина не указана или указана некорректно, то будет игнорироватся изменение масштаба изображения
    if(($width!='100'&&$height==false) or ($width!=false&&$height!=false)){
        $w_src = ImageSX($img);
        $h_src = ImageSY($img);

        // Если не указана высота, то по процентному соотношению вычисляем новый масштаб
        if($height==false){
            $height=($h_src/100)*$width;
            $width=($w_src/100)*$width;
        }

        $dest = imagecreatetruecolor($width,$height);

        if($height==$width){
            if ($w_src>$h_src) {
                imagecopyresized($dest, $img, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2), 0, $width, $height, min($w_src,$h_src), min($w_src,$h_src));
            } else {
                imagecopyresized($dest, $img, 0, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2), $width, $height, min($w_src,$h_src), min($w_src,$h_src));
            }
        } else {
            imagecopyresized($dest, $img, 0, 0, 0, 0, $width, $height, $w_src, $h_src);
        }

        $img=$dest;
        unset($dest);

    }
}

function readImage($pathToImg){
    $image = imagecreatefromjpeg($pathToImg);

    resize($image,50,50);

    $maxX = imagesx($image);
    $maxY = imagesy($image);

    $array = array(array());

    for($y = 0;$y < $maxY;$y++){
        for($x = 0;$x < $maxX;$x++){
            $array[$y][$x] = blackOrWhite(imagecolorsforindex($image,imagecolorat ($image , $x, $y)));
        }
    }
    imagedestroy($image);

    return $array;
}

function blackOrWhite($arrayColor){
    if($arrayColor['red'] >= 150 && $arrayColor['green'] >= 150 && $arrayColor['blue'] >= 150)
        return '1';
    else
        return '0';
}

/*$neuronA = new Neuron();
$neuronA->name = 'А';
$neuronA->readImage('testA1.jpg',true);
$neuronA->readImage('2.jpg',true);

$neuronB = new Neuron();
$neuronB->name = 'Б';
$neuronB->readImage('testB1.jpg',true);

$neuronV = new Neuron();
$neuronV->name = 'В';
$neuronV->readImage('testV1.jpg',true);
$neuronV->printImage(true);

$neuronA1 = new Neuron();
$neuronA1->name = 'A1';
$neuronA1->readImage('2.jpg',true);
$neuronA1->printImage(true);

$neuronA->printImage(true);

$arrayOfNeurons = array($neuronA,$neuronB,$neuronV);

//1 test
$arrayOfImage = array('testA1.jpg','testA2.jpg','testV2.jpg','testV1.jpg');
OCR($arrayOfNeurons,$arrayOfImage);

//2 test
$arrayOfImage = array('testB1.jpg','testV2.jpg','testV1.jpg','testA1.jpg');
OCR($arrayOfNeurons,$arrayOfImage);

//3 test
$arrayOfImage = array('testB1.jpg','testV2.jpg','testV1.jpg','testB1.jpg');
OCR($arrayOfNeurons,$arrayOfImage);

//4 test
$arrayOfImage = array('testA1Big.jpg');
OCR($arrayOfNeurons,$arrayOfImage);*/



/*$image = imagecreatefromjpeg('testA1Big.jpg');
$width = 50;
$height = 50;
$w_src = ImageSX($image);
$h_src = ImageSY($image);
$dest = imagecreatetruecolor($width,$height);
echo imagecopyresized($dest, $image, 0, 0, 0, 0, $width, $height, $w_src, $w_src);*/


$image = new ImageHelper('images/3x7/2.png');
$image->printArray();











