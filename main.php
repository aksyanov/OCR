<?php
require_once('Neuron.php');

function OCR($arrayOfNeurons,$arrayOfImage){

    foreach($arrayOfImage as $image){
        foreach($arrayOfNeurons as $neuron){
            $neuron->output = 0;
        }
        $arrayOCR = readImage($image);
        for($y = 0;$y < count($arrayOCR);$y++){
            for($x = 0;$x < count($arrayOCR[$y]);$x++){
                foreach($arrayOfNeurons as $neuron){
                    if($neuron->memory[$y][$x] == $arrayOCR[$y][$x])
                        $neuron->output++;
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

function readImage($pathToImg){
    $image = imagecreatefromjpeg($pathToImg);
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


$neuronA = new Neuron();
$neuronA->name = 'А';
$neuronA->readImage('testA1.jpg',true);

$neuronB = new Neuron();
$neuronB->name = 'Б';
$neuronB->readImage('testB1.jpg',true);

$neuronV = new Neuron();
$neuronV->name = 'В';
$neuronV->readImage('testV1.jpg',true);


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










